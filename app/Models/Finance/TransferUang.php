<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferUang extends Model
{
    use HasFactory;

    protected $table = 'transfer_uangs';
    protected $fillable = [
        'account_transper',
        'account_setor',
        'memo',
        'lampiran',
        'transaksi',
        'no_transaksi',
        'tanggal_transaksi',
        'jumlah',
        'creat_by',
        'creat_by_company'
    ];

    public function account_bank_transfer(){
        return $this->belongsTo(AccountBank::class, 'account_transper');
    }

    public function account_bank_setor(){
        return $this->belongsTo(AccountBank::class, 'account_setor');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
