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
            // dd($selisihHari * -1);
            if (($selisihHari * -1) < 7) {
                return back()->with('error', 'Perubahan rekening hanya dapat dilakukan setelah 7 hari dari perubahan terakhir.');
            }
        }

        // Validasi input
        $request->validate([
            'nama_rek' => ['required', 'string', 'max:255'],
            'no_rek' => ['required', 'numeric', 'digits_between:8,25'],

            // Validasi untuk bank
            'bank_name' => ['required', 'string', 'max:50'],

            // 'input_bank_lainnya' hanya wajib jika 'bank_tujuan' nilainya adalah 'Lainnya'
            'bank_lainnya' => ['required_if:bank_name,Lainnya', 'nullable', 'string', 'max:50'],
        ], [
            'nama_rek.required' => 'Nama rekening wajib diisi.',
            'no_rek.required' => 'Nomor rekening wajib diisi.',
            'no_rek.numeric' => 'Nomor rekening harus berupa angka.',
            'no_rek.digits_between' => 'Nomor rekening harus terdiri dari 8 hingga 25 digit.',
            'bank_name.required' => 'Silakan pilih bank tujuan.',
            'bank_lainnya.required_if' => 'Nama bank lainnya wajib diisi.',
        ]);

        $namaBank = $request->bank_name == 'Lainnya'
            ? $request->bank_lainnya
            : $request->bank_name;

        // dd($namaBank);

        // Update rekening
        try {
            // Gunakan updateOrCreate untuk memperbarui rekening yang ada atau membuat yang baru
            // Ini lebih aman dan efisien.
            $mitra->update(
                [
                    'bank_name' => $namaBank, // Kolom baru untuk nama bank
                    'no_rek' => $request->no_rek,
                    'nama_rek' => strtoupper($request->nama_rek),
                    'rek_added_at' => now(), // Jika Anda masih memerlukan kolom ini
                ]
            );
        } catch (\Exception $e) {
            // Jika terjadi error saat menyimpan
            return back()->with('error', 'Gagal menyimpan data rekening. Silakan coba lagi.');
        }

        return back()->with('success', 'Rekening berhasil diperbarui.');
    }
}
