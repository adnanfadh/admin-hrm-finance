<?php

namespace App\Models\Finance;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $fillable = [
        'transaksi',
        'no_transaksi',
        'customer_id',
        'tanggal_transaksi',
        'metode_pembayaran_id',
        'syarat_pembayaran_id',
        'tanggal_jatuh_tempo',
        'nominal_tagihan',
        'alamat_penagihan',
        'pesan',
        'lampiran',
        'sub_total',
        'total',
        'sisa_tagihan',
        'discount_global',
        'status',
        'type_penjualan',
        'auth_create',
        'akun_tujuan',
        'creat_by_company'
    ];


    public function user_create(){
        return $this->belongsTo(User::class, 'auth_create');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'akun_tujuan');
    }

    public function metode_pembayaran(){
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id');
    }

    public function syarat_pembayaran(){
        return $this->belongsTo(SyaratPembayaran::class, 'syarat_pembayaran_id');
    }

    public function detail_penjualan(){
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    public function tagihan_penjualan(){
        return $this->hasMany(TagihanPenjualan::class, 'penjualan_id');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
