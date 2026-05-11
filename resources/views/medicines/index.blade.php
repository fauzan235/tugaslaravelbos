@extends('layouts.app')

@section('title', 'Stok Obat')
@section('breadcrumb', 'Stok Obat')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>💊 Daftar Stok Obat</h3>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('medicines.create') }}" class="btn btn-primary btn-sm">+ Tambah Obat</a>
            @endif
        </div>

        @if($medicines->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Status</th>
                            @if(auth()->user()->isAdmin())
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines as $i => $m)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td style="font-weight: 600;">{{ $m->nama_obat }}</td>
                                <td>{{ $m->satuan }}</td>
                                <td style="font-weight: 700; font-size: 1.05rem;">{{ $m->stok }}</td>
                                <td>
                                    @if($m->stok <= 0)
                                        <span class="badge badge-danger">Habis</span>
                                    @elseif($m->stok < 10)
                                        <span class="badge badge-warning">Stok Rendah</span>
                                    @else
                                        <span class="badge badge-success">Tersedia</span>
                                    @endif
                                </td>
                                @if(auth()->user()->isAdmin())
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('medicines.add-stock', $m) }}" class="btn btn-success btn-sm">📦 + Stok</a>
                                            <a href="{{ route('medicines.edit', $m) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                                            <form action="{{ route('medicines.destroy', $m) }}" method="POST"
                                                  onsubmit="return confirm('Yakin hapus obat {{ $m->nama_obat }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">💊</div>
                <p>Belum ada data obat.</p>
            </div>
        @endif
    </div>
@endsection
