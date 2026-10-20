@extends('layout.app')

@section('title', 'Kategori Buku')

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / <span>KATEGORI</span></div>
    <h2>Kategori Buku</h2>
  </div>
  <a href="{{ route('Kategori.create') }}" class="btn-add">+ Tambah Kategori</a>
</div>

<div class="content">
  @if(session('success'))
    <div class="alert alert-success">
      <span>✓ {{ session('success') }}</span>
      <button class="close-btn" onclick="this.parentElement.style.display='none'">✕</button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">
      <span>⚠ {{ session('error') }}</span>
      <button class="close-btn" onclick="this.parentElement.style.display='none'">✕</button>
    </div>
  @endif

  {{-- Search Toolbar --}}
  <form action="{{ route('Kategori.index') }}" method="GET" class="table-toolbar">
    <div class="search-box">
      <input type="text" name="q" value="{{ request('q') }}" class="search-input" placeholder="Cari nama kategori...">
      <button type="submit" class="btn-search">Cari</button>
      @if(request('q'))
        <a href="{{ route('Kategori.index') }}" class="btn-reset">Reset</a>
      @endif
    </div>
  </form>

  <div class="card" style="padding:16px 20px 8px;">
    <table>
      <thead>
        <tr>
          <th style="width: 60px;">No</th>
          <th>Nama Kategori</th>
          <th style="width: 140px;">Jumlah Buku</th>
          <th style="text-align:center; width: 110px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($allKategori as $key => $item)
          <tr>
            <td>{{ $allKategori->firstItem() + $key }}</td>
            <td>
              <div class="book-title">{{ $item->nama_kategori }}</div>
            </td>
            <td>
              <span class="badge" style="background:#5A6A5F;">
                {{ $item->bukus_count }} Judul
              </span>
            </td>
            <td>
              <div class="row-actions" style="justify-content:center;">
                <a href="{{ route('Kategori.show', $item->id) }}" class="icon-btn" title="Detail">👁</a>
                <a href="{{ route('Kategori.edit', $item->id) }}" class="icon-btn" title="Edit">✎</a>
                
                <form action="{{ route('Kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ addslashes($item->nama_kategori) }}\'?');" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="icon-btn danger" title="Hapus">✕</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr class="empty-row">
            <td colspan="4">
              @if(request('q'))
                Tidak ditemukan kategori yang cocok dengan pencarian.
              @else
                Belum ada data kategori. Klik "+ Tambah Kategori" untuk mulai menambahkan.
              @endif
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    @if($allKategori->hasPages())
      <div class="pagination-wrap">
        <div>
          Menampilkan {{ $allKategori->firstItem() ?? 0 }} - {{ $allKategori->lastItem() ?? 0 }} dari {{ $allKategori->total() }} kategori
        </div>
        <div>
          {{ $allKategori->links() }}
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
