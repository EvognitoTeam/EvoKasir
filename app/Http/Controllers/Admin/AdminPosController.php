<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Mitra;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TableList;
use Illuminate\Support\Str;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminPosController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $menus = Menu::with('getCategory')->where('mitra_id', $mitra->id)->paginate(15);
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';
        $tables = TableList::where('mitra_id', $mitra->id)->get(); // ambil semua data meja

        return view('admin.pos.index', compact('menus', 'slug', 'notifSound', 'tables'));
    }

    public function storeOrder(Request $request, $slug)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'table_id' => 'required|integer|exists:table_list,id',
            'discount' => 'nullable|string',
            'name' => 'nullable|string',
            'email' => 'nullable|string',
        ]);

        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $orderCode = '';
        for ($i = 0; $i < 6; $i++) {
            $orderCode .= $characters[rand(0, strlen($characters) - 1)];
        }
        $totalPrice = 0;

        foreach ($request->items as $item) {
            $menu = Menu::findOrFail($item['id']);
            $totalPrice += $menu->price * $item['qty'];
        }

        // Hitung diskon (baik persen maupun angka langsung)
        $discountInput = trim($request->discount ?? '0');
        if (Str::endsWith($discountInput, '%')) {
            $percent = floatval(Str::replaceLast('%', '', $discountInput));
            $discount = $totalPrice * ($percent / 100);
        } else {
            $discount = floatval($discountInput);
        }

        $totalAfterDiscount = max($totalPrice - $discount, 0);

        $order = Order::create([
            'order_code' => $orderCode,
            'mitra_id' => $mitra->id,
            'user_id' => Auth::user()->id,
            'name' => $request->name, // ganti sesuai kolom kamu
            'email' => $request->email, // ganti sesuai kolom kamu
            'table_number' => $request->table_id, // ganti sesuai kolom kamu
            'payment_method' => 'cash', // default, bisa diubah
            'total_price' => $totalPrice,
            'discount' => $discount,
            'totalAfterDiscount' => $totalAfterDiscount,
            'status' => 'completed',
            'payment_status' => 2,
        ]);

        foreach ($request->items as $item) {
            $menu = Menu::findOrFail($item['id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $menu->id,
                'price' => $menu->price,
                'quantity' => $item['qty'],
                'mitra_id' => $mitra->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_code' => $order->order_code,
            'total_after_discount' => $totalAfterDiscount,
        ]);
    }
}
