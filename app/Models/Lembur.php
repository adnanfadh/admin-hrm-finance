<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lemburs';
    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'jam_masuk_lembur',
        'jam_keluar_lembur',
        'pekerjaan',
        'uraian_pekerjaan',
        'status_lembur'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
