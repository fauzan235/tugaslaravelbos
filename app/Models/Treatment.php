<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = ['student_id', 'user_id', 'keluhan', 'diagnosa', 'tanggal_kunjungan'];

    /**
     * Cast tanggal_kunjungan ke tipe date.
     */
    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'date',
        ];
    }

    /**
     * Relasi: Kunjungan milik satu siswa.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi: Kunjungan dicatat oleh satu petugas.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Kunjungan bisa menggunakan banyak obat (many-to-many via treatment_details).
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'treatment_details')
                    ->withPivot('jumlah');
    }

    /**
     * Relasi: Kunjungan punya banyak detail resep.
     */
    public function treatmentDetails()
    {
        return $this->hasMany(TreatmentDetail::class);
    }
}
