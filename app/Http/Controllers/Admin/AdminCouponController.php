<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\Coupon;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminCouponController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $coupons = Coupon::where('mitra_id', $mitra->id)->paginate(15);
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.coupon.index', ['slug' => $slug, 'coupons' => $coupons, 'notifSound' => $notifSound]);
    }
    public function store(Request $request, $slug)
    {
        $mitra = Auth::user()->mitra;
        if ($mitra->mitra_slug !== $slug) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:50',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'max_use' => 'required|integer|min:1',
            'expired_date' => 'required|date|after:now',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->only(['title', 'coupon_code', 'discount_price', 'discount_rate', 'max_use', 'expired_date', 'description']);
        $data['mitra_id'] = $mitra->id;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu', 'public');
        }
        Coupon::create($data);
        return redirect()->route('admin.coupon.index', ['slug' => $slug])->with('success', 'Kupon berhasil ditambahkan.');
    }

    public function update(Request $request, $slug, $id)
    {
        $mitra = Auth::user()->mitra;
        if ($mitra->mitra_slug !== $slug) {
            abort(403, 'Unauthorized');
        }
        $coupon = Coupon::where('id', $id)->where('mitra_id', $mitra->id)->firstOrFail();
        $request->validate([
            'title' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:50|unique:coupon,id,' . $coupon->id,
            'discount_price' => 'nullable|numeric|min:0',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'max_use' => 'required|integer|min:1',
            'expired_date' => 'required|date|after:now',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->only(['title', 'coupon_code', 'discount_price', 'discount_rate', 'max_use', 'expired_date', 'description']);
        if ($request->hasFile('image')) {

            $data['image'] = $request->file('image')->store('menu', 'public');
        }
        $coupon->update($data);
        return redirect()->route('admin.coupon.index', ['slug' => $slug])->with('success', 'Kupon berhasil diperbarui.');
    }

    public function destroy($slug, $id)
    {
        $mitra = Auth::user()->mitra;
        if ($mitra->mitra_slug !== $slug) {
            abort(403, 'Unauthorized');
        }
        $coupon = Coupon::where('id', $id)->where('mitra_id', $mitra->id)->firstOrFail();

        $coupon->delete();
        return redirect()->route('admin.coupon.index', ['slug' => $slug])->with('success', 'Kupon berhasil dihapus.');
    }
}
