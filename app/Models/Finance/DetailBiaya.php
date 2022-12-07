<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBiaya extends Model
{
    use HasFactory;

    protected $table = 'detail_biayas';
    protected $fillable = [
        'biaya_id',
        'akun_biaya',
        'deskripsi',
        'pajak_id',
        'potongan_pajak',
        'jumlah',
        'creat_by',
        'creat_by_company'
    ];

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'akun_biaya');
    }

    public function pajak(){
        return $this->belongsTo(Pajak::class, 'pajak_id');
    }

    public function biaya(){
        return $this->belongsTo(Biaya::class, 'akun_biaya');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
