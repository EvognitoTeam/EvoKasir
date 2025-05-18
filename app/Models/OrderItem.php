<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'mitra_id', 'quantity', 'price', 'priceBeforeDiscount', 'discount', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Menu::class, 'product_id');
    }
}
