<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Student;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreatmentController extends Controller
{
    /**
     * Tampilkan daftar semua kunjungan.
     */
    public function index(Request $request)
    {
        $query = Treatment::with(['student.kelas', 'user']);

        // Filter berdasarkan tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->sampai_tanggal);
        }

        // Pencarian nama siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $treatments = $query->latest('tanggal_kunjungan')->get();

        return view('treatments.index', compact('treatments'));
    }

    /**
     * Tampilkan form pencatatan kunjungan baru.
     */
    public function create()
    {
        $students = Student::with('kelas')->orderBy('nama')->get();
        $medicines = Medicine::where('stok', '>', 0)->orderBy('nama_obat')->get();

        return view('treatments.create', compact('students', 'medicines'));
    }

    /**
     * Simpan kunjungan baru + kurangi stok obat (pakai DB Transaction).
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'keluhan' => 'required|string',
            'diagnosa' => 'nullable|string',
            'tanggal_kunjungan' => 'required|date',
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'required_with:medicines|exists:medicines,id',
            'medicines.*.jumlah' => 'required_with:medicines|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Simpan data kunjungan
                $treatment = Treatment::create([
                    'student_id' => $request->student_id,
                    'user_id' => auth()->id(),
                    'keluhan' => $request->keluhan,
                    'diagnosa' => $request->diagnosa,
                    'tanggal_kunjungan' => $request->tanggal_kunjungan,
                ]);

                // 2. Loop obat yang diberikan
                if ($request->has('medicines') && is_array($request->medicines)) {
                    foreach ($request->medicines as $obat) {
                        if (empty($obat['id'])) continue;

                        $medicine = Medicine::lockForUpdate()->find($obat['id']);
                        $jumlah = (int) $obat['jumlah'];

                        // Validasi stok cukup
                        if ($medicine->stok < $jumlah) {
                            throw new \Exception("Stok {$medicine->nama_obat} tidak cukup! Sisa stok: {$medicine->stok} {$medicine->satuan}.");
                        }

                        // 3. Simpan ke treatment_details
                        $treatment->medicines()->attach($medicine->id, ['jumlah' => $jumlah]);

                        // 4. Kurangi stok obat
                        $medicine->decrement('stok', $jumlah);
                    }
                }
            });

            return redirect()->route('treatments.index')
                             ->with('success', 'Kunjungan berhasil dicatat!');
        } catch (\Exception $e) {
            return back()->withInput()
                         ->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan detail kunjungan.
     */
    public function show(Treatment $treatment)
    {
        $treatment->load(['student.kelas', 'user', 'medicines']);
        return view('treatments.show', compact('treatment'));
    }
}
