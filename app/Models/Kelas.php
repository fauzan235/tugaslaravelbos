<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    /**
     * Nama tabel yang digunakan oleh model.
     */
    protected $table = 'kelas';

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = ['nama_kelas'];

    /**
     * Relasi: Satu kelas memiliki banyak siswa.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
