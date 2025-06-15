<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Mitra;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        if (!$mitra) {
            return redirect()->route('home')->with('error', 'Mitra tidak ditemukan.');
        }
        $promos = Coupon::where('mitra_id', $mitra->id)
            ->where('expired_date', '>=', now())
            ->orderBy('expired_date', 'asc')
            ->get();
        // Ambil produk favorit berdasarkan total quantity di order_items
        $favoriteProducts = Menu::select('products.*')
            ->leftJoinSub(
                DB::table('order_items')
                    ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                    ->groupBy('product_id'),
                'order_totals',
                'products.id',
                '=',
                'order_totals.product_id'
            )
            ->where('products.mitra_id', $mitra->id)
            ->whereNull('products.deleted_at')
            ->orderByDesc('order_totals.total_quantity')
            ->take(4)
            ->get();
        // dd($promos);
        return view('main.home', compact('mitra', 'slug', 'promos', 'favoriteProducts'));
    }
}
