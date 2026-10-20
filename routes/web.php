<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;

Route::get('/', function () {
    $totalBuku = Buku::count();
    $totalKategori = Kategori::count();
    $totalPenerbit = Penerbit::count();
    $recentBuku = Buku::with(['kategori', 'penerbit'])->latest()->take(5)->get();
    $kategoriStats = Kategori::withCount('bukus')->orderBy('bukus_count', 'desc')->take(5)->get();

    return view('welcome', compact('totalBuku', 'totalKategori', 'totalPenerbit', 'recentBuku', 'kategoriStats'));
})->name('dashboard');

Route::resource('Kategori', KategoriController::class);
Route::resource('Penerbit', PenerbitController::class);
Route::get('buku/popular', [BukuController::class, 'popular'])->name('Buku.popular');
Route::resource('Buku', BukuController::class);
