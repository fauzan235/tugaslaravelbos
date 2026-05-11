@extends('layouts.app')

@section('title', 'Edit Obat')
@section('breadcrumb', 'Stok Obat → Edit')

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>✏️ Edit Data Obat</h3>
        </div>

        <form action="{{ route('medicines.update', $medicine) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" class="form-control"
                       value="{{ old('nama_obat', $medicine->nama_obat) }}" required>
                @error('nama_obat')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" name="satuan" id="satuan" class="form-control"
                       value="{{ old('satuan', $medicine->satuan) }}" required>
                @error('satuan')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Stok Saat Ini</label>
                <input type="text" class="form-control" value="{{ $medicine->stok }} {{ $medicine->satuan }}" disabled
                       style="background: #f1f5f9;">
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
                    * Stok hanya bisa diubah melalui menu "Tambah Stok"
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="{{ route('medicines.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </form>
    </div>
@endsection
