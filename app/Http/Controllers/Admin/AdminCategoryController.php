<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\Categories;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminCategoryController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();
        $categories = Categories::where('mitra_id', $mitra->id)->get();

        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.category.index', compact('slug', 'mitra', 'categories', 'notifSound'));
    }
    public function create($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';
        return view('admin.category.create', ['slug' => $slug, 'mitra' => $mitra, 'notifSound' => $notifSound,]);
    }
    public function edit($slug, $id)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();
        $category = Categories::findOrFail($id);
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        return view('admin.category.edit', ['slug' => $slug, 'mitra' => $mitra, 'category' => $category, 'notifSound' => $notifSound,]);
    }
    public function store(Request $request, $slug)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);
        Categories::create([
            'name' => $request->category_name,
            'mitra_id' => Auth::user()->mitra_id
        ]);
        return redirect()->route('admin.categories.index', ['slug' => $slug])->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $slug, $id)
    {
        $request->validate(['category_name' => 'required|string|max:255']);
        $categories = Categories::findOrFail($id);
        $categories->update(['name' => $request->category_name]);
        return redirect()->route('admin.categories.index', ['slug' => $slug])
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($slug, $id)
    {
        $categories = Categories::findOrFail($id);
        $categories->delete();
        return redirect()->route('admin.categories.index', ['slug' => $slug])
            ->with('success', 'Tabel berhasil dihapus.');
    }
}
