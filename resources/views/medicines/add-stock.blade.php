@extends('layouts.app')

@section('title', 'Tambah Stok Obat')
@section('breadcrumb', 'Stok Obat → Tambah Stok')

@section('content')
    <div class="card" style="max-width: 500px;">
        <div class="card-header">
            <h3>📦 Tambah Stok Masuk</h3>
        </div>

        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 16px; margin-bottom: 20px;">
            <div style="font-size: 0.82rem; color: #0369a1;">
                <strong>{{ $medicine->nama_obat }}</strong><br>
                Stok saat ini: <strong>{{ $medicine->stok }} {{ $medicine->satuan }}</strong>
            </div>
        </div>

        <form action="{{ route('medicines.add-stock', $medicine) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="jumlah">Jumlah Stok Masuk ({{ $medicine->satuan }})</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control"
                       value="{{ old('jumlah') }}" min="1" placeholder="contoh: 20" required autofocus>
                @error('jumlah')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success">📦 Tambah Stok</button>
                <a href="{{ route('medicines.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </form>
    </div>
@endsection
