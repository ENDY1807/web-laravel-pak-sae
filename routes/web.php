<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', [EventController::class, 'index']);

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/admin', function () {
    return view('admin.index');
})->name('admin');

Route::get('/admin/data-artikel', function () {
    return view('admin.data_artikel');
})->name('data_artikel');

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