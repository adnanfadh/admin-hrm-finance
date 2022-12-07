<?php

namespace App\Models\Finance;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;
    protected $table = 'metode_pembayaran';
    protected $fillable = [
        'nama_metode',
        'account_bank',
        'creat_by',
        'creat_by_company'
    ];

    public function penjualan(){
        return $this->hasMany(Penjualan::class, 'metode_pembayaran_id');
    }

    public function pembelian(){
        return $this->hasMany(Pembelian::class, 'metode_pembayaran_id');
    }

    public function biaya(){
        return $this->hasMany(Biaya::class, 'metode_pembayaran');
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
