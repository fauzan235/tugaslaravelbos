@extends('layouts.app')

@section('title', 'Catatan Kunjungan')
@section('breadcrumb', 'Kunjungan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>🩺 Daftar Kunjungan UKS</h3>
            <a href="{{ route('treatments.create') }}" class="btn btn-primary btn-sm">+ Catat Kunjungan</a>
        </div>

        {{-- Filter Bar --}}
        <form action="{{ route('treatments.index') }}" method="GET" class="filter-bar">
            <div class="form-group">
                <label>Cari Siswa</label>
                <input type="text" name="search" class="form-control"
                       value="{{ request('search') }}" placeholder="Nama atau NIS...">
            </div>
            <div class="form-group">
                <label>Dari Tanggal</label>
                <input type="date" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
            </div>
            <div class="form-group">
                <label>Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">🔍 Filter</button>
            <a href="{{ route('treatments.index') }}" class="btn btn-secondary btn-sm">↻ Reset</a>
        </form>

        @if($treatments->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Keluhan</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treatments as $i => $t)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $t->tanggal_kunjungan->format('d/m/Y') }}</td>
                                <td style="font-weight: 600;">{{ $t->student->nama }}</td>
                                <td><span class="badge badge-info">{{ $t->student->kelas->nama_kelas }}</span></td>
                                <td>{{ Str::limit($t->keluhan, 35) }}</td>
                                <td style="font-size: 0.8rem; color: #64748b;">{{ $t->user->name }}</td>
                                <td>
                                    <a href="{{ route('treatments.show', $t) }}" class="btn btn-primary btn-sm">👁️ Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">🩺</div>
                <p>Belum ada data kunjungan.</p>
            </div>
        @endif
    </div>
@endsection
