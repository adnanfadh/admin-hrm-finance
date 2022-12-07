<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'client_id',
        'title',
        'prioritas',
        'start_date',
        'end_date',
        'ringkasan_project',
        'pegawai_id',
        'description',
        'status_project',
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function taskproject(){
        return $this->hasMany(TaskProject::class, 'project_id');
    }
}
