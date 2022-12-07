<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratPembayaran extends Model
{
    use HasFactory;
    protected $table = 'syarat_pembayarans';
    protected $fillable = [
        'nama_syarat',
        'jangka_waktu',
        'account_bank',
        'creat_by',
        'creat_by_company'
    ];

    public function penjualan(){
        return $this->hasMany(Penjualan::class, 'syarat_pembayaran_id');
    }

    public function pembelian(){
        return $this->hasMany(Pembelian::class, 'syarat_pembayaran_id');
    }

    public function biaya(){
        return $this->hasMany(Biaya::class, 'syarat_pembayaran');
    }

    public function account(){
        return $this->belongsTo(AccountBank::class, 'account_bank');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
