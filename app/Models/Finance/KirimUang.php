<?php

namespace App\Models\Finance;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KirimUang extends Model
{
    use HasFactory;

    protected $table = 'kirim_uangs';

    protected $fillable = [
        'account_pembayar',
        'penerima_supplier',
        'penerima_pegawai',
        'tanggal_transaksi',
        'transaksi',
        'no_transaksi',
        'memo',
        'lampiran',
        'sub_total',
        'total',
        'akun_pemotong', 
        'besar_potongan',
        'grand_total',
        'creat_by',
        'creat_by_company'
    ];

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'account_pembayar');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'penerima_supplier');
    }
    
    public function pegawais(){
        return $this->belongsTo(Pegawai::class, 'penerima_pegawai');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
