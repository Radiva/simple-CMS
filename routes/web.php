<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CommentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// 🔓 Halaman publik (pengunjung)
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/artikel', [PublicController::class, 'articleList'])->name('artikel.index');
Route::get('/artikel/{slug}', [PublicController::class, 'articleDetail'])->name('artikel.detail');
Route::get('/portofolio', [PublicController::class, 'portfolioList'])->name('portfolio.index');
Route::get('/portofolio/{slug}', [PublicController::class, 'portfolioDetail'])->name('portfolio.detail');
Route::post('/kontak', [PublicController::class, 'contactStore'])->name('contact.store');

// 🔐 Komentar (auth: pengikut)
Route::middleware(['auth'])->group(function () {
    // Route::post('/komentar', [CommentController::class, 'store'])->name('komentar.store');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
