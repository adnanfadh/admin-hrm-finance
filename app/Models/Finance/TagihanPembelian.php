<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanPembelian extends Model
{
    use HasFactory;

    protected $table = 'tagihan_pembelians';
    protected $fillable = [
        'pembelian_id',
        'tanggal_bayar',
        'account_pembayar',
        'nominal_pembayaran',
        'transaksi',
        'no_pembayaran',
        'keterangan',
        'creat_by',
        'creat_by_company'
    ];

    public function pembelian(){
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'account_pembayar');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }

    
}
