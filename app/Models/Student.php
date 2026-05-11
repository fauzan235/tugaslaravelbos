<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = ['nis', 'nama', 'kelas_id', 'jenis_kelamin'];

    /**
     * Relasi: Siswa milik satu kelas.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relasi: Siswa punya banyak riwayat kunjungan.
     */
    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }
}
