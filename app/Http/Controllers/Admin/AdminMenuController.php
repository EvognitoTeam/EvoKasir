<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Mitra;
use App\Models\Categories;
use Illuminate\Support\Str;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminMenuController extends Controller
{
    public function index($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $menus = Menu::with('getCategory')->where('mitra_id', $mitra->id)->paginate(15);
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        // Logic to display the menu list
        return view('admin.menu.index', ['slug' => $slug, 'menus' => $menus, 'mitra' => $mitra, 'notifSound' => $notifSound]);
    }

    public function create($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $categories = Categories::where('mitra_id', $mitra->id)->get();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';

        // Logic to display the menu creation form
        return view('admin.menu.create', ['slug' => $slug, 'categories' => $categories, 'mitra' => $mitra, 'notifSound' => $notifSound]);
    }

    public function store(Request $request, $slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama menu wajib diisi.',
            'description.required' => 'Deskripsi menu wajib diisi.',
            'price.required' => 'Harga menu wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.numeric' => 'Stok harus berupa angka.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak ditemukan.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        $menu = new Menu();
        $menu->mitra_id = $mitra->id;
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->categories_id = $request->category_id;
        $menu->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                // Membuat nama file baru dengan format UUID
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();

                // Simpan gambar ke storage/app/public/menu dengan nama file UUID
                $path = $image->storeAs('menu', $imageName, 'public');  // Pastikan menggunakan 'public' sebagai disk

                // Simpan path-nya (contoh: "menu/abc123.jpg")
                $menu->image = 'menu/' . $imageName;  // Menyimpan path relatif (public/menu/abc123.jpg)
            } else {
                return back()->withErrors(['image' => 'Gambar gagal di-upload.'])->withInput();
            }
        }
        $menu->stock = $request->stock;
        $menu->save();
        return redirect()->route('admin.menu.index', ['slug' => $slug])->with('success', 'Menu created successfully.');
    }

    public function edit($slug, $id)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->first();

        $menu = Menu::findOrFail($id);
        $categories = Categories::all();
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';


        // Logic to display the menu edit form
        return view('admin.menu.edit', ['slug' => $slug, 'menu' => $menu, 'categories' => $categories, 'mitra' => $mitra, 'notifSound' => $notifSound]);
    }

    public function update(Request $request, $slug, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->stock = $request->stock;
        $menu->categories_id = $request->category_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('menu', $imageName, 'public');
                $menu->image = 'menu/' . $imageName;
            } else {
                return back()->withErrors(['image' => 'Gambar gagal di-upload.'])->withInput();
            }
        }

        $menu->save();

        return redirect()->route('admin.menu.index', ['slug' => $slug])->with('success', 'Menu updated successfully.');
    }
    public function destroy($slug, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menu.index', ['slug' => $slug])->with('success', 'Menu deleted successfully.');
    }
}
