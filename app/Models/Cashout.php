<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class Cashout extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cashouts';
    protected $fillable = [
        'mitra_id',
        'amount',
        'status',
    ];
    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}
