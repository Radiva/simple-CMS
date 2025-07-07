<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController,
    ArticleController,
    PortfolioController,
    LinkController,
    CategoryController,
    CommentController,
    ContactController,
    SettingController
};

// 🔐 Middleware: hanya user login yang punya role admin/editor
Route::middleware(['auth', 'role:admin|editor'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Artikel
    Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/create', [ArticleController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArticleController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [ArticleController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikel/{id}', [ArticleController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArticleController::class, 'destroy'])->name('artikel.destroy');

    // Portofolio
    Route::resource('portofolio', PortfolioController::class)->except(['show']);

    // Link
    Route::get('/tautan', [LinkController::class, 'index'])->name('tautan.index');
    Route::post('/tautan/bulk-save', [LinkController::class, 'bulkSave'])->name('tautan.bulk-save');
    Route::delete('/tautan/{id}', [LinkController::class, 'destroy'])->name('tautan.destroy');

    // Kategori
    Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [CategoryController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [CategoryController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [CategoryController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [CategoryController::class, 'destroy'])->name('kategori.destroy');

    // Komentar (moderasi)
    Route::get('/komentar', [CommentController::class, 'index'])->name('komentar.index');
    Route::put('/komentar/{id}/approve', [CommentController::class, 'approve'])->name('komentar.approve');
    Route::put('/komentar/{id}/reject', [CommentController::class, 'reject'])->name('komentar.reject');
    Route::delete('/komentar/{id}', [CommentController::class, 'destroy'])->name('komentar.destroy');

    Route::get('/kontak', [ContactController::class, 'index'])->name('kontak.index');
    Route::delete('/kontak/{id}', [ContactController::class, 'destroy'])->name('kontak.destroy');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
});
