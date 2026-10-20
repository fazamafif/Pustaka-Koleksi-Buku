@extends('layout.app')

@section('title', 'Detail Kategori - ' . $kategori->nama_kategori)

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / KATEGORI / <span>DETAIL</span></div>
    <h2>Detail Kategori</h2>
  </div>
  <a href="{{ route('Kategori.edit', $kategori->id) }}" class="btn-add">✎ Edit Kategori</a>
</div>

<div class="content">
  <div class="card form-container" style="max-width: 800px; margin-bottom: 24px;">
    <div class="field">
      <label>Nama Kategori</label>
      <div style="font-size:20px; font-weight:700; font-family:'Fraunces',serif; color:var(--ink);">{{ $kategori->nama_kategori }}</div>
    </div>
    <div class="field">
      <label>Total Koleksi Buku</label>
      <div style="font-family:'IBM Plex Mono',monospace; font-size:15px; color:var(--brass);">{{ $kategori->bukus->count() }} Judul Buku</div>
    </div>

    <div class="form-actions" style="margin-top: 20px;">
      <a href="{{ route('Kategori.index') }}" class="btn-ghost">← Kembali ke Daftar</a>
    </div>
  </div>

  {{-- List buku yang masuk ke kategori ini --}}
  <div class="card" style="padding:16px 20px 8px;">
    <h3 style="font-family:'Fraunces',serif; font-size:16px; margin-bottom:14px; padding: 4px 0;">Buku dalam Kategori Ini</h3>
    <table>
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Tahun</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kategori->bukus as $key => $buku)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td><div class="book-title">{{ $buku->judul }}</div></td>
            <td><div class="book-author">{{ $buku->pengarang }}</div></td>
            <td style="font-family:'IBM Plex Mono',monospace;">{{ $buku->tahun_terbit }}</td>
            <td>
              <a href="{{ route('Buku.show', $buku->id) }}" class="icon-btn" title="Detail">👁</a>
            </td>
          </tr>
        @empty
          <tr class="empty-row">
            <td colspan="5">Belum ada buku terdaftar dalam kategori ini.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
