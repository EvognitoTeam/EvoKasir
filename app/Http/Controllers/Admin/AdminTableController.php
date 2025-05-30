<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\TableList;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        TableList::create([
            'table_name' => $request->table_name,
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
}
