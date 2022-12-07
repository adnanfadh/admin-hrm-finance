<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelians';
    protected $fillable = [
        'transaksi',
        'no_transaksi',
        'supplier_id',
        'tanggal_transaksi',
        'metode_pembayaran_id',
        'syarat_pembayaran_id',
        'tanggal_jatuh_tempo',
        'nominal_tagihan',
        'alamat_penagihan',
        'pesan',
        'lampiran',
        'sub_total',
        'discount_pembelian',
        'total',
        'sisa_tagihan',
        'status',
        'creat_by',
        'creat_by_company',
        'jenis_pembelian',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // public function account_bank(){
    //     return $this->belongsTo(AccountBank::class, 'account_bank_id');
    // }

    public function metode_pembayaran(){
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id');
    }

    public function syarat_pembayaran(){
        return $this->belongsTo(SyaratPembayaran::class, 'syarat_pembayaran_id');
    }

    public function detail_pembelian(){
        return $this->hasMany(DetailPembelian::class, 'pembelian_id'); 
    }

    public function tagihan_pembelian(){
        return $this->hasMany(TagihanPembelian::class, 'pembelian_id');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
