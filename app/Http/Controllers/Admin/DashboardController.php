<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Hitung data summary
        $totalArtikel = DB::table('articles')->count();
        $totalPortofolio = DB::table('portfolios')->count();
        $totalKomentar = DB::table('comments')->count();
        $totalTautan = DB::table('links')->count();
        $totalKategori = DB::table('categories')->count();

        // Ambil role pertama
        $role = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_id', $user->id)
            ->value('roles.name');

        return Inertia::render('Admin/Dashboard', [
            'summary' => [
                'artikel' => $totalArtikel,
                'portofolio' => $totalPortofolio,
                'komentar' => $totalKomentar,
                'tautan' => $totalTautan,
                'kategori' => $totalKategori,
            ],
            'role' => $role,
        ]);
    }
}
