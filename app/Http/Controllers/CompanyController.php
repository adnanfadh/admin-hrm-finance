<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Finance\AccountBank;
use App\Models\Finance\CategoryAccount;
use App\Models\Finance\MetodePembayaran;
use App\Models\Finance\Pajak;
use App\Models\Finance\RulesJurnalInput;
use App\Models\Finance\SyaratPembayaran;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:company-list|company-create|company-edit|company-delete', ['only' => ['index','store']]);
         $this->middleware('permission:company-create', ['only' => ['create','store']]);
         $this->middleware('permission:company-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Company::all();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px 0px 10px 10px; margin:10px;">
                                    <a class="dropdown-item" href="' . route('company.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('company.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }

        //  $bidang = Bidang::all();
        // return response()->json($bidang);
        return view('pages.company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->with(['company'])->where('company_id', Auth::user()->pegawai->company->id)->get();
        return view('pages.company.create', [
            'pegawai'   => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_company'               => 'required|unique:company',
            'nama_company'                  => 'required',
            'email_company'               => 'required',
            'npwp_company'                  => 'required',
            'telpon_company'               => 'required',
            'alamat_company'                  => 'required',
            'logo_company'               => 'required',
        ]);
        $data = $request->all();
        // dd($data);

        if (!empty($request->logo_company)) {
            $data['logo_company'] = $request->file('logo_company')->store('assets/dokumen/company', 'public');
        }

        
        $msg = Company::create($data);

        $idCompany = DB::getPdo()->lastInsertId();
        
        // code to make duplicate pajak by company id
        $get_all_pajak = Pajak::query()->where('creat_by_company', 1)->get();
        foreach ($get_all_pajak as $gap) {
            Pajak::create([
                'nama_pajak' => $gap->nama_pajak, 
                'persentase' => $gap->persentase,  
                'creat_by_company'=> $idCompany
            ]);
        }

        // code to make duplicate Category Account by company id
        $get_all_category_account = CategoryAccount::query()->where('creat_by_company', 1)->get();
        foreach ($get_all_category_account as $gaca) {
            CategoryAccount::create([
                'nomor_category_account' => $gaca->nomor_category_account,
                'nama_category_account' => $gaca->nama_category_account,
                'creat_by_company' => $idCompany
            ]);
        }

        // code to make duplicate syarat pembayaran by company id
        $get_all_syarat_pembayaran = SyaratPembayaran::query()->where('creat_by_company', 1)->get();
        foreach ($get_all_syarat_pembayaran as $gasp) {
            SyaratPembayaran::create([
                'nama_syarat' => $gasp->nama_syarat,
                'jangka_waktu' => $gasp->jangka_waktu,
                'creat_by_company' => $idCompany
            ]);
        }

        // code to make duplicate Account Bank by company id
        $get_all_account_bank = AccountBank::query()->where('creat_by_company', 1)->get();
        foreach ($get_all_account_bank as $gaab) {
            $penjualan = new AccountBank();
            $penjualan->nama            = $gaab->nama;
            $penjualan->nomor           = $gaab->nomor;

            $get_data_category = CategoryAccount::findOrFail($gaab->category);
            // dd($get_data_category);
            if ($get_data_category) {
                $get_category_account_by = CategoryAccount::query()->where('creat_by_company', $idCompany)->where('nomor_category_account', $get_data_category->nomor_category_account)->where('nama_category_account', $get_data_category->nama_category_account)->get();
                foreach ($get_category_account_by as $gcab) {
                    $penjualan->category        = $gcab->id;
                }
            }
            $penjualan->details         = $gaab->details;


            $get_data_pajak = Pajak::findOrFail($gaab->pajak_id);
            if ($get_data_pajak) {
                $get_pajak_by = Pajak::query()->where('creat_by_company', $idCompany)->where('nama_pajak', $get_data_pajak->nama_pajak)->where('persentase', $get_data_pajak->persentase)->get();
                foreach ($get_pajak_by as $gpb) {
                    $penjualan->pajak_id        = $gpb->id;
                }
            }
            $penjualan->nama_bank       = $gaab->nama_bank;
            $penjualan->no_rekening     = $gaab->no_rekening;
            $penjualan->saldo           = $gaab->saldo;
            $penjualan->deskripsi       = $gaab->deskripsi;
            $penjualan->status          = $gaab->status;
            $penjualan->debit           = $gaab->debit; 
            $penjualan->kredit          = $gaab->kredit;

            if ($gaab->parent_account != NULL) {
                $get_data_account = AccountBank::findOrFail($gaab->parent_account);
                if ($get_data_account) {
                    $get_account_bank_by = AccountBank::query()->where('creat_by_company', $idCompany)->where('nomor', $get_data_account->nomor)->where('nama', $get_data_account->nama)->get();
                    foreach ($get_account_bank_by as $gabb) {
                        $penjualan->parent_account        = $gabb->id;
                    }
                }
            } else {
                $penjualan->parent_account        = $gaab->parent_account;
            }
            $penjualan->reimburse       = $gaab->reimburse; 
            $penjualan->creat_by_company= $idCompany;
            $saveDetail = $penjualan->save();
        }


        // code to make duplicate metode pembayaran by company id
        $get_all_metode_pembayaran = MetodePembayaran::query()->where('creat_by_company', 1)->get();
        foreach ($get_all_metode_pembayaran as $gamp) {
            $metode = new MetodePembayaran();
            $metode->nama_metode        = $gamp->nama_metode;
            $get_data_bank_method = AccountBank::findOrFail($gamp->account_bank);
            if ($get_data_bank_method) {
                $get_bank_method_by = AccountBank::query()->where('creat_by_company', $idCompany)->where('nomor', $get_data_bank_method->nomor)->where('nama', $get_data_bank_method->nama)->get();
                foreach ($get_bank_method_by as $gbmb) {
                    $metode->account_bank        = $gbmb->id;
                }
            }
            $metode->creat_by_company   = $idCompany;
            $save_metode = $metode->save();
        }


        // code to make duplicate metode pembayaran by company id
        $get_all_rules_jurnal = RulesJurnalInput::query()->where('creat_by_company', 1)->get();
        foreach ($get_all_rules_jurnal as $garj) {
            $rules_j = new RulesJurnalInput();
            $rules_j->rules_jurnal_category         = $garj->rules_jurnal_category;
            $rules_j->rules_jurnal_category_2       = $garj->rules_jurnal_category_2;
            $rules_j->rules_jurnal_name             = $garj->rules_jurnal_name;
            $rules_j->rules_jurnal_keterangan       = $garj->rules_jurnal_keterangan;

            if ($garj->rules_jurnal_akun_debit != NULL) {
                $get_data_rules_debit = AccountBank::findOrFail($garj->rules_jurnal_akun_debit);
                if ($get_data_rules_debit) {
                    $get_bank_rules_debit_by = AccountBank::query()->where('creat_by_company', $idCompany)->where('nomor', $get_data_rules_debit->nomor)->where('nama', $get_data_rules_debit->nama)->get();
                    foreach ($get_bank_rules_debit_by as $gbrdb) {
                        $rules_j->rules_jurnal_akun_debit        = $gbrdb->id;
                    }
                }
            } else {
                $rules_j->rules_jurnal_akun_debit        = $garj->rules_jurnal_akun_debit;
            }

            if ($garj->rules_jurnal_akun_kredit != NULL) {
                $get_data_rules_kredit = AccountBank::findOrFail($garj->rules_jurnal_akun_kredit);
                if ($get_data_rules_kredit) {
                    $get_bank_rules_kredit_by = AccountBank::query()->where('creat_by_company', $idCompany)->where('nomor', $get_data_rules_kredit->nomor)->where('nama', $get_data_rules_kredit->nama)->get();
                    foreach ($get_bank_rules_kredit_by as $gbrkb) {
                        $rules_j->rules_jurnal_akun_kredit        = $gbrkb->id;
                    }
                }
            } else {
                $rules_j->rules_jurnal_akun_kredit        = $garj->rules_jurnal_akun_kredit;
            }


            if ($garj->rules_jurnal_akun_discount != NULL) {
                $get_data_rules_discount = AccountBank::findOrFail($garj->rules_jurnal_akun_discount);
                if ($get_data_rules_discount) {
                    $get_bank_rules_discount_by = AccountBank::query()->where('creat_by_company', $idCompany)->where('nomor', $get_data_rules_discount->nomor)->where('nama', $get_data_rules_discount->nama)->get();
                    foreach ($get_bank_rules_discount_by as $gbrdib) {
                        $rules_j->rules_jurnal_akun_discount        = $gbrdib->id;
                    }
                }
            } else {
                $rules_j->rules_jurnal_akun_discount        = $garj->rules_jurnal_akun_discount;
            }



            if ($garj->rules_jurnal_akun_ppn != NULL) {
                $get_data_rules_pajak = AccountBank::findOrFail($garj->rules_jurnal_akun_ppn);
                if ($get_data_rules_pajak) {
                    $get_bank_rules_pajak_by = AccountBank::query()->where('creat_by_company', $idCompany)->where('nomor', $get_data_rules_pajak->nomor)->where('nama', $get_data_rules_pajak->nama)->get();
                    foreach ($get_bank_rules_pajak_by as $gbrpb) {
                        $rules_j->rules_jurnal_akun_ppn        = $gbrpb->id;
                    }
                }
            } else {
                $rules_j->rules_jurnal_akun_ppn        = $garj->rules_jurnal_akun_ppn;
            }
            
            $rules_j->creat_by_company   = $idCompany;
            $save_rules = $rules_j->save();
        }


        if ($save_rules) {
            return redirect()->route('company.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return redirect()->route('company.index')->with(['error' => 'Data Gagal Diupload']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Company::findOrFail($id);
        $pegawai = Pegawai::query()->with(['company'])->where('company_id', Auth::user()->pegawai->company->id)->get();

        return view('pages.company.edit', [
            'data'      => $data,
            'pegawai'   => $pegawai
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_company'               => 'required',
            'nama_company'                  => 'required',
            'email_company'               => 'required',
            'npwp_company'                  => 'required',
            'telpon_company'               => 'required',
            'alamat_company'                  => 'required',
        ]);
        $data = $request->all();

        if (!empty($request->logo_company)) {
            Storage::disk('local')->delete('public/'. $request->logo_company_old);

            $data['logo_company'] = $request->file('logo_company')->store('assets/dokumen/company', 'public');
            
            $item = Company::findOrFail($id);
    
            $msg = $item->update($data);
            
            if ($msg) {
                return redirect()->route('company.index')->with(['success' => 'Data Berhasil Diupdate']);
            }else {
                return redirect()->route('company.index')->with(['error' => 'Data Gagal Diupdate']);
            }
        } else {
            $item = Company::findOrFail($id);
    
            $msg = $item->update($data);
            
            if ($msg) {
                return redirect()->route('company.index')->with(['success' => 'Data Berhasil Diupdate']);
            }else {
                return redirect()->route('company.index')->with(['error' => 'Data Gagal Diupdate']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            return redirect()->route('company.index')->with(['error' => 'Company Ini Tidak Dapat Dihapus']);
        }else{
            RulesJurnalInput::query()->where('creat_by_company', $id)->delete();
            MetodePembayaran::query()->where('creat_by_company', $id)->delete();
            SyaratPembayaran::query()->where('creat_by_company', $id)->delete();
            CategoryAccount::query()->where('creat_by_company', $id)->delete();
            Pajak::query()->where('creat_by_company', $id)->delete();
            AccountBank::query()->where('creat_by_company', $id)->delete();

            $data = Company::findOrFail($id);
    
            $file = $data->logo_company;
    
            Storage::disk('local')->delete('public/'.$file);
    
            $msg = $data->delete();
    
            if ($msg) {
                return redirect()->route('company.index')->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('company.index')->with(['error' => 'Data Gagal Dihapus']);
            }
        }
    }
}
