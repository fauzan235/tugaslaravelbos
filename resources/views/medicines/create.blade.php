@extends('layouts.app')

@section('title', 'Tambah Obat')
@section('breadcrumb', 'Stok Obat → Tambah')

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>💊 Tambah Obat Baru</h3>
        </div>

        <form action="{{ route('medicines.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" class="form-control"
                       value="{{ old('nama_obat') }}" placeholder="contoh: Paracetamol" required>
                @error('nama_obat')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control"
                           value="{{ old('satuan') }}" placeholder="contoh: tablet, botol, sachet" required>
                    @error('satuan')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stok">Stok Awal</label>
                    <input type="number" name="stok" id="stok" class="form-control"
                           value="{{ old('stok', 0) }}" min="0" required>
                    @error('stok')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('medicines.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </form>
    </div>
@endsection
