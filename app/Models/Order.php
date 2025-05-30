<?php

namespace App\Models;

use App\Models\Mitra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    protected $fillable = ['order_code', 'mitra_id', 'user_id', 'name', 'email', 'table_number', 'status', 'total_price', 'discount', 'totalAfterDiscount', 'payment_method', 'payment_status', 'transaction_id', 'qr_string', 'payment_type', 'qr_url', 'expiry_time'];

    // Order.php
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function table()
    {
        return $this->belongsTo(TableList::class, 'table_number');
    }
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
