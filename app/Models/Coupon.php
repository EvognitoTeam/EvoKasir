<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coupon'; // Sesuaikan dengan nama tabel kupon Anda

    protected $fillable = [
        'mitra_id',
        'title',
        'image',
        'description',
        'coupon_code',
        'is_member_only',
        'discount_price',
        'discount_rate',
        'max_use',
        'already_used',
        'expired_date',
    ];

    public static function validateCoupon($coupon_code)
    {
        // Ganti 'self' dengan 'static' untuk late static binding, ini praktik yang lebih baik
        $coupon = static::where(DB::raw('BINARY `coupon_code`'), $coupon_code) // 1. Perbaikan Case-Sensitive
            ->where('expired_date', '>', now())
            ->whereColumn('max_use', '>', 'already_used') // 2. Perbaikan Perbandingan Kolom
            ->first();

        return $coupon;
    }
}
