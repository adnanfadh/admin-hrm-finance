<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';
    protected $fillable = [
        'shift_name',
        'hari_kerja',
    ];

    public function pegawai(){
        return $this->hasMany(Pegawai::class, 'shift_id');
    }

    // public function setHariKerjaAttribute($value)
    // {
    //     $this->attributes['hari_kerja'] = json_encode($value);
    // }

    // public function getHariKerjaAttribute($value)
    // {
    //     return $this->attributes['hari_kerja'] = json_decode($value);
    // }
}
