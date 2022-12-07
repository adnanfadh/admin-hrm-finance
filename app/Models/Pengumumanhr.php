<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumumanhr extends Model
{
    use HasFactory;

    protected $table = 'pengumumanhrs';
    protected $fillable = [
        'title',
        'tanggal',
        'pegawai_id',
        'ringkasan',
        'description',
    ];

    // public function setPegawaiIdAttribute($value)
    // {
    //     $this->attributes['pegawai_id'] = json_encode($value);
    // }

    // public function getPegawaiIdAttribute($value)
    // {
    //     return $this->attributes['pegawai_id'] = json_decode($value);
    // }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
