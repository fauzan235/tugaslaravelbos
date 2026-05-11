@extends('layouts.app')

@section('title', 'Edit Kelas')
@section('breadcrumb', 'Data Master → Kelas → Edit')

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>✏️ Edit Kelas</h3>
        </div>

        <form action="{{ route('kelas.update', $kelas) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control"
                       value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required autofocus>
                @error('nama_kelas')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </form>
    </div>
@endsection
