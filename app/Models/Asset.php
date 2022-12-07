<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $fillable = [
        'bidang_id',
        'asset'
    ];

    public function bidang(){
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
}
