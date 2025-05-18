<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Mitra;
use Illuminate\Http\Request;

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
        // dd($promos);
        return view('main.home', compact('mitra', 'slug', 'promos'));
    }
}
