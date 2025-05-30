<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Mitra;
use App\Models\Order;
use GuzzleHttp\Client;
use App\Models\OrderItem;
use App\Models\TableList;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $table = TableList::where('mitra_id', $mitra->id)
            ->where('table_code', session('table'))
            ->first();

        // Generate order code
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $order_code = '';
        for ($i = 0; $i < 6; $i++) {
            $order_code .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Ambil dari session
        $cartItems = session('cart', []);
        $totalPrice = session('totalPrice', 0);
        // dd($totalPrice);
        $discount = session('discount', 0);
        $totalAfterDiscount = $totalPrice;

        if ($totalPrice < 1) {
            return back()->with('error', 'Total pembayaran harus lebih dari Rp1.' . $discount);
        }

        // Simpan order awal
        $order = Order::create([
            'order_code' => $order_code,
            'mitra_id' => $mitra->id,
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'name' => $request->name,
            'email' => $request->email,
            'total_price' => $totalPrice,
            'table_number' => $table->id,
            'discount' => $discount,
            'totalAfterDiscount' => $totalAfterDiscount,
            'payment_method' => $request->payment_method,
            'payment_status' => 1,
        ]);

        foreach ($cartItems as $item) {
            // dd($item);
            OrderItem::create([
                'order_id' => $order->id,
                'mitra_id' => $mitra->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            // Kurangi stok produk
            $product = Menu::find($item['id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        if ($request->payment_method === 'qris') {
            $midtrans = new MidtransService();

            $customer = [
                'first_name' => $request->name ?? 'Evognito User',
                'email' => $request->email ?? 'chat.evognitoteam@gmail.com',
            ];

            // Format item untuk Midtrans
            $items = collect($cartItems)
                ->values()
                ->map(fn($item) => [
                    'id' => (string) $item['id'],
                    'price' => (int) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'name' => (string) $item['name'],
                ])
                ->toArray();
            if ($discount > 0) {
                $items[] = [
                    'id' => 'DISCOUNT',
                    'price' => -1 * (int) $discount, // harus negatif
                    'quantity' => 1,
                    'name' => 'Diskon',
                ];
            }


            $itemTotal = collect($items)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            if ($itemTotal != $totalAfterDiscount) {
                return back()->with('error', 'Jumlah item tidak sesuai dengan total pembayaran.');
            }
            Log::info('Request to Midtrans', [
                'order_code' => $order_code,
                'gross_amount' => $totalAfterDiscount,
                'customer' => $customer,
                'items' => $items,
            ]);

            try {
                $transaction = $midtrans->createTransaction($order_code, $totalAfterDiscount, $customer, $items, $mitra->mitra_name);

                // dd($transaction);

                // Update order dengan data Midtrans
                $order->update([
                    'qr_url' => $transaction->actions[0]->url ?? null,
                    'qr_string' => $transaction->qr_string ?? null,
                    'transaction_id' => $transaction->transaction_id ?? null,
                    'payment_type' => $transaction->payment_type,
                    'expiry_time' => $transaction->expiry_time,
                ]);

                session()->forget(['cart', 'totalPrice', 'discount']);

                return redirect()->route('checkout.qris', [
                    'slug' => $slug,
                    'order_code' => $order_code,
                    'order' => $order,
                    'transaction_id' => $transaction->transaction_id,
                    'qr_url' => $transaction->actions[0]->url,
                ]);
            } catch (\Exception $e) {
                Log::error('Midtrans error: ' . $e->getMessage());
                return back()->with('error', 'QRIS QR code tidak ditemukan: ' . $e->getMessage());
            }
        }

        // $table->update(['status' => '0']);

        session()->forget(['cart', 'totalPrice', 'discount']);

        return redirect()->route('checkout.success', [
            'slug' => $slug,
            'order_code' => $order_code,
        ]);
    }

    public function showQris(Request $request, $slug, $order_code)
    {
        $qris_url = $request->query('qr_url');

        if (!$qris_url) {
            return back()->with('error', 'QRIS URL tidak ditemukan.');
        }

        $order = Order::where('order_code', $order_code)->firstOrFail();
        $expiry_time = $order->expiry_time; // Pastikan kolom ini ada di tabel orders

        return view('main.cart.checkout_qris', [
            'slug' => $slug,
            'order_code' => $order_code,
            'qris_url' => $qris_url,
            'expiry_time' => $expiry_time, // dikirim ke view
        ]);
    }

    public function checkoutSuccess($slug, $order_code)
    {

        // Ambil data order berdasarkan order_code
        $order = Order::with('mitra')->where('order_code', $order_code)->first();

        // Jika order tidak ditemukan, redirect ke halaman lain atau tampilkan pesan error
        if (!$order) {
            return redirect()->route('menu.index', ['slug' => $slug])->with('error', 'Order tidak ditemukan.');
        }

        // Ambil total yang dibayar dari session
        $totalPaid = $order->totalAfterDiscount;

        // Tampilkan halaman sukses checkout
        return view('main.cart.success', compact('order', 'order_code', 'totalPaid', 'slug'));
    }

    public function checkoutFailed($slug, $order_code)
    {

        // Ambil data order berdasarkan order_code
        $order = Order::with('mitra')->where('order_code', $order_code)->first();

        // Jika order tidak ditemukan, redirect ke halaman lain atau tampilkan pesan error
        if (!$order) {
            return redirect()->route('menu.index', ['slug' => $slug])->with('error', 'Order tidak ditemukan.');
        }

        // Ambil total yang dibayar dari session
        $totalPaid = $order->totalAfterDiscount;

        // Tampilkan halaman sukses checkout
        return view('main.cart.failed', compact('order', 'order_code', 'totalPaid', 'slug'));
    }
}
