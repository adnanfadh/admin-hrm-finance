<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidangs';
    protected $fillable = [
        'kode_bidang',
        'nama'
    ];

    public function jabatan(){
        return $this->hasMany(Jabatan::class, 'bidang_id');
    }

    public function pegawai(){
        return $this->hasMany(Pegawai::class, 'bidang_id');
    }

    // public function penilaiankerja(){
    //     return $this->hasMany(PenilaianKerja::class, 'bidang_id');
    // }

    public function asset(){
        return $this->hasMany(Asset::class, 'bidang_id');
    }
}
