@extends('layout.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / KATEGORI / <span>EDIT</span></div>
    <h2>Edit Kategori</h2>
  </div>
</div>

<div class="content">
  <div class="card form-container">
    <form action="{{ route('Kategori.update', $kategori->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="field">
        <label for="nama_kategori">Nama Kategori <span style="color:var(--burgundy)">*</span></label>
        <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="@error('nama_kategori') is-invalid @enderror">
        @error('nama_kategori')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-actions">
        <a href="{{ route('Kategori.index') }}" class="btn-ghost">Batal</a>
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection
