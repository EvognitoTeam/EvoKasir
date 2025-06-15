<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends Controller
{
    // Misalnya di controller Anda
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.settings.index', compact('slug', 'notifSound', 'mitra'));
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

    public function saveRekening(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        // Cek apakah sudah pernah menambahkan rekening
        if (!empty($mitra->rek_added_at)) {
            $selisihHari = now()->diffInDays($mitra->rek_added_at);

            if ($selisihHari < 7) {
                return back()->with('error', 'Perubahan rekening hanya dapat dilakukan setelah 7 hari dari perubahan terakhir.');
            }
        }

        // Validasi input
        $request->validate([
            'nama_rek' => ['required', 'string', 'max:255'],
            'no_rek' => ['required', 'numeric', 'digits_between:8,25'],
        ], [
            'nama_rek.required' => 'Nama rekening wajib diisi.',
            'nama_rek.string' => 'Nama rekening harus berupa teks.',
            'nama_rek.max' => 'Nama rekening maksimal 255 karakter.',

            'no_rek.required' => 'Nomor rekening wajib diisi.',
            'no_rek.numeric' => 'Nomor rekening harus berupa angka.',
            'no_rek.digits_between' => 'Nomor rekening harus terdiri dari 8 hingga 25 digit.',
        ]);

        // Update rekening
        $updateRek = Mitra::where('id', Auth::user()->mitra_id)
            ->update([
                'no_rek' => $request->no_rek,
                'nama_rek' => strtoupper($request->nama_rek),
                'rek_added_at' => now(),
            ]);

        if (!$updateRek) {
            return back()->with('error', 'Gagal menyimpan data rekening.');
        }

        return back()->with('success', 'Rekening berhasil diperbarui.');
    }
}
