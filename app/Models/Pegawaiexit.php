<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawaiexit extends Model
{
    use HasFactory;

    protected $table = "pegawaiexits";
    protected $fillable = [
        'pegawai_id',
        'exit_date',
        'exit_type',
        'description',
        'dokumen_pendukung'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
