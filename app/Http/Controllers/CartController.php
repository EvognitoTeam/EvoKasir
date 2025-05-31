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
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        // Add to cart logic
        $menu = Menu::findOrFail($id);
        $cart = session()->get("cart.$slug", []);
        $existingNotes = isset($cart[$id]['notes']) ? $cart[$id]['notes'] : '';
        $newNotes = $request->input('notes', $existingNotes); // Gunakan catatan baru atau pertahankan yang lama

        $cart[$id] = [
            'id' => $menu->id,
            'name' => $menu->name,
            'price' => $menu->price,
            'image' => $menu->image,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + $request->quantity,
            'notes' => $newNotes,
        ];
        session()->put("cart.$slug", $cart);

        return response()->json(['success' => true, 'message' => 'Menu ditambahkan ke keranjang']);
    }

    public function count($slug)
    {
        $cart = session()->get("cart.$slug", []);
        $count = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $count]);
    }

    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $cart = session()->get("cart.$slug", []);
        $totalPrice = 0;
        $stockMessages = [];

        // Check stock and adjust cart
        foreach ($cart as $menuId => &$item) {
            $menu = Menu::find($menuId);
            if ($menu && $menu->stock < $item['quantity']) {
                $oldQuantity = $item['quantity'];
                $item['quantity'] = max(0, min($menu->stock, $item['quantity']));
                if ($item['quantity'] < $oldQuantity) {
                    $stockMessages[] = "Jumlah pesanan untuk {$item['name']} telah disesuaikan karena stok berkurang. Stok tersedia: {$menu->stock}.";
                }
                if ($item['quantity'] == 0) {
                    unset($cart[$menuId]);
                }
            }
            $totalPrice += $item['price'] * $item['quantity'];
        }
        unset($item); // Break reference

        // Update session
        session()->put("cart.$slug", $cart);
        session()->put("totalPrice.$slug", $totalPrice);

        // Flash stock messages
        if (!empty($stockMessages)) {
            session()->flash('stock_warnings', $stockMessages);
        }

        return view('main.cart.index', compact('mitra', 'cart', 'totalPrice', 'slug'));
    }

    public function remove($slug, $id)
    {
        $cart = session()->get("cart.$slug", []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put("cart.$slug", $cart);
        }
        if (empty($cart)) {
            session()->forget("cart.$slug");
            session()->forget("discount.$slug");
            session()->forget("discount_code.$slug");
            session()->forget("totalPrice.$slug");
            session()->forget("applied_coupon.$slug");
        }
        return redirect()->route('cart.index', ['slug' => $slug])->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function updateCart(Request $request, $slug, $id)
    {
        $cart = session()->get("cart.$slug", []);
        if (!isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        // Update quantity
        if ($request->has('quantity')) {
            $cart[$id]['quantity'] = $request->quantity;
        }

        session()->put("cart.$slug", $cart);

        // Recalculate total price and apply coupon if exists
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Apply coupon if exists
        if (session("discount.$slug")) {
            $totalPrice -= session("discount.$slug");
        }

        session()->put("totalPrice.$slug", $totalPrice);
        return response()->json(['new_total' => $totalPrice, 'success' => true]);
    }

    public function decrease(Request $request, $slug, $id)
    {
        $cart = session()->get("cart.$slug", []);
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity'] -= 1;
            } else {
                unset($cart[$id]);
            }
            session()->put("cart.$slug", $cart);
        }
        return redirect()->route('cart.index', $slug)->with('success', 'Item dikurangi.');
    }

    public function applyCoupon(Request $request, $slug)
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
            $totalPrice = session("totalPrice.$slug", 0);

            if ($totalPrice <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total harga tidak valid atau belum tersedia.'
                ]);
            }

            // Jika ada discount_price, tentukan diskon maksimal
            $discount = $coupon->discount_price ?? 0;

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
                "totalPrice.$slug" => $newTotalPrice,
                "discount.$slug" => $discount,
                "applied_coupon.$slug" => $coupon_code
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
        $coupon_code = session("applied_coupon.$slug");
        $coupon = Coupon::validateCoupon($coupon_code);
        if ($coupon && $coupon->already_used > 0) {
            $coupon->decrement('already_used');
        }

        // Menghapus kupon dari session
        session()->forget(["discount.$slug", "applied_coupon.$slug"]);

        // Menghitung ulang total harga
        $cart = session()->get("cart.$slug", []);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        session()->put("totalPrice.$slug", $totalPrice);

        return redirect()->route('cart.index', ['slug' => $slug])->with('success', 'Kupon berhasil dihapus.');
    }

    public function checkout($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $cart = session()->get("cart.$slug", []);

        // Cek apakah cart kosong
        if (empty($cart)) {
            return redirect()->route('menu.index', ['slug' => $slug])
                ->withErrors(['cart' => 'Keranjang belanja Anda kosong. Silakan pilih menu terlebih dahulu.']);
        }

        $tables = TableList::where('mitra_id', $mitra->id)->get();
        $totalPrice = session("totalPrice.$slug", 0);

        return view('main.cart.checkout', compact('cart', 'totalPrice', 'slug', 'tables', 'mitra'));
    }

    public function updateNotes(Request $request, $slug)
    {
        $request->validate([
            'id' => 'required|integer',
            'notes' => 'nullable|string|max:255',
        ]);

        $id = $request->input('id');
        $notes = $request->input('notes', '');

        // Ambil keranjang dari session
        $cart = session()->get("cart.$slug", []);

        // Perbarui catatan untuk item tertentu
        if (isset($cart[$id])) {
            $cart[$id]['notes'] = $notes;
            session()->put("cart.$slug", $cart);
            return response()->json([
                'success' => true,
                'message' => 'Catatan berhasil diperbarui.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan.'
        ], 404);
    }
}
