<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'nama_product',
        'gambar',
        'qty',
        'satuan',
        'harga_satuan',
        'category',
        'creat_by',
        'creat_by_company'
    ];

    public function detail_penjualan(){
        return $this->hasMany(DetailPenjualan::class, 'product_id');
    }

    public function detail_pembelian(){
        return $this->hasMany(DetailPembelian::class, 'product_id');
    }

    public function log_transaksi(){
        return $this->belongsTo(LogTransaksi::class, 'product_id');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
