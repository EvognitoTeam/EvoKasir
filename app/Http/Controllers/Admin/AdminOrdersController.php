<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOrdersController extends Controller
{
    public function index($slug)
    {
        // Logic to display the orders list
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $orders = Order::with('table')->where('mitra_id', $mitra->id)->latest()->paginate(15);
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';


        return view('admin.orders.index', ['slug' => $slug, 'orders' => $orders, 'mitra' => $mitra, 'notifSound' => $notifSound]);
    }

    public function details($slug, $order_code)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $order = Order::with(['items.product', 'mitra', 'table'])->where('order_code', $order_code)->first();
        // dd($order);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        // dd($order);
        // Logic to print the order
        return view('admin.orders.detail', ['slug' => $slug, 'order' => $order, 'mitra' => $mitra, 'notifSound' => $notifSound]);
    }

    public function updateStatus(Request $request, $slug, $order_code)
    {
        $order = Order::where('order_code', $order_code)->firstOrFail();
        $request->validate(['status' => 'required|in:pending,completed,cancelled']);
        $order->update(['status' => $request->status]);
        return redirect()->route('admin.orders.detail', ['slug' => $slug, 'order_code' => $order_code])
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function updatePayment(Request $request, $slug, $order_code)
    {
        $order = Order::where('order_code', $order_code)->firstOrFail();
        $request->validate(['status' => 'required|in:1,2,3,4']);
        $order->update(['payment_status' => $request->status]);
        return redirect()->route('admin.orders.detail', ['slug' => $slug, 'order_code' => $order_code])
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function print($slug, $order_code)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $order = Order::with(['items.product', 'mitra', 'table'])->where('order_code', $order_code)->first();
        // dd($order);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';


        // Mengambil data pengaturan berdasarkan mitra_id
        $logo = PrintSetting::getValue($mitra->id, 'logo');
        $showLogo = PrintSetting::getValue($mitra->id, 'show_logo', false);
        $title = PrintSetting::getValue($mitra->id, 'title', 'Struk Pembelian');
        $footer = PrintSetting::getValue($mitra->id, 'footer_text', 'Terima kasih 🙏');

        // return view('admin.settings.print-setting', compact('slug', 'logo', 'showLogo', 'title', 'footer'));
        // dd($order);
        // Logic to print the order
        return view('admin.orders.struk', compact('slug', 'order', 'logo', 'showLogo', 'title', 'footer', 'notifSound'));
    }

    public function destroy($slug, $id)
    {
        // Cari mitra berdasarkan slug
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        // Cari pesanan berdasarkan ID
        $order = Order::where('id', $id)->firstOrFail();

        // Cari semua item yang terkait dengan pesanan
        $items = OrderItem::where('order_id', $order->id)->get();

        // Hapus setiap item pesanan
        foreach ($items as $item) {
            $item->delete();
        }

        // Hapus pesanan utama setelah menghapus itemnya
        $order->delete();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';


        // Redirect kembali dengan pesan sukses
        return redirect()
            ->route('admin.orders.index', ['slug' => $slug, 'notifSound' => $notifSound])
            ->with('success', 'Pesanan dan itemnya berhasil dihapus.');
    }

    public function checkNewOrders($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        $latestOrder = Order::where('mitra_id', $mitra->id)->latest()->first();
        $lastSeenOrderId = session('last_seen_order_id');

        if (!$lastSeenOrderId || $latestOrder->id > $lastSeenOrderId) {
            session(['last_seen_order_id' => $latestOrder->id]);

            return response()->json([
                'hasNew' => true,
                'message' => 'Ada pesanan baru dari pelanggan!',
                'order_code' => $latestOrder->order_code, // Pastikan data order_code dikirim
            ]);
        }

        return response()->json(['hasNew' => false]);
    }
}
