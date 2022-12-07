<?php

namespace App\Models\Finance;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerimaUang extends Model
{
    use HasFactory;

    protected $table = 'terima_uangs';
    protected $fillable = [
        'account_setor',
        'pengirim_customer',
        'pengirim_pegawai',
        'tanggal_transaksi',
        'transaksi',
        'no_transaksi',
        'memo',
        'lampiran',
        'sub_total',
        'total',
        'creat_by',
        'creat_by_company'
    ];

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'account_setor');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'pengirim_customer');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pengirim_pegawai');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
    
}
