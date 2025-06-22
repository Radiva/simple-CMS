<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = DB::table('articles')
            ->select('id', 'title', 'slug', 'status', 'published_at', 'created_at')
            ->orderByDesc('created_at')
            ->paginate(10);

        return Inertia::render('Admin/Articles/Index', [
            'articles' => $articles,
        ]);
    }

    public function create()
    {
        $categories = DB::table('categories')->select('id', 'name')->get();

        return Inertia::render('Admin/Articles/Form', [
            'article' => null,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'category_ids' => 'array',
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($validated['title']);
            $id = DB::table('articles')->insertGetId([
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'],
                'status' => $validated['status'],
                'user_id' => auth()->id(),
                'published_at' => $validated['status'] === 'published' ? now() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan kategori
            if (!empty($validated['category_ids'])) {
                $kategoriData = collect($validated['category_ids'])->map(fn ($catId) => [
                    'article_id' => $id,
                    'category_id' => $catId,
                ])->toArray();

                DB::table('article_category')->insert($kategoriData);
            }

            DB::commit();
            return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan artikel.'])->withInput();
        }
    }

    public function edit($id)
    {
        $article = DB::table('articles')->where('id', $id)->first();

        if (!$article) return abort(404);

        $category_ids = DB::table('article_category')
            ->where('article_id', $id)
            ->pluck('category_id');

        $categories = DB::table('categories')->select('id', 'name')->get();

        return Inertia::render('Admin/Articles/Form', [
            'article' => $article,
            'selectedCategories' => $category_ids,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'category_ids' => 'array',
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($validated['title']);

            DB::table('articles')->where('id', $id)->update([
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'],
                'status' => $validated['status'],
                'published_at' => $validated['status'] === 'published' ? now() : null,
                'updated_at' => now(),
            ]);

            // Reset kategori
            DB::table('article_category')->where('artikel_id', $id)->delete();

            if (!empty($validated['category_ids'])) {
                $kategoriData = collect($validated['category_ids'])->map(fn ($catId) => [
                    'article_id' => $id,
                    'category_id' => $catId,
                ])->toArray();

                DB::table('article_category')->insert($kategoriData);
            }

            DB::commit();
            return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui artikel.'])->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('article_category')->where('article_id', $id)->delete();
            DB::table('articles')->where('id', $id)->delete();

            DB::commit();
            return back()->with('success', 'Artikel dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus artikel.']);
        }
    }
}
