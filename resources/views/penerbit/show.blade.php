@extends('layout.app')

@section('title', 'Detail Penerbit - ' . $penerbit->nama_penerbit)

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / PENERBIT / <span>DETAIL</span></div>
    <h2>Detail Penerbit</h2>
  </div>
  <a href="{{ route('Penerbit.edit', $penerbit->id) }}" class="btn-add">✎ Edit Penerbit</a>
</div>

<div class="content">
  <div class="card form-container" style="max-width: 800px; margin-bottom: 24px;">
    <div class="field">
      <label>Nama Penerbit</label>
      <div style="font-size:20px; font-weight:700; font-family:'Fraunces',serif; color:var(--ink);">{{ $penerbit->nama_penerbit }}</div>
    </div>
    <div class="field">
      <label>Total Koleksi Buku</label>
      <div style="font-family:'IBM Plex Mono',monospace; font-size:15px; color:var(--brass);">{{ $penerbit->bukus->count() }} Judul Buku</div>
    </div>

    <div class="form-actions" style="margin-top: 20px;">
      <a href="{{ route('Penerbit.index') }}" class="btn-ghost">← Kembali ke Daftar</a>
    </div>
  </div>

  {{-- List buku yang diterbitkan oleh penerbit ini --}}
  <div class="card" style="padding:16px 20px 8px;">
    <h3 style="font-family:'Fraunces',serif; font-size:16px; margin-bottom:14px; padding: 4px 0;">Buku Terbitan Penerbit Ini</h3>
    <table>
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Tahun</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($penerbit->bukus as $key => $buku)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td><div class="book-title">{{ $buku->judul }}</div></td>
            <td><div class="book-author">{{ $buku->pengarang }}</div></td>
            <td style="font-family:'IBM Plex Mono',monospace;">{{ $buku->tahun_terbit }}</td>
            <td>
              <span class="badge" style="background:#2E5C4A;">{{ $buku->kategori->nama_kategori ?? '-' }}</span>
            </td>
            <td>
              <a href="{{ route('Buku.show', $buku->id) }}" class="icon-btn" title="Detail">👁</a>
            </td>
          </tr>
        @empty
          <tr class="empty-row">
            <td colspan="6">Belum ada buku terdaftar dari penerbit ini.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
