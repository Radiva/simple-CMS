<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->get()->pluck('value', 'key');
        return inertia('Admin/Settings/Index', ['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site.name' => 'required|string|max:255',
            'site.description' => 'nullable|string|max:500',
            'contact.email' => 'required|email',
            'social.facebook' => 'nullable|url',
            'social.instagram' => 'nullable|url',
            'social.linkedin' => 'nullable|url',
            'social.youtube' => 'nullable|url',
            'seo.meta_title' => 'nullable|string|max:255',
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        foreach ($data as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        return back()->with('success', 'Konfigurasi berhasil diperbarui.');
    }
}
