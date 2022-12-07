<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKerja extends Model
{
    use HasFactory;

    protected $table = 'penilain_kerjas';
    protected $fillable = [
        'bulan',
        'tahun',
        'pegawai_id',
        'bidang_id',
        'bobot_nilai',
        'keterangan'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    // public function bidang(){
    //     return $this->belongsTo(Bidang::class, 'bidang_id');
    // }
}
