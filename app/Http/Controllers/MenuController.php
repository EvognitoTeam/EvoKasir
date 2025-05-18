<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Mitra;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index($slug)
    {
        // dd($slug);
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        // dd($mitra);
        $menus = Menu::with('getCategory')->where('mitra_id', $mitra->id)->get()->groupBy('getCategory.name');
        return view('main.menu.index', compact('slug', 'menus', 'mitra'));
    }
}
