<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RulesJurnalInput extends Model
{
    use HasFactory;

    protected $table = 'rules_jurnal';
    protected $fillable = [
        'rules_jurnal_category',
        'rules_jurnal_category_2',
        'rules_jurnal_name',
        'rules_jurnal_keterangan',
        'rules_jurnal_akun_debit',
        'rules_jurnal_akun_kredit',
        'rules_jurnal_akun_discount', 
        'rules_jurnal_akun_ppn',
        'creat_by',
        'creat_by_company'
    ];

    public function jurnal_akun_debit(){
        return $this->belongsTo(AccountBank::class, 'rules_jurnal_akun_debit');
    }

    
    public function jurnal_akun_kredit(){
        return $this->belongsTo(AccountBank::class, 'rules_jurnal_akun_kredit');
    }

    public function jurnal_akun_discount(){
        return $this->belongsTo(AccountBank::class, 'rules_jurnal_akun_discount');
    }

    
    public function jurnal_akun_ppn(){
        return $this->belongsTo(AccountBank::class, 'rules_jurnal_akun_ppn');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
