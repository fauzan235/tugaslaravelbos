@extends('layouts.app')

@section('title', 'Data Siswa')
@section('breadcrumb', 'Data Master → Siswa')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>📋 Daftar Siswa</h3>
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
        </div>

        {{-- Filter Bar --}}
        <form action="{{ route('students.index') }}" method="GET" class="filter-bar">
            <div class="form-group">
                <label>Cari Nama/NIS</label>
                <input type="text" name="search" class="form-control"
                       value="{{ request('search') }}" placeholder="Ketik nama atau NIS...">
            </div>
            <div class="form-group">
                <label>Filter Kelas</label>
                <select name="kelas_id" class="form-control">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">🔍 Filter</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">↻ Reset</a>
        </form>

        @if($students->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $i => $s)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><code>{{ $s->nis }}</code></td>
                                <td style="font-weight: 600;">{{ $s->nama }}</td>
                                <td><span class="badge badge-info">{{ $s->kelas->nama_kelas }}</span></td>
                                <td>
                                    <span class="badge {{ $s->jenis_kelamin == 'L' ? 'badge-info' : 'badge-warning' }}">
                                        {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('students.edit', $s) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                                        <form action="{{ route('students.destroy', $s) }}" method="POST"
                                              onsubmit="return confirm('Yakin hapus siswa {{ $s->nama }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">👨‍🎓</div>
                <p>Belum ada data siswa. Silakan tambah siswa baru.</p>
            </div>
        @endif
    </div>
@endsection
