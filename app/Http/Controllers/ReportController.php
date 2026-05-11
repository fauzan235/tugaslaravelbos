<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Tampilkan laporan rekapitulasi kunjungan per bulan.
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);

        // Ambil daftar tahun yang ada di database
        $tahunList = Treatment::selectRaw('DISTINCT YEAR(tanggal_kunjungan) as tahun')
                              ->orderBy('tahun', 'desc')
                              ->pluck('tahun')
                              ->toArray();

        // Kalau belum ada data, tambahkan tahun sekarang
        if (empty($tahunList)) {
            $tahunList = [(string)now()->year];
        }

        // Rekapitulasi per bulan
        $laporan = Treatment::selectRaw('
                MONTH(tanggal_kunjungan) as bulan,
                COUNT(*) as jumlah_kunjungan
            ')
            ->whereYear('tanggal_kunjungan', $tahun)
            ->groupByRaw('MONTH(tanggal_kunjungan)')
            ->orderByRaw('MONTH(tanggal_kunjungan)')
            ->get();

        // Siapkan data untuk 12 bulan (isi 0 kalau tidak ada data)
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $dataPerBulan = [];
        foreach ($namaBulan as $num => $nama) {
            $found = $laporan->firstWhere('bulan', $num);
            $dataPerBulan[] = [
                'bulan' => $nama,
                'bulan_num' => $num,
                'jumlah' => $found ? $found->jumlah_kunjungan : 0,
            ];
        }

        $totalKunjungan = array_sum(array_column($dataPerBulan, 'jumlah'));

        return view('reports.index', compact('dataPerBulan', 'tahun', 'tahunList', 'totalKunjungan', 'namaBulan'));
    }
}
