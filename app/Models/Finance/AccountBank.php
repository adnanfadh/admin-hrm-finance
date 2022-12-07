<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountBank extends Model
{
    use HasFactory;

    protected $table = 'account_banks';

    protected $fillable = [
        'nama',
        'nomor',
        'category',
        'details',
        'pajak_id',
        'nama_bank',
        'no_rekening',
        'saldo',
        'deskripsi',
        'status',
        'debit',
        'kredit',
        'parent_account',
        'reimburse',
        'creat_by',
        'creat_by_company'
    ];

    public function pajak(){
        return $this->belongsTo(Pajak::class, 'pajak_id');
    }

    public function category_account(){
        return $this->belongsTo(CategoryAccount::class, 'category');
    }

    public function biaya(){
        return $this->hasMany(Biaya::class, 'account_pembayar');
    }

    public function kirim_uang(){
        return $this->hasMany(KirimUang::class, 'account_pembayar');
    }

    public function terima_uang(){
        return $this->hasMany(TerimaUang::class, 'account_setor');
    }

    public function detail_biaya(){
        return $this->hasMany(DetailBiaya::class, 'akun_biaya');
    }

    public function jurnal_entri(){
        return $this->hasMany(JurnalEntry::class, 'account_id');
    }

    public function tagihan_biaya(){
        return $this->hasMany(TagihanBiaya::class, 'account_pembayar');
    }

    public function tagihan_pembelian(){
        return $this->hasMany(TagihanPembelian::class, 'account_pembayar');
    }

    public function tagihan_penjualan(){
        return $this->hasMany(TagihanPenjualan::class, 'account_pembayar');
    }

    public function detail_kirim_uang(){
        return $this->hasMany(detail_kirim_uang::class, 'akun_tujuan');
    }

    public function transper_uang_transfer(){
        return $this->hasMany(TransferUang::class, 'account_transper');
    }

    public function transper_uang_setor(){
        return $this->hasMany(TransferUang::class, 'account_setor');
    }

    public function detail_terima_uang(){
        return $this->hasMany(DetailTerimaUang::class, 'akun_pengirim');
    }

    public function log_transaksi(){
        return $this->hasMany(LogTransaksi::class, 'account_bank_id');
    }

    public function saldo_awal(){
        return $this->belongsTo(SaldoAwal::class, "account");
    }
    
    public function rules_jurnal_debit(){
        return $this->hasMany(RulesJurnalInput::class, 'rules_jurnal_akun_debit');
    }

    public function rules_jurnal_kredit(){
        return $this->hasMany(RulesJurnalInput::class, 'rules_jurnal_akun_kredit');
    }

    public function rules_jurnal_discount(){
        return $this->hasMany(RulesJurnalInput::class, 'rules_jurnal_akun_discount');
    }

    public function rules_jurnal_ppn(){
        return $this->hasMany(RulesJurnalInput::class, 'rules_jurnal_akun_ppn');
    }

    public function syarat_pembayaran(){
        return $this->hasMany(SyaratPembayaran::class, 'account_bank');
    }

    public function metode_pembayaran(){
        return $this->hasMany(MetodePembayaran::class, 'account_bank');
    }

    public function penjualan(){
        return $this->hasMany(Penjualan::class, 'akun_tujuan');
    }

    public function creatby(){
        return $this->belongsTo(User::class, 'creat_by');
    }

    public function creatbycompany(){
        return $this->belongsTo(Company::class, 'creat_by_company');
    }
}
