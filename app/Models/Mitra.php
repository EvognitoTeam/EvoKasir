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
        'status',
    ];
}
