@extends('layouts.app')

@section('title', 'Laporan Bulanan')
@section('breadcrumb', 'Laporan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>📈 Rekapitulasi Kunjungan UKS — Tahun {{ $tahun }}</h3>

            {{-- Filter Tahun --}}
            <form action="{{ route('reports.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center;">
                <select name="tahun" class="form-control" style="width: auto; padding: 8px 36px 8px 12px; font-size: 0.85rem;">
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm">🔍 Lihat</button>
            </form>
        </div>

        {{-- Grafik --}}
        <div style="background: #f8fafc; border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <canvas id="chartKunjungan" height="100"></canvas>
        </div>

        {{-- Tabel Rekap --}}
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Jumlah Kunjungan</th>
                        <th>Visual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataPerBulan as $i => $d)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="font-weight: 600;">{{ $d['bulan'] }}</td>
                            <td>
                                <span style="font-weight: 700; font-size: 1.1rem;">{{ $d['jumlah'] }}</span>
                                <span style="color: #94a3b8; font-size: 0.8rem;"> kunjungan</span>
                            </td>
                            <td style="width: 300px;">
                                @if($totalKunjungan > 0)
                                    <div style="background: #e2e8f0; border-radius: 50px; height: 10px; overflow: hidden;">
                                        <div style="background: linear-gradient(90deg, #667eea, #764ba2); height: 100%; border-radius: 50px; width: {{ ($d['jumlah'] / max($totalKunjungan, 1)) * 100 }}%; transition: width 0.5s ease;"></div>
                                    </div>
                                @else
                                    <div style="background: #e2e8f0; border-radius: 50px; height: 10px;"></div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #f0f9ff;">
                        <td colspan="2" style="font-weight: 700; text-align: right;">Total:</td>
                        <td colspan="2" style="font-weight: 700; font-size: 1.2rem; color: #1a1a2e;">
                            {{ $totalKunjungan }} kunjungan
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chartKunjungan').getContext('2d');
            const data = @json($dataPerBulan);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(d => d.bulan),
                    datasets: [{
                        label: 'Jumlah Kunjungan',
                        data: data.map(d => d.jumlah),
                        backgroundColor: [
                            'rgba(102, 126, 234, 0.8)',
                            'rgba(118, 75, 162, 0.8)',
                            'rgba(233, 69, 96, 0.8)',
                            'rgba(17, 153, 142, 0.8)',
                            'rgba(56, 239, 125, 0.8)',
                            'rgba(242, 153, 74, 0.8)',
                            'rgba(102, 126, 234, 0.8)',
                            'rgba(118, 75, 162, 0.8)',
                            'rgba(233, 69, 96, 0.8)',
                            'rgba(17, 153, 142, 0.8)',
                            'rgba(56, 239, 125, 0.8)',
                            'rgba(242, 153, 74, 0.8)',
                        ],
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a1a2e',
                            titleFont: { family: 'Inter' },
                            bodyFont: { family: 'Inter' },
                            cornerRadius: 8,
                            padding: 12,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { family: 'Inter', size: 12 },
                                color: '#64748b',
                            },
                            grid: { color: '#e2e8f0' },
                        },
                        x: {
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#64748b',
                            },
                            grid: { display: false },
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endsection
