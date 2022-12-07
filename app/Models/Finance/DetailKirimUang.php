<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKirimUang extends Model
{
    use HasFactory;

    protected $table = 'detail_kirim_uangs';
    protected $fillable = [
        'kirim_uangs_id',
        'akun_tujuan',
        'deskripsi',
        'pajak_id',
        'potongan_pajak',
        'jumlah',
        'creat_by',
        'creat_by_company'
    ];

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'akun_tujuan');
    }

    public function pajak(){
        return $this->belongsTo(Pajak::class, 'pajak_id');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
