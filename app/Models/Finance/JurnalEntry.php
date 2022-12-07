<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalEntry extends Model
{
    use HasFactory;

    protected $table = 'jurnal_entri'; 
    protected $fillable = [
        'transaksi_id',
        'account_id',
        'tanggal_transaksi',
        'debit',
        'kredit',
        'category',
        'keterangan',
        'tahapan',
        'creat_by',
        'creat_by_company'
    ];

    public function account_bank(){
        return $this->belongsTo(AccountBank::class, 'account_id');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }

    public function jurnal_penyesuaian(){
        return $this->hasMany(jurnal_penyesuaian::class, 'jurnal_entry_id');
    }
}
