@extends('layout.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / BUKU / <span>TAMBAH</span></div>
    <h2>Tambah Buku Baru</h2>
  </div>
</div>

<div class="content">
  <div class="card form-container">
    <form action="{{ route('Buku.store') }}" method="POST">
      @csrf

      <div class="field">
        <label for="judul">Judul Buku <span style="color:var(--burgundy)">*</span></label>
        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Laskar Pelangi" class="@error('judul') is-invalid @enderror">
        @error('judul')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="field">
        <label for="pengarang">Pengarang <span style="color:var(--burgundy)">*</span></label>
        <input type="text" id="pengarang" name="pengarang" value="{{ old('pengarang') }}" placeholder="Contoh: Andrea Hirata" class="@error('pengarang') is-invalid @enderror">
        @error('pengarang')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="field">
        <label for="tahun_terbit">Tahun Terbit <span style="color:var(--burgundy)">*</span></label>
        <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" min="1800" max="{{ date('Y') + 1 }}" placeholder="Contoh: 2005" class="@error('tahun_terbit') is-invalid @enderror">
        @error('tahun_terbit')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="field">
        <label for="penerbit_id">Penerbit <span style="color:var(--burgundy)">*</span></label>
        <select id="penerbit_id" name="penerbit_id" class="@error('penerbit_id') is-invalid @enderror">
          <option value="">-- Pilih Penerbit --</option>
          @foreach ($penerbit as $p)
            <option value="{{ $p->id }}" {{ old('penerbit_id') == $p->id ? 'selected' : '' }}>
              {{ $p->nama_penerbit }}
            </option>
          @endforeach
        </select>
        @error('penerbit_id')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="field">
        <label for="kategori_id">Kategori <span style="color:var(--burgundy)">*</span></label>
        <select id="kategori_id" name="kategori_id" class="@error('kategori_id') is-invalid @enderror">
          <option value="">-- Pilih Kategori --</option>
          @foreach ($kategori as $k)
            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
              {{ $k->nama_kategori }}
            </option>
          @endforeach
        </select>
        @error('kategori_id')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-actions">
        <a href="{{ route('Buku.index') }}" class="btn-ghost">Batal</a>
        <button type="submit" class="btn-primary">Simpan Buku</button>
      </div>
    </form>
  </div>
</div>
@endsection
