<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'kode_customer',
        'nama_customer',
        'email',
        'alamat',
        'kontak',
        'creat_by',
        'creat_by_company'
    ];

    public function penjualan(){
        return $this->hasMany(Penjualan::class, 'customer_id');
    }

    public function terima_uang(){
        return $this->hasMany(TerimaUang::class, 'pengirim_customer');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
