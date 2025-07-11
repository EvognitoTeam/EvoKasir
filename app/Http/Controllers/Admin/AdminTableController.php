<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use App\Models\Mitra;
use Barryvdh\DomPDF\PDF;
use App\Models\TableList;
use Illuminate\Support\Str;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminTableController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $tableList = TableList::where('mitra_id', $mitra->id)->get();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';
        // dd($tableList);

        return view('admin.table.index', [
            'slug' => $slug,
            'mitra' => $mitra,
            'tableList' => $tableList,
            'notifSound' => $notifSound,
        ]);
    }

    public function create($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';
        return view('admin.table.create', ['slug' => $slug, 'mitra' => $mitra, 'notifSound' => $notifSound,]);
    }
    public function edit($slug, $id)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $table = TableList::findOrFail($id);
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.table.edit', ['slug' => $slug, 'mitra' => $mitra, 'table' => $table, 'notifSound' => $notifSound,]);
    }

    public function store(Request $request, $slug)
    {
        $request->validate([
            'table_name' => 'required|string|max:255',
        ]);

        $code = Str::upper(Str::random(6));

        TableList::create([
            'table_name' => $request->table_name,
            'table_code' => $code, // <-- 3. Simpan kode yang sudah dibuat
            'mitra_id' => Auth::user()->mitra_id
        ]);

        return redirect()->route('admin.table.index', ['slug' => $slug])->with('success', 'Tabel berhasil ditambahkan.');
    }

    public function update(Request $request, $slug, $id)
    {
        $request->validate(['table_name' => 'required|string|max:255']);
        $table = TableList::findOrFail($id);
        $table->update(['table_name' => $request->table_name]);
        return redirect()->route('admin.table.index', ['slug' => $slug])
            ->with('success', 'Tabel berhasil diperbarui.');
    }

    public function destroy($slug, $id)
    {
        $table = TableList::findOrFail($id);
        $table->delete();
        return redirect()->route('admin.table.index', ['slug' => $slug])
            ->with('success', 'Tabel berhasil dihapus.');
    }

    public function updateTableStatus(Request $request)
    {
        try {
            $request->validate([
                'table_id' => 'required|exists:table_list,id',
                'status' => 'required|in:0,1,2,3', // Sesuaikan dengan opsi status
            ]);

            $table = TableList::find($request->table_id);
            if (!$table) {
                return response()->json([
                    'success' => false,
                    'message' => 'Meja tidak ditemukan.'
                ], 404);
            }

            $originalStatus = $table->status;
            $table->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status meja diperbarui.',
                'original_status' => $originalStatus,
                'updated_status' => $request->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage(),
                'original_status' => $table->status ?? null
            ], 500);
        }
    }

    public function downloadQr($slug, TableList $table)
    {
        // 1. Dapatkan data mitra untuk ditampilkan di header kartu
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        // 2. Siapkan data untuk satu meja ini dalam format yang sama dengan unduh semua
        $url = route('menu.index', ['slug' => $slug, 'table' => $table->table_code]);
        $qrCodeImage = QrCode::format('png')->size(300)->margin(2)->generate($url);

        // 3. Buat menjadi Collection yang berisi satu item
        // Ini penting agar view yang sama (yang menggunakan @foreach) bisa dipakai ulang
        $tablesWithQr = collect([
            [
                'table_name' => $table->table_name,
                'table_code' => $table->table_code,
                'qr_code' => base64_encode($qrCodeImage)
            ]
        ]);

        // 4. Load view yang sama dan kirim datanya
        $pdf = app('dompdf.wrapper')->loadView(
            'admin.table.qr-pdf',
            compact('mitra', 'tablesWithQr')
        );

        // 5. Buat nama file yang unik dan kirim PDF ke browser
        $fileName = 'qr-meja-' . $slug . '-' . Str::slug($table->table_name) . '.pdf';
        return $pdf->stream($fileName);
    }

    public function downloadAllQr($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $tables = TableList::where('mitra_id', $mitra->id)->get();

        // Variabel ini diinisialisasi sebagai array PHP biasa
        $tablesWithQr = [];
        foreach ($tables as $table) {
            $url = route('menu.index', ['slug' => $slug, 'table' => $table->table_code]);
            $qrCodeImage = QrCode::format('png')->size(300)->margin(2)->generate($url);

            // Array diisi dengan data
            $tablesWithQr[] = [
                'table_name' => $table->table_name,
                'table_code' => $table->table_code,
                'qr_code' => base64_encode($qrCodeImage)
            ];
        }

        // --- PERBAIKAN DI SINI ---
        // Ubah array biasa menjadi Laravel Collection agar ->chunk() bisa digunakan di view
        $tablesWithQr = collect($tablesWithQr);

        // Load view dan kirim data. Sekarang $tablesWithQr adalah sebuah Collection.
        $pdf = app('dompdf.wrapper')->loadView(
            'admin.table.qr-pdf',
            compact('mitra', 'tablesWithQr')
        );

        return $pdf->stream('qr-code-all_table-' . Str::slug($mitra->mitra_name) . '.pdf');
    }
}
