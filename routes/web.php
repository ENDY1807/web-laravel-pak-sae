<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ArtikelController;

// Halaman Publik (Frontend)
Route::get('/', [EventController::class, 'index'])->name('welcome');

// Auth
Route::get('/login', function () {
    return view('login');
})->name('login');

// Admin Dashboard & Pages
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin');

// CRUD Data Artikel Admin
Route::get('/admin/data-artikel', [ArtikelController::class, 'index'])->name('data_artikel');
Route::post('/admin/data-artikel', [ArtikelController::class, 'store'])->name('data_artikel.store');
Route::put('/admin/data-artikel/{id}', [ArtikelController::class, 'update'])->name('data_artikel.update');
Route::delete('/admin/data-artikel/{id}', [ArtikelController::class, 'destroy'])->name('data_artikel.destroy');

// Halaman Admin Pelengkap Lainnya
Route::get('/admin/charts', function () {
    return view('admin.charts');
})->name('charts');

Route::get('/admin/layout-static', function () {
    return view('admin.layout-static');
})->name('layout_static');

Route::get('/admin/layout-sidenav-light', function () {
    return view('admin.layout-sidenav-light');
})->name('layout_sidenav_light');

Route::get('/admin/401', function () {
    return view('admin.401');
})->name('401');

Route::get('/admin/404', function () {
    return view('admin.404');
})->name('404');

Route::get('/admin/500', function () {
    return view('admin.500');
})->name('500');