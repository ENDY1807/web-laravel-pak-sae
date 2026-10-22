<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class EventController extends Controller
{
    /**
     * Menampilkan halaman depan (welcome) dengan data artikel dari database.
     */
    public function index()
    {
        $artikel = Artikel::orderBy('Tanggal', 'desc')->get();

        return view('welcome', compact('artikel'));
    }
}