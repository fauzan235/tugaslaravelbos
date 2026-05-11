@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Beranda')

@section('content')
    {{-- Stat Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">👨‍🎓</div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalSiswa }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">💊</div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalObat }}</div>
                <div class="stat-label">Jenis Obat</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">🩺</div>
            <div class="stat-info">
                <div class="stat-value">{{ $kunjunganHariIni }}</div>
                <div class="stat-label">Kunjungan Hari Ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">📅</div>
            <div class="stat-info">
                <div class="stat-value">{{ $kunjunganBulanIni }}</div>
                <div class="stat-label">Kunjungan Bulan Ini</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        {{-- Kunjungan Terbaru --}}
        <div class="card">
            <div class="card-header">
                <h3>🩺 Kunjungan Terbaru</h3>
                <a href="{{ route('treatments.create') }}" class="btn btn-primary btn-sm">+ Catat Baru</a>
            </div>
            @if($kunjunganTerbaru->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Keluhan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kunjunganTerbaru as $k)
                                <tr>
                                    <td>{{ $k->tanggal_kunjungan->format('d/m/Y') }}</td>
                                    <td style="font-weight: 600;">{{ $k->student->nama }}</td>
                                    <td><span class="badge badge-info">{{ $k->student->kelas->nama_kelas }}</span></td>
                                    <td>{{ Str::limit($k->keluhan, 40) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">🩺</div>
                    <p>Belum ada data kunjungan hari ini.</p>
                </div>
            @endif
        </div>

        {{-- Obat Stok Rendah --}}
        <div class="card">
            <div class="card-header">
                <h3>⚠️ Stok Obat Rendah</h3>
            </div>
            @if($obatRendah->count() > 0)
                @foreach($obatRendah as $obat)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                        <div>
                            <div style="font-weight: 600; font-size: 0.88rem;">{{ $obat->nama_obat }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $obat->satuan }}</div>
                        </div>
                        <span class="badge {{ $obat->stok <= 3 ? 'badge-danger' : 'badge-warning' }}">
                            Sisa: {{ $obat->stok }}
                        </span>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon">✅</div>
                    <p>Semua stok obat aman!</p>
                </div>
            @endif
        </div>
    </div>
@endsection
