<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Order;
use Carbon\CarbonPeriod;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ApiAuthController extends Controller
{
    public function getLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::with('mitra')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Token pakai sanctum atau token manual
        $token = $user->token;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    public function getUserData(Request $request)
    {
        $token = $request->bearerToken();
        $user = User::where('token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Lanjut proses pakai $user
    }

    public function getMitraData(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'mitra_id' => 'required|integer|exists:mitra,id',
        ]);

        $mitraId = $request->input('mitra_id');
        $mitra = Mitra::find($mitraId);

        $totalProduk = Menu::where('mitra_id', $mitra->id)->count();
        $totalTransaksi = Order::where('mitra_id', $mitra->id)->count();
        $pendapatanHarian = Order::where('mitra_id', $mitra->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');

        $pendapatanBulanan = Order::where('mitra_id', $mitra->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_price');

        $totalPendapatan = Order::where('mitra_id', $mitra->id)->sum('total_price');

        // Raw earnings per month
        $rawMonthly = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('mitra_id', $mitra->id)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Inisialisasi semua bulan dari 1 sampai 12
        $monthlyEarnings = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyEarnings[$month] = $rawMonthly[$month] ?? 0;
        }

        // Ambil transaksi 7 hari terakhir
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $rawWeekly = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->where('mitra_id', $mitra->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Pastikan semua tanggal dari periode terisi
        $weeklyEarnings = [];
        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $formatted = $date->toDateString();
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


        $notifSound = PrintSetting::where('mitra_id', $mitra->id)
            ->where('key', 'notif_sound')
            ->value('value') ?? 'ding.mp3';

        return response()->json([
            'mitra' => $mitra,
            'totalProduk' => $totalProduk,
            'totalTransaksi' => $totalTransaksi,
            'pendapatanHarian' => $pendapatanHarian,
            'pendapatanBulanan' => $pendapatanBulanan,
            'totalPendapatan' => $totalPendapatan,
            'monthlyEarnings' => $monthlyEarnings,
            'weeklyEarnings' => $weeklyEarnings,
            'yearlyEarnings' => $yearlyEarnings, // ← tambahkan ini
            'notifSound' => $notifSound,
        ]);
    }
}
