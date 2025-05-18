<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\TableList;

class ApiMenuController extends Controller
{
    public function getMenu(Request $request)
    {
        $request->validate([
            'mitra_id' => 'required|integer|exists:mitra,id',
        ]);

        $mitra = Mitra::find($request->mitra_id);

        // Ambil semua menu beserta kategorinya
        $menus = Menu::with('getCategory')
            ->where('mitra_id', $mitra->id)
            ->get()
            ->groupBy(function ($menu) {
                return $menu->getCategory ? $menu->getCategory->name : 'Tanpa Kategori';
            });

        // Ambil daftar meja
        $tables = TableList::where('mitra_id', $mitra->id)->get();

        // Format data agar terlihat seperti: { "Minuman": [menu1, menu2], "Makanan": [menu3, ...] }
        $formattedMenus = [];
        foreach ($menus as $kategori => $items) {
            $formattedMenus[] = [
                'kategori' => $kategori,
                'menus' => $items->values(),
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Menu retrieved successfully',
            'data' => $formattedMenus,
            'tables' => $tables,
        ]);
    }
}
