@extends('layout.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / KATEGORI / <span>TAMBAH</span></div>
    <h2>Tambah Kategori Baru</h2>
  </div>
</div>

<div class="content">
  <div class="card form-container">
    <form action="{{ route('Kategori.store') }}" method="POST">
      @csrf

      <div class="field">
        <label for="nama_kategori">Nama Kategori <span style="color:var(--burgundy)">*</span></label>
        <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Contoh: Fiksi, Sains, Sejarah" class="@error('nama_kategori') is-invalid @enderror">
        @error('nama_kategori')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-actions">
        <a href="{{ route('Kategori.index') }}" class="btn-ghost">Batal</a>
        <button type="submit" class="btn-primary">Simpan Kategori</button>
      </div>
    </form>
  </div>
</div>
@endsection
