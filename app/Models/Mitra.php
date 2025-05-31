<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'mitra';
    protected $fillable = [
        'mitra_slug',
        'mitra_name',
        'mitra_address',
        'mitra_welcome',
        'no_rek',
        'nama_rek',
        'rek_added_at',
        'banner',
        'status',
    ];
}
