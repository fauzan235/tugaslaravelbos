<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Tampilkan daftar semua obat + stok.
     */
    public function index()
    {
        $medicines = Medicine::orderBy('nama_obat')->get();
        return view('medicines.index', compact('medicines'));
    }

    /**
     * Tampilkan form tambah obat baru.
     */
    public function create()
    {
        return view('medicines.create');
    }

    /**
     * Simpan obat baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
        ]);

        Medicine::create($request->only('nama_obat', 'satuan', 'stok'));

        return redirect()->route('medicines.index')
                         ->with('success', 'Obat berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit obat.
     */
    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    /**
     * Update data obat.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
        ]);

        $medicine->update($request->only('nama_obat', 'satuan'));

        return redirect()->route('medicines.index')
                         ->with('success', 'Data obat berhasil diperbarui!');
    }

    /**
     * Hapus data obat.
     */
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('medicines.index')
                         ->with('success', 'Data obat berhasil dihapus!');
    }

    /**
     * Tampilkan form tambah stok masuk.
     */
    public function showAddStock(Medicine $medicine)
    {
        return view('medicines.add-stock', compact('medicine'));
    }

    /**
     * Proses tambah stok obat.
     */
    public function addStock(Request $request, Medicine $medicine)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $medicine->increment('stok', $request->jumlah);

        return redirect()->route('medicines.index')
                         ->with('success', "Stok {$medicine->nama_obat} berhasil ditambah {$request->jumlah} {$medicine->satuan}!");
    }
}
