<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTerimaUang extends Model
{
    use HasFactory;

    protected $table = 'detail_terima_uangs';
    protected $fillable = [
        'terima_uangs_id',
        'akun_pengirim',
        'deskripsi',
        'pajak_id',
        'potongan_pajak',
        'jumlah'
    ];

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'akun_pengirim');
    }

    public function pajak(){
        return $this->belongsTo(Pajak::class, 'pajak_id');
    }
}
