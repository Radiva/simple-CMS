<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function index()
    {
        $portfolios = DB::table('portfolios')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $articles = DB::table('articles')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        return Inertia::render('Public/Index', [
            'portfolios' => $portfolios,
            'articles' => $articles
        ]);
    }

    public function portfolioList()
    {
        $portfolios = DB::table('portfolios')
            ->orderByDesc('published_at')
            ->get();

        return Inertia::render('Public/Portfolios/Index', [
            'portfolios' => $portfolios
        ]);
    }

    public function portfolioDetail($slug)
    {
        $portfolio = DB::table('portfolios')->where('slug', $slug)->first();

        if (!$portfolio) abort(404);

        return Inertia::render('Public/Portfolio/Detail', [
            'portfolio' => $portfolio
        ]);
    }

    public function articleList()
    {
        $articles = DB::table('articles')
            ->orderByDesc('published_at')
            ->get();

        return Inertia::render('Public/Articles/Index', [
            'articles' => $articles
        ]);
    }

    public function articleDetail($slug)
    {
        $articles = DB::table('articles')->where('slug', $slug)->first();

        if (!$articles) abort(404);

        return Inertia::render('Public/Articles/Detail', [
            'articles' => $articles
        ]);
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        DB::table('kontaks')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
