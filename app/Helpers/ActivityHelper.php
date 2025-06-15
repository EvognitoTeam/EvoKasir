<?php

namespace App\Helpers;

use App\Models\Activities;
use App\Models\Activity;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;

class ActivityHelper
{
    public static function createActivity(
        string $description,
        string $activityType = 'general',
        ?int $userId = null,
        ?int $mitraId = null,
        ?Request $request = null
    ): Activities {
        // Gunakan user ID dari Auth jika tidak disediakan
        $userId = $userId ?? Auth::id();

        // Ambil request dari global jika tidak disediakan
        $request = $request ?? request();

        // Deteksi browser menggunakan Jenssegers\Agent
        $agent = $request->server('HTTP_USER_AGENT');

        // Ambil IP dari X-Forwarded-For dengan fallback ke request->ip()
        $ipAddress = $request->header('X-Forwarded-For');

        // Buat entri aktivitas
        return Activities::create([
            'user_id' => $userId,
            'mitra_id' => $mitraId,
            'activity_type' => $activityType,
            'description' => $description,
            'ip_address' => $ipAddress,
            'browser' => $agent,
        ]);
    }
}
