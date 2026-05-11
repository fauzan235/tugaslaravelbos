<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentDetail extends Model
{
    /**
     * Nonaktifkan timestamps karena tabel ini tidak punya kolom created_at/updated_at.
     */
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = ['treatment_id', 'medicine_id', 'jumlah'];

    /**
     * Relasi: Detail resep milik satu kunjungan.
     */
    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    /**
     * Relasi: Detail resep merujuk ke satu obat.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
