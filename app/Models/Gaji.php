<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gajis';
    protected $fillable = [
        'pegawai_id',
        'tanggal_awal',
        'tanggal_akhir',
        'jumlah_gaji',
        'jumlah_lembur',
        'potongan_bpjs',
        'total_gaji'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
