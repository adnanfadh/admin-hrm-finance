<?php

namespace App\Models\Finance;

use App\Models\Company;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiSecond extends Model
{
    use HasFactory;

    protected $table = 'gaji_second';

    protected $fillable = [
        'pegawai_id',
        'periode',
        'gaji_pokok',
        'tunjangan_kerajinan',
        'tunjangan_makan',
        'tunjangan_jabatan',
        'lembur_harian',
        'lembur_hari_libur',
        'lembur_event',
        'perjalanan_dinas',
        'tunjangan_keluarga',
        'biaya_jabatan',
        'tabungan',
        'bpjs_kesehatan',
        'bpjs_ketenagakerjaan',
        'potongan_lain_lain',
        'total_penerimaan',
        'total_potongan',
        'pajak_21',
        'catatan',
        'total_gaji_bersih',
        'creat_by_company',
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
