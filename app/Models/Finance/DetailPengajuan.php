<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengajuan extends Model
{
    use HasFactory;

    protected $table = 'detail_pengajuan'; 

    protected $fillable = [
        'tanggal_pelaksanaan',
        'item',
        'jumlah_item',
        'jumlah_item_approved',
        'budget',
        'budget_approved',
        'keterangan',
        'status',
        'harga',
        'id_pengajuan',
        'vendor',
    ];

    public function pengajuan(){
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }

    public function detail_pembelian(){
        return $this->hasMany(DetailPembelian::class, 'item_pengajuan');
    }
}
