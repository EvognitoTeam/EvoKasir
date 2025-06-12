<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\Order;
use App\Models\Cashout;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminCashoutController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth_admin');
    // }

    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        if (Auth::user()->mitra_id !== $mitra->id) {
            abort(403, 'Unauthorized');
        }

        $totalRevenue = Order::where('mitra_id', $mitra->id)
            ->where('payment_status', 2)
            ->where('payment_method', 'qris')
            ->where('is_cashouted', false)
            ->sum('total_price');

        $midtransFee = $totalRevenue * 0.007;
        // dd($midtransFee);
        // $platformFee = $totalRevenue * 0.15;
        $platformFee = ($totalRevenue - $midtransFee) * 0.15;

        $totalFees = $midtransFee + $platformFee;

        $approvedCashouts = Cashout::where('mitra_id', $mitra->id)
            ->where('status', 'approved')
            ->sum('amount');

        $availableCashout = floor(max(0, $totalRevenue - $totalFees));

        $cashouts = Cashout::where('mitra_id', $mitra->id)
            ->latest()
            ->take(10)
            ->get();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.cashout.index', compact('slug', 'mitra', 'totalRevenue', 'availableCashout', 'cashouts', 'midtransFee', 'platformFee', 'notifSound'));
    }

    public function create($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        if (Auth::user()->mitra_id !== $mitra->id) {
            abort(403, 'Unauthorized');
        }

        $totalRevenue = Order::where('mitra_id', $mitra->id)
            ->where('payment_status', '2')
            ->where('payment_method', 'qris')
            ->where('is_cashouted', false)
            ->sum('total_price');

        $midtransFee = $totalRevenue * 0.007;
        // $platformFee = $totalRevenue * 0.15;
        $platformFee = ($totalRevenue - $midtransFee) * 0.15;

        $totalFees = $midtransFee + $platformFee;

        $approvedCashouts = Cashout::where('mitra_id', $mitra->id)
            ->where('status', 'approved')
            ->sum('amount');

        $availableCashout = floor(max(0, $totalRevenue - $totalFees));
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.cashout.create', compact('slug', 'mitra', 'availableCashout', 'notifSound'));
    }

    public function store(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        if (Auth::user()->mitra_id !== $mitra->id) {
            abort(403, 'Unauthorized');
        }

        $totalRevenue = Order::where('mitra_id', $mitra->id)
            ->where('payment_status', '2')
            ->where('payment_method', 'qris')
            ->where('is_cashouted', false)
            ->sum('total_price');

        $midtransFee = $totalRevenue * 0.007;
        // $platformFee = $totalRevenue * 0.15;
        $platformFee = ($midtransFee - $totalRevenue) * 0.15;

        $totalFees = $midtransFee + $platformFee;

        $approvedCashouts = Cashout::where('mitra_id', $mitra->id)
            ->where('status', 'approved')
            ->sum('amount');

        $availableCashout = floor(max(0, $totalRevenue - $totalFees));

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:100000',
                'max:' . $availableCashout,
            ],
        ], [
            'amount.max' => 'Jumlah tidak boleh lebih dari Rp' . number_format($availableCashout, 0, ',', '.'),
            'amount.min' => 'Jumlah minimal Rp100.000',
        ]);

        DB::transaction(function () use ($mitra, $request) {
            // Simpan cashout
            $cashout = Cashout::create([
                'mitra_id' => $mitra->id,
                'amount' => $request->amount,
                'status' => 'pending',
            ]);

            // Tandai pesanan sebagai di cashout
            $remainingAmount = $request->amount;
            $orders = Order::where('mitra_id', $mitra->id)
                ->where('payment_status', '2')
                ->where('is_cashouted', false)
                ->orderBy('created_at')
                ->get();

            foreach ($orders as $order) {
                if ($remainingAmount <= 0) break;

                $deductible = min($remainingAmount, $order->total_price);
                $remainingAmount -= $deductible;

                $order->update(['is_cashouted' => true]);
            }
        });

        return redirect()->route('admin.cashout.index', ['slug' => $mitra->mitra_slug])
            ->with('success', 'Pengajuan cashout berhasil dan pendapatan telah direset.');
    }
}
