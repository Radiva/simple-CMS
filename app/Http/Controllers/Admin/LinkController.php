<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        $links = DB::table('links')->orderBy('sort_order')->get();
        return inertia('Admin/Links/Index', ['links' => $links]);
    }

    public function bulkSave(Request $request)
    {
        foreach ($request->links as $index => $item) {
            $validated = validator($item, [
                'title' => 'required|string|max:255',
                'url' => 'required|url',
                'order' => 'required|integer',
                'icon' => 'nullable|file|mimes:png,jpg,jpeg,svg|max:2048',
            ])->validate();

            // Simpan icon jika diupload
            if (isset($item['icon']) && $item['icon'] instanceof \Illuminate\Http\UploadedFile) {
                $iconPath = $item['icon']->store('uploads/icons', 'public');
                $validated['icon'] = $iconPath;
            }

            $validated['updated_at'] = now();

            if (isset($item['id']) && $item['id']) {
                DB::table('links')->where('id', $item['id'])->update($validated);
            } else {
                $validated['created_at'] = now();
                DB::table('links')->insert($validated);
            }
        }

        return back();
    }

    public function destroy($id)
    {
        DB::table('links')->where('id', $id)->delete();
        return back();
    }
}
