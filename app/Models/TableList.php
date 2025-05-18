<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TableList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'table_list';
    protected $fillable = ['table_name', 'mitra_id'];
}
