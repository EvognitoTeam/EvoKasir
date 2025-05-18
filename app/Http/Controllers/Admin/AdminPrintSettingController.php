<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mitra;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPrintSettingController extends Controller
{
    public function printSettingForm($slug)
    {
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        // Mengambil data pengaturan berdasarkan mitra_id
        $logo = PrintSetting::getValue($mitra->id, 'logo');
        $showLogo = PrintSetting::getValue($mitra->id, 'show_logo', false);
        $title = PrintSetting::getValue($mitra->id, 'title', 'Struk Pembelian');
        $footerText = PrintSetting::getValue($mitra->id, 'footer_text', 'Terima kasih 🙏');
        $notifSound = PrintSetting::where('mitra_id', $mitra->id)->where('key', 'notif_sound')->value('value') ?? 'ding.mp3';


        return view('admin.settings.print-setting', compact('slug', 'logo', 'showLogo', 'title', 'footerText', 'notifSound'));
    }


    public function savePrintSetting(Request $request, $slug)
    {
        // dd($request->all());
        $mitra = Mitra::where('mitra_slug', $slug)->firstOrFail();

        $request->validate([
            'title' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string',
            'show_logo' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $settings = [
            'title' => $request->input('title'),
            'footer_text' => $request->input('footer_text'),
            'show_logo' => $request->has('show_logo') ? '1' : '0',
        ];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('logo', $filename, 'public');
            $settings['logo'] = 'logo/' . $filename;
        }

        foreach ($settings as $key => $value) {
            PrintSetting::updateOrCreate(
                ['mitra_id' => $mitra->id, 'key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan struk berhasil disimpan.');
    }
}
