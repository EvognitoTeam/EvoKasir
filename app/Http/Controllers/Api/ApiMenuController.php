<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Order;
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

    public function getOrders(Request $request)
    {
        $request->validate([
            'mitra_id' => 'required|integer|exists:mitra,id',
            'cashier_id' => 'nullable|integer|exists:users,id',
        ]);

        $mitra = Mitra::find($request->mitra_id);

        $query = Order::with(['items.product', 'table', 'user'])
            ->where('mitra_id', $mitra->id);

        if ($request->filled('cashier_id')) {
            $query->where('cashier_id', $request->cashier_id);
        }

        $orders = $query->get();

        return response()->json([
            'response_code' => '200',
            'message' => 'Orders data successfully retrieved',
            'orders' => $orders,
        ]);
    }
}
