<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sp extends Model
{
    use HasFactory;

    protected $table = 'surat_peringatans';
    protected $fillable = [
        'no_surat',
        'pegawai_id',
        'pelanggaran',
        'tanggal',
        'sangsi',
        'masa_berlaku'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
