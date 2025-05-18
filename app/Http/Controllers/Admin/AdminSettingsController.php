<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller
{
    // Misalnya di controller Anda
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.settings.index', compact('slug', 'notifSound'));
    }

    public function saveSettings(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        $request->validate([
            'notif_sound' => 'nullable|string',
            'custom_sound' => 'nullable|file|mimes:mp3|max:2048',
        ]);

        $soundValue = $request->input('notif_sound');

        if ($request->hasFile('custom_sound')) {
            $file = $request->file('custom_sound');
            $filename = 'custom_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sounds/custom', $filename, 'public');
            $soundValue = $path; // Ganti nilai dengan path upload
        }

        PrintSetting::updateOrCreate(
            ['mitra_id' => $mitra->id, 'key' => 'notif_sound'],
            ['value' => $soundValue]
        );

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
