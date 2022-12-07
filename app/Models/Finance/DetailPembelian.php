<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DetailPembelian extends Model
{
    use HasFactory;

    protected $table = 'detail_pembelians';
    protected $fillable = [
        'pembelian_id',
        'product_id',
        'qty_pembelian',
        'discount_product',
        'total_discount',
        'pajak_id',
        'potongan_pajak',
        'total',
        'creat_by',
        'creat_by_company',
        'item_pengajuan'
    ];

    public function pengajuan(){
        return $this->belongsTo(DetailPengajuan::class, 'item_pengajuan');
    }

    public function pembelian(){
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }
    public function product(){
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
