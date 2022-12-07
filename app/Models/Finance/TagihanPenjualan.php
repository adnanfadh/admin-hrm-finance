<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanPenjualan extends Model
{
    use HasFactory;
    protected $table = 'tagihan_penjualans';
    protected $fillable = [
        'penjualan_id',
        'tanggal_bayar',
        'account_pembayar',
        'nominal_pembayaran',
        'transaksi',
        'no_pembayaran',
        'keterangan',
        'auth_create',
        'creat_by_company'
    ];

    public function penjualan(){
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'account_pembayar');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'auth_create');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
