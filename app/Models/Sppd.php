<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppd extends Model
{
    use HasFactory;

    protected $table = 'sppds';
    protected $fillable = [
        'no_surat',
        'pegawai_id',
        'perihal',
        'tujuan',
        'kendaraan',
        'akomodasi',
        'tanggal_tugas',
        'tanggal_selesai',
        'tanggal_surat'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
