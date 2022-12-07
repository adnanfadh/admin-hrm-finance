<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebijakanhr extends Model
{
    use HasFactory;

    protected $table = 'kebijakanhr';
    protected $fillable = [
        'title',
        'tanggal',
        'created_by',
        'ringkasan',
        'dokumen_pendukung',
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'created_by');
    }
}
