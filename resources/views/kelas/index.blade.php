@extends('layouts.app')

@section('title', 'Data Kelas')
@section('breadcrumb', 'Data Master → Kelas')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>📋 Daftar Kelas</h3>
            <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm">+ Tambah Kelas</a>
        </div>

        @if($kelas->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas as $i => $k)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td style="font-weight: 600;">{{ $k->nama_kelas }}</td>
                                <td><span class="badge badge-info">{{ $k->students_count }} siswa</span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('kelas.edit', $k) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                                        <form action="{{ route('kelas.destroy', $k) }}" method="POST"
                                              onsubmit="return confirm('Yakin hapus kelas {{ $k->nama_kelas }}?')">
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
                <div class="empty-icon">🏫</div>
                <p>Belum ada data kelas. Silakan tambah kelas baru.</p>
            </div>
        @endif
    </div>
@endsection
