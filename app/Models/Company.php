<?php

namespace App\Models;

use App\Models\Finance\AccountBank;
use App\Models\Finance\Biaya;
use App\Models\Finance\CategoryAccount;
use App\Models\Finance\Customer;
use App\Models\Finance\DetailBiaya;
use App\Models\Finance\DetailKirimUang;
use App\Models\Finance\DetailPembelian;
use App\Models\Finance\DetailPenjualan;
use App\Models\Finance\DetailTerimaUang;
use App\Models\Finance\GajiSecond;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\KirimUang;
use App\Models\Finance\LogTransaksi;
use App\Models\Finance\MetodePembayaran;
use App\Models\Finance\Pajak;
use App\Models\Finance\Pembelian;
use App\Models\Finance\Pengajuan;
use App\Models\Finance\Penjualan;
use App\Models\Finance\Product;
use App\Models\Finance\RulesJurnalInput;
use App\Models\Finance\SaldoAwal;
use App\Models\Finance\Supplier;
use App\Models\Finance\SyaratPembayaran;
use App\Models\Finance\TagihanBiaya;
use App\Models\Finance\TagihanPembelian;
use App\Models\Finance\TagihanPenjualan;
use App\Models\Finance\TerimaUang;
use App\Models\Finance\TransferUang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $fillable = [
        'kode_company',
        'nama_company',
        'email_company',
        'npwp_company',
        'telpon_company',
        'alamat_company',
        'logo_company',
        'website_company',
        'pemberi_wewenang1',
        'pemberi_wewenang2',
        'pemberi_wewenang3'
    ];

    public function pegawai(){
        return $this->hasMany(Pegawai::class, 'company_id');
    }

    public function pemberi_wewenang1(){
        return $this->belongsTo(Pegawai::class, 'pemberi_wewenang1');
    }

    public function pemberi_wewenang2(){
        return $this->belongsTo(Pegawai::class, 'pemberi_wewenang2');
    }

    public function pemberi_wewenang3(){
        return $this->belongsTo(Pegawai::class, 'pemberi_wewenang3');
    }

    public function creatbycompanyMetodePembayarans(){
        return $this->hasMany(MetodePembayaran::class, 'creat_by_company');
    }

    public function creatbycompanySyaratPembayarans(){
        return $this->hasMany(SyaratPembayaran::class, 'creat_by_company');
    }

    public function creatbycompanyPajak(){
        return $this->hasMany(Pajak::class, 'creat_by_company');
    }

    public function creatbycompanyCategoryAccount(){
        return $this->hasMany(CategoryAccount::class, 'creat_by_company');
    }

    public function creatbycompanyRulesJurnal(){
        return $this->hasMany(RulesJurnalInput::class, 'creat_by_company');
    }

    public function creatbycompanyProduct(){
        return $this->hasMany(Product::class, 'creat_by_company');
    }

    public function creatbycompanyCustomer(){
        return $this->hasMany(Customer::class, 'creat_by_company');
    }

    public function creatbycompanySupplier(){
        return $this->hasMany(Supplier::class, 'creat_by_company');
    }

    public function creatbycompanyAccountBanks(){
        return $this->hasMany(AccountBank::class, 'creat_by_company');
    }

    public function creatbycompanySaldoAwal(){
        return $this->hasMany(SaldoAwal::class, 'creat_by_company');
    }

    public function creatbycompanyTransferUangs(){
        return $this->hasMany(TransferUang::class, 'creat_by_company');
    }

    public function creatbycompanyJurnalEntri(){
        return $this->hasMany(JurnalEntry::class, 'creat_by_company');
    }

    public function creatbycompanyKirimUang(){
        return $this->hasMany(KirimUang::class, 'creat_by_company');
    }

    public function creatbycompanyDetailKirimUang(){
        return $this->hasMany(DetailKirimUang::class, 'creat_by_company');
    }

    public function creatbycompanyTerimaUang(){
        return $this->hasMany(TerimaUang::class, 'creat_by_company');
    }

    public function creatbycompanyDetailTerimaUang(){
        return $this->hasMany(DetailTerimaUang::class, 'creat_by_company');
    }

    public function creatbycompanyBiaya(){
        return $this->hasMany(Biaya::class, 'company_id');
    }

    public function creatbycompanyDetailBiaya(){
        return $this->hasMany(DetailBiaya::class, 'creat_by_company');
    }

    public function creatbycompanyTagihanBiaya(){
        return $this->hasMany(TagihanBiaya::class, 'creat_by_company');
    }

    public function creatbycompanyPenjualan(){
        return $this->hasMany(Penjualan::class, 'creat_by_company');
    }

    public function creatbycompanyDetailPenjualan(){
        return $this->hasMany(DetailPenjualan::class, 'creat_by_company');
    }

    public function creatbycompanyTagihanPenjualan(){
        return $this->hasMany(TagihanPenjualan::class, 'creat_by_company');
    }

    public function creatbycompanyLogTransaksi(){
        return $this->hasMany(LogTransaksi::class, 'creat_by_company');
    }

    public function creatbycompanyPembelian(){
        return $this->hasMany(Pembelian::class, 'creat_by_company');
    }

    public function creatbycompanyDetailPembelian(){
        return $this->hasMany(DetailPembelian::class, 'creat_by_company');
    }

    public function creatbycompanyTagihanPembelian(){
        return $this->hasMany(TagihanPembelian::class, 'creat_by_company');
    }

    
    public function creatbycompanyPengajuan(){
        return $this->hasMany(Pengajuan::class, 'creat_by_company');
    }

    public function creatbycompanyGajiSecond(){
        return $this->hasMany(GajiSecond::class, 'creat_by_company');
    }
}
