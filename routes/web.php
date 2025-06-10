<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NovelController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\YouruploadController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\NovelController as BackendNovelController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Frontend novel library
Route::get('/library', [NovelController::class, 'index'])->name('novel.index');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Tambah novel frontend
    Route::get('/tambah-novel', [NovelController::class, 'create'])->name('frontend.novel.create');
    Route::post('/tambah-novel', [NovelController::class, 'store'])->name('frontend.novel.store');
    Route::put('/your-upload/update/{id}', [NovelController::class, 'update'])->name('frontend.novel.update');
    Route::delete('/your-upload/delete/{id}', [NovelController::class, 'destroy'])->name('frontend.novel.delete');

    // Favorite system
    Route::get('/favorit', [FavoriteController::class, 'index'])->name('favorit.index');
    Route::post('/favorit/toggle', [FavoriteController::class, 'toggle'])->name('favorit.toggle');

    // Your Uploads
    Route::get('/your-upload', [YouruploadController::class, 'index'])->name('your.upload');

    // Admin dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // form cetak laporan user
    Route::get('backend/laporan/formuser', [AuthController::class, 'formUser'])->name('backend.laporan.formuser');
    Route::post('backend/laporan/cetakuser', [AuthController::class, 'cetakUser'])->name('backend.laporan.cetakuser');

    Route::get('backend/laporan/formnovel', [BackendNovelController::class, 'formNovel'])->name('backend.laporan.formnovel');
    Route::post('backend/laporan/cetaknovel', [BackendNovelController::class, 'cetakNovel'])->name('backend.laporan.cetaknovel');

    // Backend routes (admin area)
    Route::prefix('backend')->name('backend.')->group(function () {
        Route::resource('genre', GenreController::class);
        Route::resource('user', UserController::class);
        Route::resource('novel', BackendNovelController::class); // ← Tambahkan ini
    });
});
