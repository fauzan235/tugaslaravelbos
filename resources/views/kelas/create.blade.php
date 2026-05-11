@extends('layouts.app')

@section('title', 'Tambah Kelas')
@section('breadcrumb', 'Data Master → Kelas → Tambah')

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>🏫 Tambah Kelas Baru</h3>
        </div>

        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control"
                       value="{{ old('nama_kelas') }}" placeholder="contoh: X RPL 1" required autofocus>
                @error('nama_kelas')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </form>
    </div>
@endsection
