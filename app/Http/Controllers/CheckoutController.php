<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Order;
use GuzzleHttp\Client;
use App\Models\OrderItem;
use App\Models\TableList;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request, $slug)
    {
        // dd($request);
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $cashier = User::where('mitra_id', $mitra->id)
            ->where('role', 'Cashier')
            ->where('is_login', 1)
            ->first();
        $tableCode = session('table');
        $tableQuery = TableList::where('mitra_id', $mitra->id);

        $table = $tableCode
            ? $tableQuery->where('table_code', $tableCode)->firstOrFail()
            : $tableQuery->where('id', $request->table_number)->firstOrFail();


        // dd($table);
        // Generate order code
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $order_code = '';
        for ($i = 0; $i < 6; $i++) {
            $order_code .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Ambil dari session
        $cartItems = session("cart.$slug", []);
        $totalPrice = session("totalPrice.$slug", 0);
        $discount = session("discount.$slug", 0);
        $totalAfterDiscount = $totalPrice;
        // dd($totalPrice);

        if ($totalPrice < 1) {
            return back()->with('error', 'Total pembayaran harus lebih dari Rp1.');
        }

        // Simpan order awal
        $order = Order::create([
            'order_code' => $order_code,
            'mitra_id' => $mitra->id,
            'cashier_id' => isset($cashier) ? $cashier->id : null,
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
            OrderItem::create([
                'order_id' => $order->id,
                'mitra_id' => $mitra->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'notes' => $item['notes'] ?? null, // Simpan catatan jika ada
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

                // Update order dengan data Midtrans
                $order->update([
                    'qr_url' => $transaction->actions[0]->url ?? null,
                    'qr_string' => $transaction->qr_string ?? null,
                    'transaction_id' => $transaction->transaction_id ?? null,
                    'payment_type' => $transaction->payment_type,
                    'expiry_time' => $transaction->expiry_time,
                ]);

                ActivityHelper::createActivity(
                    description: 'Pesanan Dibuat : QRIS',
                    activityType: 'checkout',
                    mitraId: $mitra->id,
                    userId: Auth::id(),
                    request: $request
                );

                session()->forget(["cart.$slug", "totalPrice.$slug", "discount.$slug", "applied_coupon.$slug"]);

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

        ActivityHelper::createActivity(
            description: 'Pesanan Dibuat : Cash',
            activityType: 'checkout',
            mitraId: $mitra->id,
            userId: Auth::check() ? Auth::id() : null,
            request: $request
        );

        session()->forget(["cart.$slug", "totalPrice.$slug", "discount.$slug", "applied_coupon.$slug"]);

        return redirect()->route('checkout.success', [
            'slug' => $slug,
            'order_code' => $order_code,
        ]);
    }

    public function showQris(Request $request, $slug, $order_code)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $qris_url = $request->query('qr_url');

        if (!$qris_url) {
            return back()->with('error', 'QRIS URL tidak ditemukan.');
        }

        $order = Order::where('order_code', $order_code)->firstOrFail();
        $expiry_time = $order->expiry_time; // Pastikan kolom ini ada di tabel orders

        ActivityHelper::createActivity(
            description: 'Show QRIS',
            activityType: 'checkout',
            mitraId: $mitra->id,
            userId: Auth::check() ? Auth::id() : null,
            request: $request
        );

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

        // Cari meja berdasarkan ID dari input (table_number)
        $table = TableList::where('id', $order->table_number)->first();

        // Pastikan meja ditemukan
        if (!$table) {
            return redirect()->back()->with('error', 'Meja tidak ditemukan.');
        }

        // Update status meja
        $table->update([
            'status' => 2,
        ]);

        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        ActivityHelper::createActivity(
            description: 'Success Checkout with: ' . $order->payment_method,
            activityType: 'checkout',
            mitraId: $mitra->id,
            userId: Auth::check() ? Auth::id() : null,
        );

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

        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        ActivityHelper::createActivity(
            description: 'Success failed with: ' . $order->payment_method,
            activityType: 'checkout',
            mitraId: $mitra->id,
            userId: Auth::check() ? Auth::id() : null,
        );

        // Tampilkan halaman sukses checkout
        return view('main.cart.failed', compact('order', 'order_code', 'totalPaid', 'slug'));
    }
}
