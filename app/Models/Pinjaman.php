<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjamans';
    protected $fillable = [
        'pegawai_id',
        'tanggal_pinjam',
        'jumlah_pinjam',
        'angsuran',
        'alasan'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
