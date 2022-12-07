<?php

namespace App\Models\Finance;

use App\Models\Company;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
        'jenis_pengajuan',
        'tanggal_pengajuan', 
        'tanggal_approved',
        'penerima',
        'no_surat',
        'perihal_surat',
        'lampiran_surat',
        'total_nominal_pengajuan',
        'status_pengajuan',
        'creat_by',
        'creat_by_company',
        'total_nominal_approved',
        'mengetahui',
        'menyetujui'
    ];


    
    public function track_pengajuan(){
        return $this->hasMany(TrackPengajuan::class, 'id_pengajuan');
    }



    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }

    public function penerimaTo(){
        return $this->belongsTo(Pegawai::class, 'penerima');
    }
    
    public function detail_pengajuan(){
        return $this->hasMany(DetailPengajuan::class, 'id_pengajuan');
    }
}
