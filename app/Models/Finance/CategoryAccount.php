<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAccount extends Model
{
    use HasFactory;

    protected $table = 'category_accounts';
    protected $fillable = [
        'nomor_category_account',
        'nama_category_account',
        'creat_by',
        'creat_by_company'
    ];

    public function account_bank(){
        return $this->hasMany(AccountBank::class, 'category');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
