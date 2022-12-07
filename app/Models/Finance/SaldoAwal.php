<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoAwal extends Model
{
    use HasFactory;

    protected $table = 'saldo_awal';
    protected $fillable = [
        'transaksi',
        'account',
        'tanggal_transaksi',
        'debit',
        'kredit',
        'creat_by',
        'creat_by_company'
    ];

    public function account(){
        return $this->hasMany(AccountBank::class, "account");
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
