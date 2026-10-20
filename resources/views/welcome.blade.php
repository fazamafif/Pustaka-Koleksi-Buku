@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / <span>DASHBOARD</span></div>
    <h2>Ringkasan Katalog</h2>
  </div>
  <div class="user-chip">
    <div class="avatar">AD</div>
    <span>Admin Perpustakaan</span>
  </div>
</div>

<div class="content">
  <div class="stat-grid">
    <div class="card stat-card">
      <span class="tag">TOTAL</span>
      <div class="num">{{ number_format($totalBuku) }}</div>
      <div class="label">Judul Buku Terdaftar</div>
      <div class="bar"></div>
    </div>
    <div class="card stat-card">
      <span class="tag">AKTIF</span>
      <div class="num">{{ number_format($totalKategori) }}</div>
      <div class="label">Kategori Aktif</div>
      <div class="bar"></div>
    </div>
    <div class="card stat-card">
      <span class="tag">TERDAFTAR</span>
      <div class="num">{{ number_format($totalPenerbit) }}</div>
      <div class="label">Penerbit Terdaftar</div>
      <div class="bar"></div>
    </div>
    <div class="card stat-card">
      <span class="tag">STATUS</span>
      <div class="num">Aktif</div>
      <div class="label">Sistem Katalog Siap</div>
      <div class="bar"></div>
    </div>
  </div>

  <div class="grid-2">
    <!-- Buku Terbaru -->
    <div class="card panel">
      <div class="panel-head">
        <h3>Buku Baru Ditambahkan</h3>
        <a href="{{ route('Buku.index') }}">Lihat Semua →</a>
      </div>
      <div>
        @forelse($recentBuku as $b)
          <div class="list-row">
            <div class="info">
              <div class="title">{{ $b->judul }}</div>
              <div class="meta">{{ $b->pengarang }} · {{ $b->tahun_terbit }} · {{ $b->penerbit->nama_penerbit ?? '-' }}</div>
            </div>
            <div class="badge-meta">
              <span class="badge" style="background:#2E5C4A">{{ $b->kategori->nama_kategori ?? '-' }}</span>
            </div>
          </div>
        @empty
          <div style="padding: 24px; text-align:center; color: var(--ink-soft); font-style: italic;">
            Belum ada buku terdaftar. <a href="{{ route('Buku.create') }}" style="color:var(--brass); text-decoration:underline;">Tambah sekarang</a>.
          </div>
        @endforelse
      </div>
    </div>

    <!-- Distribusi Kategori Populer -->
    <div class="card panel">
      <div class="panel-head">
        <h3>Koleksi Kategori</h3>
        <a href="{{ route('Kategori.index') }}">Kelola →</a>
      </div>
      <div>
        @forelse($kategoriStats as $kat)
          @php
            $pct = $totalBuku > 0 ? round(($kat->bukus_count / $totalBuku) * 100) : 0;
          @endphp
          <div class="cat-bar-row">
            <div class="cat-top">
              <span class="name">{{ $kat->nama_kategori }}</span>
              <span class="count">{{ $kat->bukus_count }} judul ({{ $pct }}%)</span>
            </div>
            <div class="cat-track">
              <div class="cat-fill" style="width: {{ max($pct, 6) }}%; background: var(--forest);"></div>
            </div>
          </div>
        @empty
          <div style="padding: 24px; text-align:center; color: var(--ink-soft); font-style: italic;">
            Belum ada kategori.
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
    <div class="mt-6">
        <a href="{{ route('Buku.popular') }}" class="btn btn-primary">Lihat Koleksi Buku Populer di Indonesia</a>
    </div>
@endsection
