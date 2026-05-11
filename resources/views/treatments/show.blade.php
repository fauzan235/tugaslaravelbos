@extends('layouts.app')

@section('title', 'Detail Kunjungan')
@section('breadcrumb', 'Kunjungan → Detail')

@section('content')
    <div class="card" style="max-width: 700px;">
        <div class="card-header">
            <h3>📋 Detail Kunjungan</h3>
            <a href="{{ route('treatments.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>

        {{-- Info Kunjungan --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
            <div style="background: #f0f9ff; padding: 16px; border-radius: 10px; border: 1px solid #bae6fd;">
                <div style="font-size: 0.75rem; color: #0369a1; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Siswa</div>
                <div style="font-size: 1.1rem; font-weight: 700; margin-top: 4px;">{{ $treatment->student->nama }}</div>
                <div style="font-size: 0.82rem; color: #64748b;">NIS: {{ $treatment->student->nis }}</div>
                <span class="badge badge-info" style="margin-top: 6px;">{{ $treatment->student->kelas->nama_kelas }}</span>
            </div>
            <div style="background: #fefce8; padding: 16px; border-radius: 10px; border: 1px solid #fde68a;">
                <div style="font-size: 0.75rem; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Info Kunjungan</div>
                <div style="font-size: 0.88rem; margin-top: 4px;">
                    📅 {{ $treatment->tanggal_kunjungan->format('d F Y') }}<br>
                    👤 Dicatat oleh: <strong>{{ $treatment->user->name }}</strong>
                </div>
            </div>
        </div>

        {{-- Keluhan & Diagnosa --}}
        <div style="margin-bottom: 20px;">
            <h4 style="font-size: 0.88rem; font-weight: 700; margin-bottom: 8px; color: #1a1a2e;">🤒 Keluhan</h4>
            <div style="background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 14px; font-size: 0.88rem; color: #9a3412;">
                {{ $treatment->keluhan }}
            </div>
        </div>

        @if($treatment->diagnosa)
            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 0.88rem; font-weight: 700; margin-bottom: 8px; color: #1a1a2e;">🔍 Diagnosa Awal</h4>
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 14px; font-size: 0.88rem; color: #166534;">
                    {{ $treatment->diagnosa }}
                </div>
            </div>
        @endif

        {{-- Obat yang Diberikan --}}
        <div>
            <h4 style="font-size: 0.88rem; font-weight: 700; margin-bottom: 8px; color: #1a1a2e;">💊 Obat yang Diberikan</h4>
            @if($treatment->medicines->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($treatment->medicines as $i => $m)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td style="font-weight: 600;">{{ $m->nama_obat }}</td>
                                    <td style="font-weight: 700;">{{ $m->pivot->jumlah }}</td>
                                    <td>{{ $m->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background: #f8fafc; padding: 16px; border-radius: 10px; text-align: center; color: #94a3b8; font-size: 0.85rem;">
                    Tidak ada obat yang diberikan pada kunjungan ini.
                </div>
            @endif
        </div>
    </div>
@endsection
