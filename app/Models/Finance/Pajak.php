<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    use HasFactory;
    protected $table = "pajaks";
    protected $fillable = [
        'nama_pajak',
        'persentase',
        'creat_by',
        'creat_by_company'
    ];

    public function accountbank(){
        return $this->hasMany(AccountBank::class, 'pajak_id');
    }

    public function detail_penjualan(){
        return $this->hasMany(DetailPenjualan::class, 'pajak_id');
    }

    public function detail_pembelian(){
        return $this->hasMany(DetailPembelian::class, 'pajak_id');
    }

    public function detail_biaya(){
        return $this->hasMany(DetailBiaya::class, 'pajak_id');
    }

    public function detail_kirim_uang(){
        return $this->hasMany(DetailKirimUang::class, 'pajak_id');
    }

    public function detail_terima_uang(){
        return $this->hasMany(DetailTerimaUang::class, 'pajak_id');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
