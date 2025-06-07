<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    // Nama tabel
    protected $table = 'products';

    // Atribut yang bisa diisi mass assignment
    protected $fillable = [
        'mitra_id',
        'name',
        'description',
        'categories_id',
        'stock',
        'price',
        'image',
        'status',
    ];

    // Set format harga menjadi IDR dengan rupiah
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getCategory()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }
    public function reviews()
    {
        return $this->hasMany(Rating::class, 'product_id');
    }
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}
