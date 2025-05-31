<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Mitra;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;
use App\Models\TableList;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index($slug)
    {
        // dd($slug);
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        // dd($mitra);
        $menus = Menu::with('getCategory')->where('mitra_id', $mitra->id)->get()->groupBy('getCategory.name');

        ActivityHelper::createActivity(
            description: 'Open Menu',
            activityType: 'menu',
            mitraId: $mitra->id,
            userId: Auth::check() ? Auth::id() : null,
        );

        if (request()->has('table')) {
            session(['table' => request()->get('table')]);
        }
        if (!empty(session('table'))) {

            $table = TableList::where('table_code', session('table'))->first();
            return view('main.menu.index', compact('slug', 'menus', 'mitra', 'table'));
        }

        return view('main.menu.index', compact('slug', 'menus', 'mitra'));
    }
}
