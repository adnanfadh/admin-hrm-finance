<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bpjs extends Model
{
    use HasFactory;

    protected $table = 'bpjs';
    protected $fillable = [
        'kode_bpjs',
        'pegawai_id',
        'jumlah_iuran'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
