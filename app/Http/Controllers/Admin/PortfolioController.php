<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = DB::table('portfolios')
            ->select('portfolios.*')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/Portfolios/Index', [
            'portfolios' => $portfolios,
        ]);
    }

    public function create()
    {
        $categories = DB::table('categories')->get();

        return Inertia::render('Admin/Portfolios/Form', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'project_url' => 'nullable|url',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $slug = Str::slug($validated['title']);

            // Cek apakah slug unik
            $slugExists = DB::table('portfolios')->where('slug', $slug)->exists();
            if ($slugExists) {
                $slug .= '-' . uniqid();
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('portofolio', 'public');
            }

            $portfolioId = DB::table('portfolios')->insertGetId([
                'title' => $validated['title'],
                'slug' => $slug,
                'description' => $validated['description'],
                'project_url' => $validated['project_url'],
                'image' => $imagePath,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!empty($validated['category_ids'])) {
                DB::table('portfolio_category')->insert(
                    collect($validated['category_ids'])->map(fn($id) => [
                        'portfolio_id' => $portfolioId,
                        'category_id' => $id
                    ])->all()
                );
            }

            DB::commit();

            return redirect()->route('admin.portofolio.index')->with('success', 'Portofolio berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal simpan portofolio', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Gagal menyimpan portofolio'])->withInput();
        }
    }

    public function edit($id)
    {
        $portfolio = DB::table('portfolios')->find($id);

        $selectedCategories = DB::table('portfolio_category')
            ->where('portfolio_id', $id)
            ->pluck('category_id');

        $categories = DB::table('categories')->get();

        return Inertia::render('Admin/Portfolios/Form', [
            'portfolio' => $portfolio,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'project_url' => 'nullable|url',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $portfolio = DB::table('portfolios')->find($id);
            if (!$portfolio) {
                abort(404);
            }

            $slug = Str::slug($validated['title']);
            if ($slug !== $portfolio->slug) {
                $slugExists = DB::table('portfolios')->where('slug', $slug)->where('id', '!=', $id)->exists();
                if ($slugExists) {
                    $slug .= '-' . uniqid();
                }
            } else {
                $slug = $portfolio->slug;
            }

            $imagePath = $portfolio->image;
            if ($request->hasFile('image')) {
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('portofolio', 'public');
            }

            DB::table('portfolios')->where('id', $id)->update([
                'title' => $validated['title'],
                'slug' => $slug,
                'description' => $validated['description'],
                'project_url' => $validated['project_url'],
                'image' => $imagePath,
                'updated_at' => now(),
            ]);

            DB::table('portfolio_category')->where('portfolio_id', $id)->delete();
            if (!empty($validated['category_ids'])) {
                DB::table('portfolio_category')->insert(
                    collect($validated['category_ids'])->map(fn($catId) => [
                        'portfolio_id' => $id,
                        'category_id' => $catId,
                    ])->all()
                );
            }

            DB::commit();

            return redirect()->route('admin.portofolio.index')->with('success', 'Portofolio berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal update portofolio', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Gagal memperbarui portofolio'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $portfolio = DB::table('portfolios')->find($id);
            if ($portfolio?->image) {
                Storage::disk('public')->delete($portfolio->image);
            }

            DB::table('portfolio_category')->where('portfolio_id', $id)->delete();
            DB::table('portfolios')->where('id', $id)->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Portofolio berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal hapus portofolio', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Gagal menghapus portofolio']);
        }
    }
}
