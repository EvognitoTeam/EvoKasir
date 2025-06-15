<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintSetting extends Model
{
    protected $fillable = ['mitra_id', 'key', 'value'];

    // public static function getValue($key, $default = null)
    // {
    //     return static::where('key', $key)->value('value') ?? $default;
    // }
    public static function getValue($mitraId, $key, $default = null)
    {
        $setting = self::where('mitra_id', $mitraId)
            ->where('key', $key)
            ->first();
        return $setting ? $setting->value : $default;
    }
}
