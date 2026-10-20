@extends('layout.app')

@section('title', 'Detail Buku - ' . $buku->judul)

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / BUKU / <span>DETAIL</span></div>
    <h2>Detail Buku</h2>
  </div>
</div>

<div class="content">
  <div class="card form-container">
    <div class="field">
      <label>Judul Buku</label>
      <div style="font-size:18px; font-weight:700; font-family:'Fraunces',serif; color:var(--ink);">{{ $buku->judul }}</div>
    </div>

    <div class="field">
      <label>Pengarang</label>
      <div style="font-size:15px; font-weight:500;">{{ $buku->pengarang }}</div>
    </div>

    <div class="field">
      <label>Tahun Terbit</label>
      <div style="font-family:'IBM Plex Mono',monospace; font-size:14px;">{{ $buku->tahun_terbit }}</div>
    </div>

    <div class="field">
      <label>Penerbit</label>
      <div style="font-size:14px;">{{ $buku->penerbit->nama_penerbit ?? 'Tidak ditentukan' }}</div>
    </div>

    <div class="field">
      <label>Kategori</label>
      <div>
        <span class="badge" style="background:#2E5C4A;">{{ $buku->kategori->nama_kategori ?? 'Tidak ditentukan' }}</span>
      </div>
    </div>

    <div class="field">
      <label>Ditambahkan Pada</label>
      <div style="font-family:'IBM Plex Mono',monospace; font-size:12px; color:var(--ink-soft);">{{ $buku->created_at ? $buku->created_at->format('d M Y, H:i') : '-' }}</div>
    </div>

    <div class="form-actions" style="margin-top: 30px;">
      <a href="{{ route('Buku.index') }}" class="btn-ghost">← Kembali</a>
      <a href="{{ route('Buku.edit', $buku->id) }}" class="btn-primary">Edit Buku</a>
    </div>
  </div>
</div>
@endsection
