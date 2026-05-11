<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = ['nama_obat', 'satuan', 'stok'];

    /**
     * Relasi: Obat bisa digunakan di banyak kunjungan (many-to-many via treatment_details).
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'treatment_details')
                    ->withPivot('jumlah');
    }
}
