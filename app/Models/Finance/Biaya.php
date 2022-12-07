<?php

namespace App\Models\Finance;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    use HasFactory;

    protected $table = 'biayas';
    protected $fillable = [
        'account_pembayar',
        'bayar_nanti',
        'tanggal_jatuh_tempo',
        'syarat_pembayaran',
        'penerima_supplier',
        'penerima_pegawai',
        'tanggal_transaksi',
        'transaksi',
        'no_biaya',
        'metode_pembayaran',
        'alamat_penagihan',
        'memo',
        'lampiran',
        'sub_total',
        'total',
        'akun_pemotong',
        'besar_potongan',
        'grand_total',
        'sisa_tagihan',
        'category',
        'status',
        'verifikasi',
        'company_id',
        'creat_by',
    ];

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'account_pembayar');
    }

    public function metode_pembayarans(){
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran');
    }

    public function syarat_pembayarans(){
        return $this->belongsTo(SyaratPembayaran::class, 'syarat_pembayaran');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'penerima_pegawai');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'penerima_supplier');
    }

    public function detail_biaya(){
        return $this->hasMany(DetailBiaya::class, 'akun_biaya');
    }

    public function tagihan_biaya(){
        return $this->hasMany(TagihanBiaya::class, 'biaya_id');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'company_id');
    }
}
