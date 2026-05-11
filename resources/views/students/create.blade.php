@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('breadcrumb', 'Data Master → Siswa → Tambah')

@section('content')
    <div class="card" style="max-width: 700px;">
        <div class="card-header">
            <h3>👨‍🎓 Tambah Siswa Baru</h3>
        </div>

        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="nis">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" id="nis" class="form-control"
                           value="{{ old('nis') }}" placeholder="contoh: 2024001" required>
                    @error('nis')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                           value="{{ old('nama') }}" placeholder="contoh: Ahmad Fauzi" required>
                    @error('nama')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="kelas_id">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-control" required>
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="">— Pilih —</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </form>
    </div>
@endsection
