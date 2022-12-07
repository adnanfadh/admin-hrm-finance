<?php

namespace App\Models;

use App\Models\Finance\Biaya;
use App\Models\Finance\GajiSecond;
use App\Models\Finance\Pengajuan;
use App\Models\Finance\TerimaUang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';
    protected $fillable = [
        'nip',
        'kode_pegawai',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'status',
        'tlp',
        'bidang_id',
        'jabatan_id',
        'shift_id',
        'company_id',
        'ttd'
    ];

    public function bidang(){
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    public function shift(){
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function lembur(){
        return $this->hasMany(Lembur::class, 'pegawai_id');
    }

    public function project(){
        return $this->hasMany(Project::class, 'pegawai_id');
    }

    public function cuti(){
        return $this->hasMany(Cuti::class, 'pegawai_id');
    }

    public function absen(){
        return $this->hasMany(Absen::class, 'pegawai_id');
    }

    public function sp(){
        return $this->hasMany(Sp::class, 'pegawai_id');
    }

    public function sppd(){
        return $this->hasMany(Sppd::class, 'pegawai_id');
    }

    public function penilaiankerja(){
        return $this->hasMany(PenilaianKerja::class, 'pegawai_id');
    }

    public function bpjs(){
        return $this->hasOne(Bpjs::class, 'pegawai_id');
    }

    public function gaji(){
        return $this->hasMany(Gaji::class, 'pegawai_id');
    }

    public function users(){
        return $this->hasOne(Users::class, 'pegawai_id'); 
    }

    public function pinjaman(){
        return $this->hasMany(Pinjaman::class, 'pegawai_id');
    }

    public function pegawaiexit(){
        return $this->hasOne(Pegawaiexit::class, 'pegawai_id');
    }

    public function pengumumanhr(){
        return $this->hasMany(Pengumumanhr::class, 'pegawai_id');
    }

    public function kebijakanhr(){
        return $this->hasMany(Kebijakanhr::class, 'created_by');
    }

    public function biaya(){
        return $this->hasMany(Biaya::class, 'penerima_pegawai');
    }

    public function terima_uang(){
        return $this->hasMany(TerimaUang::class, 'pengirim_pegawai');
    }

    public function kirim_uang(){
        return $this->hasMany(KirimUang::class, 'penerima_pegawai');
    }


    public function company_wewenang1(){
        return $this->hasMany(Company::class, 'pemberi_wewenang1');
    }

    public function company_wewenang2(){
        return $this->hasMany(Company::class, 'pemberi_wewenang2');
    }

    public function company_wewenang3(){
        return $this->hasMany(Company::class, 'pemberi_wewenang3');
    }

    public function pengajuan(){
        return $this->hasMany(Pengajuan::class, 'penerima');
    }


    public function gaji_second(){
        return $this->hasMany(GajiSecond::class, 'pegawai_id');
    }

}
