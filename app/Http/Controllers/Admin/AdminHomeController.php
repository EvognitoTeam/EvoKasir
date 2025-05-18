<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Mitra;
use App\Models\Order;
use Carbon\CarbonPeriod;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminHomeController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        // Data total
        $totalProduk = Menu::where('mitra_id', $mitra->id)->count();
        $totalTransaksi = Order::where('mitra_id', $mitra->id)->count();
        $pendapatanHarian = Order::where('mitra_id', $mitra->id)->where('payment_status', 2)->whereDate('created_at', Carbon::today())->sum('totalAfterDiscount');
        $pendapatanBulanan = Order::where('mitra_id', $mitra->id)->where('payment_status', 2)->whereMonth('created_at', Carbon::now()->month)->sum('totalAfterDiscount');
        $totalPendapatan = Order::where('mitra_id', $mitra->id)->where('payment_status', 2)->sum('totalAfterDiscount');

        // Pendapatan per bulan (12 bulan terakhir)
        $monthlyEarnings = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(totalAfterDiscount) as total')
        )
            ->where('mitra_id', $mitra->id)
            ->where('payment_status', 2)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Ambil transaksi 7 hari terakhir
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $rawWeekly = Order::selectRaw('DATE(created_at) as date, SUM(totalAfterDiscount) as total')
            ->where('mitra_id', $mitra->id)
            ->where('payment_status', 2)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Isi semua hari meskipun tidak ada transaksi
        $weeklyEarnings = [];
        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $formatted = $date->toDateString(); // yyyy-mm-dd
            $weeklyEarnings[$formatted] = $rawWeekly[$formatted] ?? 0;
        }

        // Pendapatan tahunan dari tahun pertama data tersedia
        $firstOrder = Order::where('mitra_id', $mitra->id)->orderBy('created_at', 'asc')->first();
        $startYear = $firstOrder ? $firstOrder->created_at->year : Carbon::now()->year;
        $currentYear = Carbon::now()->year;

        $yearlyEarnings = [];

        for ($year = $startYear; $year <= $currentYear; $year++) {
            $total = Order::where('mitra_id', $mitra->id)
                ->whereYear('created_at', $year)
                ->sum('total_price');
            $yearlyEarnings[$year] = $total;
        }

        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';
        // dd(Auth()->user());
        return view('admin.home', compact(
            'mitra',
            'slug',
            'totalProduk',
            'totalTransaksi',
            'pendapatanHarian',
            'pendapatanBulanan',
            'totalPendapatan',
            'monthlyEarnings',
            'weeklyEarnings',
            'yearlyEarnings',
            'notifSound'
        ));
    }
}
