<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTransaksi extends Model
{
    use HasFactory;

    protected $table = 'log_transaksi';

    protected $fillable = [
        'transaksi_id',
        'transaksi_key',
        'account_bank_id',
        'saldo_awal',
        'saldo_akhir',
        'product_id',
        'stock_awal',
        'stock_akhir',
        'creat_by',
        'creat_by_company'
    ];

    // public function pembelian()

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'account_bank_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
