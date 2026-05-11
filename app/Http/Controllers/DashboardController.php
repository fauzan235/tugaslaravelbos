<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Medicine;
use App\Models\Treatment;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard dengan ringkasan data.
     */
    public function index()
    {
        $totalSiswa = Student::count();
        $totalObat = Medicine::count();
        $kunjunganHariIni = Treatment::whereDate('tanggal_kunjungan', today())->count();
        $kunjunganBulanIni = Treatment::whereMonth('tanggal_kunjungan', now()->month)
                                      ->whereYear('tanggal_kunjungan', now()->year)
                                      ->count();

        // Obat dengan stok rendah (< 10)
        $obatRendah = Medicine::where('stok', '<', 10)->get();

        // 5 Kunjungan terbaru
        $kunjunganTerbaru = Treatment::with(['student.kelas', 'user'])
                                     ->latest('tanggal_kunjungan')
                                     ->take(5)
                                     ->get();

        return view('dashboard', compact(
            'totalSiswa',
            'totalObat',
            'kunjunganHariIni',
            'kunjunganBulanIni',
            'obatRendah',
            'kunjunganTerbaru'
        ));
    }
}
