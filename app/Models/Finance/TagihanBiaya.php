<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanBiaya extends Model
{
    use HasFactory;
    protected $table = 'tagihan_biayas';
    protected $fillable = [
        'biaya_id',
        'tanggal_bayar',
        'nominal_bayar',
        'account_pembayar',
        'transaksi',
        'no_pembayaran',
        'keterangan',
        'creat_by',
        'creat_by_company'
    ];

    public function biaya(){
        return $this->belongsTo(Biaya::class, 'biaya_id');
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
