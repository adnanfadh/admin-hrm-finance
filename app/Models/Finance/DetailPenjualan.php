<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $table = 'detail_penjualans';
    protected $fillable = [
        'penjualan_id',
        'product_id',
        'qty_pembelian',
        'discount',
        'besar_discount',
        'pajak_id',
        'potongan_pajak',
        'total',
        'nama_jasa',
        'harga_jasa',
        'creat_by',
        'creat_by_company'
    ];

    public function penjualan(){
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
    public function product2(){
        return $this->belongsTo(Product::class, 'product_id');
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
