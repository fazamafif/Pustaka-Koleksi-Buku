@extends('layout.app')

@section('title', 'Koleksi Buku')

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / <span>BUKU</span></div>
    <h2>Koleksi Buku</h2>
  </div>
  <a href="{{ route('Buku.create') }}" class="btn-add">+ Tambah Buku</a>
</div>

<div class="content">
  {{-- Flash Notifications --}}
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

  {{-- Search & Filter Toolbar --}}
  <form action="{{ route('Buku.index') }}" method="GET" class="table-toolbar">
    <div class="search-box">
      <input type="text" name="q" value="{{ request('q') }}" class="search-input" placeholder="Cari judul atau pengarang...">
      <button type="submit" class="btn-search">Cari</button>
      @if(request('q') || request('kategori_id'))
        <a href="{{ route('Buku.index') }}" class="btn-reset">Reset</a>
      @endif
    </div>

    <div style="display:flex; align-items:center; gap:8px;">
      <label style="font-size:12px; font-weight:600; color:var(--ink-soft); text-transform:uppercase;">Kategori:</label>
      <select name="kategori_id" onchange="this.form.submit()" class="search-input" style="width: auto; padding: 8px 12px;">
        <option value="">Semua Kategori</option>
        @foreach($kategoris as $k)
          <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
            {{ $k->nama_kategori }}
          </option>
        @endforeach
      </select>
    </div>
  </form>

  <div class="card" style="padding:16px 20px 8px;">
    <table>
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Tahun</th>
          <th>Penerbit</th>
          <th>Kategori</th>
          <th style="text-align:center; width: 110px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($allBuku as $key => $item)
          <tr>
            <td>{{ $allBuku->firstItem() + $key }}</td>
            <td>
              <div class="book-title">{{ $item->judul }}</div>
            </td>
            <td>
              <div class="book-author">{{ $item->pengarang }}</div>
            </td>
            <td style="font-family:'IBM Plex Mono',monospace;">{{ $item->tahun_terbit }}</td>
            <td>{{ $item->penerbit->nama_penerbit ?? '-' }}</td>
            <td>
              <span class="badge" style="background:#2E5C4A">
                {{ $item->kategori->nama_kategori ?? '-' }}
              </span>
            </td>
            <td>
              <div class="row-actions" style="justify-content:center;">
                <a href="{{ route('Buku.show', $item->id) }}" class="icon-btn" title="Detail">👁</a>
                <a href="{{ route('Buku.edit', $item->id) }}" class="icon-btn" title="Edit">✎</a>
                
                <form action="{{ route('Buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku \'{{ addslashes($item->judul) }}\'?');" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="icon-btn danger" title="Hapus">✕</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr class="empty-row">
            <td colspan="7">
              @if(request('q') || request('kategori_id'))
                Tidak ditemukan buku yang cocok dengan kriteria pencarian.
              @else
                Belum ada data buku tersimpan. Klik "+ Tambah Buku" untuk mulai menambahkan.
              @endif
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{-- Pagination --}}
    @if($allBuku->hasPages())
      <div class="pagination-wrap">
        <div>
          Menampilkan {{ $allBuku->firstItem() ?? 0 }} - {{ $allBuku->lastItem() ?? 0 }} dari {{ $allBuku->total() }} buku
        </div>
        <div>
          {{ $allBuku->links() }}
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
