<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $kategori = DB::table('categories')->orderBy('name')->get();

        return Inertia::render('Admin/Categories/Index', [
            'kategori' => $kategori
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Categories/Form', ['kategori' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        DB::table('categories')->insert([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = DB::table('categories')->where('id', $id)->first();

        return Inertia::render('Admin/Categories/Form', [
            'kategori' => $kategori,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        DB::table('categories')->where('id', $id)->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();

        return back()->with('success', 'Kategori dihapus.');
    }
}
