<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jurnal_penyesuaian extends Model
{
    use HasFactory;

    protected $table = 'jurnal_penyesuian';
    protected $fillable = [
        'jurnal_entry_id',
        'account_id',
        'tanggal',
        'debit',
        'kredit',
        'keterangan',
    ];

    public function jurnal_entri(){
        return $this->belongsTo(JurnalEntry::class, 'jurnal_entry_id');
    }
}
