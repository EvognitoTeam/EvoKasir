<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Rating;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserRatingController extends Controller
{
    public function store(Request $request, $slug, Order $order, OrderItem $item)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // dd($order);

        Rating::create([
            'mitra_id' => $order->mitra_id ?? null, // Sesuaikan dengan logika mitra
            'product_id' => $item->product_id,
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review berhasil disimpan!');
    }
}
