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
            ->limit(4)
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

        return Inertia::render('Public/Portfolio/Index', [
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
}
