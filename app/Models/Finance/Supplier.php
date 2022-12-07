<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'email_supplier',
        'alamat_supplier',
        'kontak_supplier',
        'creat_by',
        'creat_by_company'
    ];

    public function pembelian(){
        return $this->hasMany(Pembelian::class, 'supplier_id');
    }

    public function biaya(){
        return $this->hasMany(Biaya::class, 'penerima_supplier');
    }

    public function kirim_uang(){
        return $this->hasMany(KirimUang::class, 'penerima_supplier');
    }

    public function terima_uang(){
        return $this->hasMany(TerimaUang::class, 'pengirim_supplier');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
