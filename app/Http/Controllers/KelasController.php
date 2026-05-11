<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Tampilkan daftar semua kelas.
     */
    public function index()
    {
        $kelas = Kelas::withCount('students')->get();
        return view('kelas.index', compact('kelas'));
    }

    /**
     * Tampilkan form tambah kelas baru.
     */
    public function create()
    {
        return view('kelas.create');
    }

    /**
     * Simpan kelas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        Kelas::create($request->only('nama_kelas'));

        return redirect()->route('kelas.index')
                         ->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit kelas.
     */
    public function edit(Kelas $kela)
    {
        return view('kelas.edit', ['kelas' => $kela]);
    }

    /**
     * Update data kelas.
     */
    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        $kela->update($request->only('nama_kelas'));

        return redirect()->route('kelas.index')
                         ->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Hapus kelas dari database.
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect()->route('kelas.index')
                         ->with('success', 'Kelas berhasil dihapus!');
    }
}
