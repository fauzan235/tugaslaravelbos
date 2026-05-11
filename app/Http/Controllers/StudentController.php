<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Kelas;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Tampilkan daftar semua siswa.
     */
    public function index(Request $request)
    {
        $query = Student::with('kelas');

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Pencarian nama/NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('nama')->get();
        $kelasList = Kelas::all();

        return view('students.index', compact('students', 'kelasList'));
    }

    /**
     * Tampilkan form tambah siswa baru.
     */
    public function create()
    {
        $kelasList = Kelas::all();
        return view('students.create', compact('kelasList'));
    }

    /**
     * Simpan siswa baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:students,nis',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        Student::create($request->only('nis', 'nama', 'kelas_id', 'jenis_kelamin'));

        return redirect()->route('students.index')
                         ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit siswa.
     */
    public function edit(Student $student)
    {
        $kelasList = Kelas::all();
        return view('students.edit', compact('student', 'kelasList'));
    }

    /**
     * Update data siswa.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:students,nis,' . $student->id,
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $student->update($request->only('nis', 'nama', 'kelas_id', 'jenis_kelamin'));

        return redirect()->route('students.index')
                         ->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Hapus data siswa.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
                         ->with('success', 'Data siswa berhasil dihapus!');
    }
}
