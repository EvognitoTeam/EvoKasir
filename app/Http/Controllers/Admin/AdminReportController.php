<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\Order;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminReportController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $mitraId = $mitra->id;

        // --- KALKULASI DI DATABASE UNTUK EFISIENSI ---

        // Total Pendapatan Keseluruhan (Hanya dari pesanan yang sudah lunas)
        $totalIncome = Order::where('mitra_id', $mitraId)
            ->where('payment_status', 2)
            ->sum('total_price');

        // Ringkasan Harian, Mingguan, Bulanan dari pesanan lunas
        $daily = Order::where('mitra_id', $mitraId)
            ->where('payment_status', 2)
            ->whereDate('created_at', today())
            ->selectRaw('COUNT(*) as transactions, SUM(total_price) as income')
            ->first();

        $weekly = Order::where('mitra_id', $mitraId)
            ->where('payment_status', 2)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('COUNT(*) as transactions, SUM(total_price) as income')
            ->first();

        $monthly = Order::where('mitra_id', $mitraId)
            ->where('payment_status', 2)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->selectRaw('COUNT(*) as transactions, SUM(total_price) as income')
            ->first();

        // Total pembayaran per metode
        $paymentTotals = Order::where('mitra_id', $mitraId)
            ->where('payment_status', 2)
            ->selectRaw("
            SUM(CASE WHEN payment_method = 'cash' AND created_at >= ? THEN total_price ELSE 0 END) as cashToday,
            SUM(CASE WHEN payment_method = 'qris' AND created_at >= ? THEN total_price ELSE 0 END) as qrisToday,
            SUM(CASE WHEN payment_method = 'cash' AND created_at >= ? THEN total_price ELSE 0 END) as cashWeek,
            SUM(CASE WHEN payment_method = 'qris' AND created_at >= ? THEN total_price ELSE 0 END) as qrisWeek,
            SUM(CASE WHEN payment_method = 'cash' AND created_at >= ? THEN total_price ELSE 0 END) as cashMonth,
            SUM(CASE WHEN payment_method = 'qris' AND created_at >= ? THEN total_price ELSE 0 END) as qrisMonth
        ", [today(), today(), now()->startOfWeek(), now()->startOfWeek(), now()->startOfMonth(), now()->startOfMonth()])
            ->first();

        // Produk Terlaris (Top 10) - Query ini jauh lebih cepat
        $mostOrderedProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.mitra_id', $mitraId)
            ->where('orders.payment_status', 2)
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        // --- BAGIAN BARU: LAPORAN HISTORIS ---


        // Laporan pendapatan per bulan
        $monthlyIncomeReport = Order::where('mitra_id', $mitraId)
            ->where('payment_status', 2)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as income')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Laporan pendapatan per tahun
        $yearlyIncomeReport = Order::where('mitra_id', $mitraId)
            ->where('payment_status', 2)
            ->selectRaw('YEAR(created_at) as year, SUM(total_price) as income')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // Query BARU untuk mengambil detail produk terlaris per bulan
        $productsByMonthQuery = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.mitra_id', $mitraId)
            ->where('orders.payment_status', 2)
            ->selectRaw('YEAR(orders.created_at) as year, MONTH(orders.created_at) as month, products.name, SUM(order_items.quantity) as total_quantity')
            ->groupBy('year', 'month', 'products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->get();

        // Kelompokkan hasilnya berdasarkan 'tahun-bulan' agar mudah diakses di view
        $productsByMonth = $productsByMonthQuery->groupBy(function ($item) {
            return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
        });

        // Notif Sound (jika masih digunakan)
        $notifSound = PrintSetting::where('mitra_id', $mitraId)
            ->where('key', 'notif_sound')
            ->value('value') ?? 'ding.mp3';

        // --- KIRIM SEMUA DATA KE VIEW ---
        return view('admin.reports.index', [
            'slug' => $slug,
            'mitra' => $mitra,
            'totalIncome' => $totalIncome,
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'cashToday' => $paymentTotals->cashToday ?? 0,
            'qrisToday' => $paymentTotals->qrisToday ?? 0,
            'cashWeek' => $paymentTotals->cashWeek ?? 0,
            'qrisWeek' => $paymentTotals->qrisWeek ?? 0,
            'cashTotal' => $paymentTotals->cashMonth ?? 0, // Mengganti nama variabel lama
            'qrisTotal' => $paymentTotals->qrisMonth ?? 0, // Mengganti nama variabel lama
            'mostOrderedProducts' => $mostOrderedProducts,
            'monthlyIncomeReport' => $monthlyIncomeReport,
            'yearlyIncomeReport' => $yearlyIncomeReport,
            'productsByMonth' => $productsByMonth, // <-- Tambahkan variabel baru ini
            'notifSound' => $notifSound
        ]);
    }
}
