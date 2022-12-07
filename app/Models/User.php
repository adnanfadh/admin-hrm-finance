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
use App\Models\Finance\TrackPengajuan;
use App\Models\Finance\TransferUang;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
        'pegawai_id',
        'username',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function user_track_pengajuan(){
        return $this->hasMany(TrackPengajuan::class, 'user_action');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function client(){
        return $this->hasOne(Client::class, 'user_id');
    }

    
    public function auth_penjualan(){
        return $this->hasMany(Penjualan::class, 'auth_create');
    }

    public function creatbyMetodePembayaran(){
        return $this->hasMany(MetodePembayaran::class, 'creat_by');
    }

    public function creatbySyaratPembayaran(){
        return $this->hasMany(SyaratPembayaran::class, 'creat_by');
    }

    public function creatbyPajaks(){
        return $this->hasMany(Pajak::class, 'creat_by');
    }

    public function creatbyCategoryAccount(){
        return $this->hasMany(CategoryAccount::class, 'creat_by');
    }

    public function creatbyRulesJurnal(){
        return $this->hasMany(RulesJurnalInput::class, 'creat_by');
    }
    
    public function creatbyProduct(){
        return $this->hasMany(Product::class, 'creat_by');
    }

    public function creatbyCustomer(){
        return $this->hasMany(Customer::class, 'creat_by');
    }

    public function creatbySupplier(){
        return $this->hasMany(Supplier::class, 'creat_by');
    }

    public function creatbyAccountBank(){
        return $this->hasMany(AccountBank::class, 'creat_by');
    }

    public function creatbySaldoAwal(){
        return $this->hasMany(SaldoAwal::class, 'creat_by');
    }

    public function creatbyTransferUang(){
        return $this->hasMany(TransferUang::class, 'creat_by');
    }

    public function creatbyJurnalEntri(){
        return $this->hasMany(JurnalEntry::class, 'creat_by');
    }

    public function creatbyKirimUang(){
        return $this->hasMany(KirimUang::class, 'creat_by');
    }

    public function creatbyDetailKirimUang(){
        return $this->hasMany(DetailKirimUang::class, 'creat_by');
    }

    public function creatbyTerimaUang(){
        return $this->hasMany(TerimaUang::class, 'creat_by');
    }

    public function creatbyDetailTerimaUang(){
        return $this->hasMany(DetailTerimaUang::class, 'creat_by');
    }

    public function creatbyBiaya(){
        return $this->hasMany(Biaya::class, 'creat_by');
    }

    public function creatbyDetailBiaya(){
        return $this->hasMany(DetailBiaya::class, 'creat_by');
    }

    public function creatbyTagihanBiaya(){
        return $this->hasMany(TagihanBiaya::class, 'creat_by');
    }

    public function creatbyDetailPenjualan(){
        return $this->hasMany(DetailPenjualan::class, 'creat_by');
    }

    public function creatbyTagihanPenjualan(){
        return $this->hasMany(TagihanPenjualan::class, 'auth_create');
    }

    public function creatbyLogTransaksi(){
        return $this->hasMany(LogTransaksi::class, 'creat_by');
    }

    public function creatbyPembelian(){
        return $this->hasMany(Pembelian::class, 'creat_by');
    }

    public function creatbyDetailPembelian(){
        return $this->hasMany(DetailPembelian::class, 'creat_by');
    }

    public function creatbyTagihanPembelian(){
        return $this->hasMany(TagihanPembelian::class, 'creat_by');
    }

    public function creatbyPengajuan(){
        return $this->hasMany(Pengajuan::class, 'creat_by');
    }

}
