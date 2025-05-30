<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Mitra;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\TableList;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function add(Request $request, $slug, $id)
    {
        // Validate request
        $request->validate(['quantity' => 'required|integer|min:1']);

        // Add to cart logic (e.g., session or database)
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);
        $cart[$id] = [
            'id' => $menu->id,
            'name' => $menu->name,
            'price' => $menu->price,
            'image' => $menu->image,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + $request->quantity,
        ];
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Menu added to cart']);
    }

    public function count($slug)
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $count]);
    }

    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $cart = session('cart', []);
        $totalPrice = 0;

        // Menghitung total harga
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity']; // harga * jumlah
        }
        session()->put('totalPrice', $totalPrice);

        return view('main.cart.index', compact('mitra', 'cart', 'totalPrice', 'slug'));
    }

    public function remove($slug, $id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        if (empty($cart)) {
            session()->forget('cart');
            session()->forget('discount');
            session()->forget('discount_code');
            session()->forget('totalPrice');
            session()->forget('applied_coupon');
        }
        return redirect()->route('cart.index', ['slug' => $slug])->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    public function updateCart(Request $request, $slug, $id)
    {
        $cart = session()->get('cart');
        $item = $cart[$id];

        // Update quantity or add new item to cart
        if ($request->has('quantity')) {
            $cart[$id]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);

        // Recalculate total price and apply coupon if exists
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Apply coupon if exists
        if (session('discount')) {
            $totalPrice -= session('discount');
        }

        session()->put('totalPrice', $totalPrice);
        return response()->json(['new_total' => $totalPrice, 'success' => true]);
    }


    public function decrease(Request $request, $slug, $id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity'] -= 1;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index', $slug)->with('success', 'Item dikurangi.');
    }

    public function applyCoupon(Request $request)
    {
        // Ambil data kupon dari input
        $coupon_code = $request->coupon_code;

        // Validasi input kosong
        if (!$coupon_code) {
            return response()->json(['success' => false, 'message' => 'Kode kupon wajib diisi.']);
        }

        // Validasi kupon
        $coupon = Coupon::validateCoupon($coupon_code);

        if ($coupon) {
            // Cek apakah kupon sudah melebihi batas pemakaian
            if ($coupon->max_use && $coupon->already_used >= $coupon->max_use) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kupon sudah mencapai batas penggunaan.'
                ]);
            }

            // Ambil total harga dari session
            $totalPrice = session('totalPrice', 0);

            if ($totalPrice <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total harga tidak valid atau belum tersedia.'
                ]);
            }

            // Jika ada discount_price, tentukan diskon maksimal
            if ($coupon->discount_price) {
                $discount = $coupon->discount_price;
            }

            // Jika ada discount_rate, hitung diskon persentase
            if ($coupon->discount_rate) {
                $discount_rate = $totalPrice * ($coupon->discount_rate / 100);
                // Bandingkan diskon rate dengan discount_price, dan ambil yang lebih kecil
                $discount = min($discount, $discount_rate);
            }

            // Pastikan diskon tidak melebihi total harga
            $discount = min($discount, $totalPrice);

            // Update total harga setelah diskon
            $newTotalPrice = $totalPrice - $discount;

            // Perbarui jumlah pemakaian kupon
            $coupon->increment('already_used');

            // Simpan total harga dan diskon ke session
            session([
                'totalPrice' => $newTotalPrice,
                'discount' => $discount,
                'applied_coupon' => $coupon_code
            ]);

            return response()->json([
                'success' => true,
                'new_total' => $newTotalPrice,
                'discount' => $discount,
                'formatted_total' => 'Rp' . number_format($newTotalPrice, 0, ',', '.'),
                'formatted_discount' => 'Rp' . number_format($discount, 0, ',', '.'),
                'message' => 'Kupon berhasil diterapkan.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak valid atau sudah kadaluarsa.'
            ]);
        }
    }

    public function removeCoupon($slug)
    {
        $coupon_code = session('applied_coupon');
        $coupon = Coupon::validateCoupon($coupon_code);
        if (!$coupon) {
            return back()->with('error', 'Kupon tidak valid atau sudah kadaluarsa.');
        }
        $coupon->already_used > 0 ? $coupon->decrement('already_used') : null;

        // Menghapus kupon dari session
        session()->forget('discount');
        session()->forget('discount_code');
        session()->forget('applied_coupon');

        // Menghitung ulang total harga setelah kupon dihapus
        $cart = session()->get('cart', []);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }


        // Menyimpan kembali total price setelah kupon dihapus
        session()->put('totalPrice', $totalPrice);

        // Mengembalikan respon JSON
        return back()->with('success', 'Kupon berhasil dihapus.');
        // return response()->json(['success' => true, 'message' => 'Kupon berhasil dihapus.']);
    }

    public function checkout($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        $cart = session('cart', []);

        // Cek apakah cart kosong
        if (empty($cart)) {
            return redirect()->route('menu.index', ['slug' => $slug])
                ->withErrors(['cart' => 'Keranjang belanja Anda kosong. Silakan pilih menu terlebih dahulu.']);
        }

        $tables = TableList::where('mitra_id', $mitra->id)->get();

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('main.cart.checkout', compact('cart', 'totalPrice', 'slug', 'tables', 'mitra'));
    }
}
