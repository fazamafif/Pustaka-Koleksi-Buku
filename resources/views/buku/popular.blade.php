@extends('layout.app')

@section('title', 'Buku Populer di Indonesia')

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / <span>BUKU POPULER</span></div>
    <h2>Koleksi Buku Populer di Indonesia</h2>
  </div>
  <div class="user-chip">
    <div class="avatar">AD</div>
    <span>Admin Perpustakaan</span>
  </div>
</div>

<div class="content">
  <div class="grid-2">
    @forelse($books as $book)
      <div class="card panel">
        <div class="panel-head">
          <h3>{{ $book->judul }}</h3>
        </div>
        <div class="panel-body">
          <p><strong>Pengarang:</strong> {{ $book->pengarang }}</p>
          <p><strong>Tahun Terbit:</strong> {{ $book->tahun_terbit }}</p>
          <p><strong>Penerbit:</strong> {{ $book->penerbit->nama_penerbit ?? '-' }}</p>
          <p><strong>Kategori:</strong> {{ $book->kategori->nama_kategori ?? '-' }}</p>
        </div>
      </div>
    @empty
      <div class="card panel">
        <div class="panel-body">
          <p>Belum ada buku populer yang terdaftar.</p>
          <a href="{{ route('Buku.create') }}" class="btn">Tambah Buku</a>
        </div>
      </div>
    @endforelse
  </div>
</div>
@endsection