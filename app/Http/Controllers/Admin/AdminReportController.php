<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\Order;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminReportController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        // Ambil semua order dari mitra ini
        $orders = Order::with('items.product')
            ->where('mitra_id', $mitra->id)
            ->get();

        // Laporan Harian, Mingguan, Bulanan (jumlah transaksi dan total pendapatan)
        $today = now()->toDateString();
        $startOfWeek = now()->startOfWeek();
        $startOfMonth = now()->startOfMonth();

        $dailyOrders = $orders->filter(fn($order) => $order->created_at->toDateString() >= $today);
        $weeklyOrders = $orders->filter(fn($order) => $order->created_at >= $startOfWeek);
        $monthlyOrders = $orders->filter(fn($order) => $order->created_at >= $startOfMonth);

        $daily = [
            'transactions' => $dailyOrders->count(),
            'income' => $dailyOrders->sum('totalAfterDiscount'),
        ];

        $weekly = [
            'transactions' => $weeklyOrders->count(),
            'income' => $weeklyOrders->sum('totalAfterDiscount'),
        ];

        $monthly = [
            'transactions' => $monthlyOrders->count(),
            'income' => $monthlyOrders->sum('totalAfterDiscount'),
        ];

        // Total pembayaran berdasarkan metode
        $cashTotal = $monthlyOrders->where('payment_method', 'cash')->sum('totalAfterDiscount');
        $qrisTotal = $monthlyOrders->where('payment_method', 'qris')->sum('totalAfterDiscount');
        $cashToday = $dailyOrders->where('payment_method', 'cash')->sum('totalAfterDiscount');
        $qrisToday = $dailyOrders->where('payment_method', 'qris')->sum('totalAfterDiscount');

        $cashWeek = $weeklyOrders->where('payment_method', 'cash')->sum('totalAfterDiscount');
        $qrisWeek = $weeklyOrders->where('payment_method', 'qris')->sum('totalAfterDiscount');
        $totalIncome = $orders->where('payment_status', 2)->sum('totalAfterDiscount');


        // Hitung produk yang paling sering dipesan
        $productCounts = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $productId = $item->product_id;
                $productName = $item->product->name ?? 'Unknown';
                if (!isset($productCounts[$productId])) {
                    $productCounts[$productId] = [
                        'name' => $productName,
                        'quantity' => 0
                    ];
                }
                $productCounts[$productId]['quantity'] += $item->quantity;
            }
        }

        $mostOrderedProducts = collect($productCounts)->sortByDesc('quantity')->values();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)
            ->where('key', 'notif_sound')
            ->value('value') ?? 'ding.mp3';

        return view('admin.reports.index', [
            'slug' => $slug,
            'mitra' => $mitra,
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'cashTotal' => $cashTotal,
            'qrisTotal' => $qrisTotal,
            'cashToday' => $cashToday,
            'qrisToday' => $qrisToday,
            'cashWeek' => $cashWeek,
            'qrisWeek' => $qrisWeek,
            'totalIncome' => $totalIncome,
            'mostOrderedProducts' => $mostOrderedProducts,
            'notifSound' => $notifSound
        ]);
    }
}
