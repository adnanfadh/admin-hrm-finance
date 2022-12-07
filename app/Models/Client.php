<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $fillable = [
        'user_id',
        'name',
        'kontak',
        'alamat'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(){
        return $this->hasMany(Project::class, 'client_id');
    }
}
