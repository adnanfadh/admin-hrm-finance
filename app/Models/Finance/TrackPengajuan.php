<?php

namespace App\Models\Finance;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackPengajuan extends Model
{
    use HasFactory;

    protected $table = 'track_pengajuan';
    protected $fillable = [
        'id_pengajuan',
        'tanggal_action',
        'user_action',
        'keterangan_track'
    ];

    public function pengajuan(){
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }

    public function user_action(){
        return $this->belongsTo(User::class, 'user_action');
    }
}
