<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        $coupon = self::where('coupon_code', $coupon_code)
            ->where('expired_date', '>', now())
            ->where('max_use', '>', 'already_used')
            ->first();

        return $coupon;
    }
}
