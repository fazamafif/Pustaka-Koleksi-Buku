@extends('layout.app')

@section('title', 'Edit Penerbit')

@section('content')
<div class="topbar">
  <div>
    <div class="breadcrumb">PUSTAKA / PENERBIT / <span>EDIT</span></div>
    <h2>Edit Data Penerbit</h2>
  </div>
</div>

<div class="content">
  <div class="card form-container">
    <form action="{{ route('Penerbit.update', $penerbit->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="field">
        <label for="nama_penerbit">Nama Penerbit <span style="color:var(--burgundy)">*</span></label>
        <input type="text" id="nama_penerbit" name="nama_penerbit" value="{{ old('nama_penerbit', $penerbit->nama_penerbit) }}" class="@error('nama_penerbit') is-invalid @enderror">
        @error('nama_penerbit')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-actions">
        <a href="{{ route('Penerbit.index') }}" class="btn-ghost">Batal</a>
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection
