<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountBank;
use App\Models\Finance\Customer;
use App\Models\Finance\DetailPenjualan;
use App\Models\Finance\jurnal_penyesuaian;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\LogTransaksi;
use App\Models\Finance\MetodePembayaran;
use App\Models\Finance\Pajak;
use App\Models\Finance\Penjualan;
use App\Models\Finance\Product;
use App\Models\Finance\SyaratPembayaran;
use App\Models\Finance\TagihanPenjualan;
use App\Models\Finance\RulesJurnalInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:penjualan-list|penjualan-create|penjualan-edit|penjualan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:penjualan-create', ['only' => ['create','store']]);
         $this->middleware('permission:penjualan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:penjualan-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $month = date("Y-m");
        $day = date("m-d");
        $seluruh_penjualan = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->sum('total');
        $penjualan_bulan_ini = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('tanggal_transaksi', 'like', '%'. $month .'%' )->sum('total');
        $penjualan_hari_ini = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('tanggal_transaksi', 'like', '%'. $day .'%' )->sum('total');


        // dd($penjualan_hari_ini);
        if (request()->ajax()) {
            // $query = Kebijakanhr::with(['pegawai'])->get();
            $query = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['customer', 'metode_pembayaran', 'syarat_pembayaran', 'detail_penjualan'])->where('type_penjualan', 'Barang')->orderBy('id', 'DESC')->get();
            // dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <div class="btn-group dropleft">

                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                            type="button" id="action' .  $item->id . '"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                Aksi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px 0px 10px 10px; margin:10px;">
                            <a class="dropdown-item" href="' . route('penjualan.show', $item->id) . '">
                                Detail
                            </a>
                            <a class="dropdown-item" href="' . url('fnc/lacak_pembayaran_penjualan', $item->id) . '">
                                Riwayat Pembayaran
                            </a>
                            <form action="' . route('penjualan.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages_finance.penjualan.index', [
            'seluruh_penjualan'     => $seluruh_penjualan,
            'penjualan_bulan_ini'   => $penjualan_bulan_ini,
            'penjualan_hari_ini'    => $penjualan_hari_ini
        ]);
    }


    public function index_jasa(){
        if (request()->ajax()) {
            // $query = Kebijakanhr::with(['pegawai'])->get();
            $query = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['customer', 'metode_pembayaran', 'syarat_pembayaran', 'detail_penjualan'])->where('type_penjualan', 'Jasa')->orderBy('id', 'DESC')->get();
            // dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <div class="btn-group dropleft">

                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                            type="button" id="action' .  $item->id . '"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                Aksi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px 0px 10px 10px; margin:10px;">
                            <a class="dropdown-item" href="' . route('penjualan.show', $item->id) . '">
                                Detail
                            </a>
                            <a class="dropdown-item" href="' . url('fnc/lacak_pembayaran_penjualan', $item->id) . '">
                                Riwayat Pembayaran
                            </a>
                            <form action="' . route('penjualan.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $account_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $customers = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pajak = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $metodepembayaran = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $syaratpembayaran = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $penjualan = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();

        $akun_tujuan = AccountBank::query()->with('category_account')->where('creat_by_company', Auth::user()->pegawai->company->id)->whereHas('category_account', function($category_account){$category_account->where('nomor_category_account', '1-10301');})->get();


        return view('pages_finance.penjualan.create', [
            'customers'         => $customers,
            'pajak'             => $pajak,
            'metodepembayaran'  => $metodepembayaran,
            'syaratpembayaran'  => $syaratpembayaran,
            'penjualan'         => $penjualan,
            'akun_tujuans'       => $akun_tujuan,
            'account_bank'      => $account_bank
        ]);
    }

    public function showTagihan(){
        $penjualan = Penjualan::query()->with(['customer'])->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        // dd($penjualan);
        return view('pages_finance.penjualan.showTagihan', [
            'penjualan' => $penjualan
        ]);
    }

    public function get_customers(){
        $customers = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        return response()->json($customers);
    }

    public function get_customers_id($id){
        $data = Customer::where('id', $id)->get();
        return response()->json($data);
    }

    public function get_products_id($id){
        $data = Product::where('id', $id)->get();
        return response()->json($data);
    }


    public function get_product(){
        $products = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 1)->get();
        return response()->json($products);
    }

    public function get_metode(){
        $products = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        return response()->json($products);
    }

    public function get_syarat(){
        $products = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        return response()->json($products);
    }

    public function get_pajaks(){
        $data = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        return response()->json($data);
    }

    public function get_pajak_id($id){
        $data = Pajak::where('id', $id)->get();
        return response()->json($data);
    }

    public function get_account_bank(){
        $data = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 3)->get();
        return response()->json($data);
    }


    public function get_penjualan_id($id){
        $data = Penjualan::where('id', $id)->with(['customer', 'account_bank', 'metode_pembayaran', 'syarat_pembayaran', 'detail_penjualan'])->get();
        return response()->json($data);
    }

    public function bayar_cicilan(Request $request){

        $request->validate([
            'penjualan_id' => 'required',
            'tanggal_bayar' => 'required',
            'besar_tagihan' => 'required',
            'jenis_pembayaran' => 'required',
            'keterangan'        => 'required'
        ]);

        $msg = TagihanPenjualan::create([
            'penjualan_id'      => $request->penjualan_id,
            'tanggal_bayar'     => $request->tanggal_bayar,
            'nominal_pembayaran'    => $request->besar_tagihan,
            'jenis_pembayaran'      => $request->jenis_pembayaran,
            'keterangan'            => $request->keterangan,
            'auth_create'           => Auth::user()->id,
            'creat_by_company'      => Auth::user()->pegawai->company->id
        ]);

        $idPenjualan = $request->penjualan_id;

        if ($request->jenis_pembayaran == "DP") {
            $besar_tagihan_display = $request->besar_tagihan;
            $sisa_tagihan = $request->sisa_tagihan;
            $potongan = $sisa_tagihan - $besar_tagihan_display;
            Penjualan::where('id', $idPenjualan)->update(['sisa_tagihan'=>$potongan]);


            $get_bank = Penjualan::query()->where('id', $idPenjualan)->get();
            foreach ($get_bank as $get) {
                $bank_id = $get->account_bank_id;

                $bank = AccountBank::query()->where('id', $bank_id)->get();
                foreach ($bank as $b) {
                    $saldo_bank = $b->saldo;
                    $add_saldo = $saldo_bank + $besar_tagihan_display;
                    AccountBank::where('id', $bank_id)->update(['saldo' => $add_saldo]);
                }
            }
        }else{
            $besar_tagihan_display = $request->sisa_tagihan_display;
            $sisa_tagihan = $request->sisa_tagihan;
            $potongan = $sisa_tagihan - $besar_tagihan_display;
            Penjualan::where('id', $idPenjualan)->update(['sisa_tagihan'=>$potongan]);


            $get_bank = Penjualan::query()->where('id', $idPenjualan)->get();
            foreach ($get_bank as $get) {
                $bank_id = $get->account_bank_id;

                $bank = AccountBank::query()->where('id', $bank_id)->get();
                foreach ($bank as $b) {
                    $saldo_bank = $b->saldo;
                    $add_saldo = $saldo_bank + $besar_tagihan_display;
                    AccountBank::where('id', $bank_id)->update(['saldo' => $add_saldo]);
                }
            }
        }



        if ($msg) {
            return redirect()->route('penjualan.index')->with(['success' => 'Pembayaran Berhasil Dilakukan']);
        } else {
            return redirect()->route('penjualan.index')->with(['error' => 'Pembayaran Gagal Dilakukan']);
        }
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
            'no_transaksi'              => 'required',
            'customer_id'               => 'required',
            'tanggal_transaksi'         => 'required',
            'syarat_pembayaran'         => 'required',
            'sub_total'                 => 'required',
            'total_global'              => 'required',
            'sisa_tagihan'              => 'required',
            'tanggal_jatuh_tempo'       => 'required'
        ]);

        $data = $request->all();

        $get_syarat = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
        foreach ($get_syarat as $gs) {
            if ($gs->jangka_waktu > 0) {
                $status = 1;
                $sisa_tagihan = $request->sisa_tagihan;
                $nominal_tagihan = $request->nominal_tagihan;
                $metodepembayaran = NULL;
            } else {
                $status = 2;
                $sisa_tagihan = NULL;
                $nominal_tagihan = NULL;
                $metodepembayaran = $request->metode_pembayaran;
            }

        }

        if ($request->switch_jasa) {
            $type_penjualan = 'Jasa';
        } else {
            $type_penjualan = 'Barang';
        }


        if (!empty($request->lampiran)) {
            $msg = Penjualan::create([
                'transaksi'             => "Sales Order",
                'no_transaksi'          => $request->no_transaksi,
                'customer_id'           => $request->customer_id,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'metode_pembayaran_id'  => $metodepembayaran,
                'syarat_pembayaran_id'  => $request->syarat_pembayaran,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'nominal_tagihan'       => $nominal_tagihan,
                'alamat_penagihan'      => $request->alamat_penagihan,
                'pesan'                 => $request->pesan,
                'lampiran'              => $request->file('lampiran')->store('assets/dokumen/lampiranPenjualan', 'public'),
                'sub_total'             => $request->sub_total,
                'discount_global'       => $request->discount_global_result,
                'total'                 => $request->total_global,
                'sisa_tagihan'          => $sisa_tagihan,
                'status'                => $status,
                'type_penjualan'        => $type_penjualan,
                'auth_create'           => Auth::user()->id,
                'akun_tujuan'           => $request->akun_tujuan,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }else{
            $msg = Penjualan::create([
                'transaksi'             => 'Sales Order',
                'no_transaksi'          => $request->no_transaksi,
                'customer_id'           => $request->customer_id,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'metode_pembayaran_id'  => $metodepembayaran,
                'syarat_pembayaran_id'  => $request->syarat_pembayaran,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'nominal_tagihan'       => $nominal_tagihan,
                'alamat_penagihan'      => $request->alamat_penagihan,
                'pesan'                 => $request->pesan,
                'sub_total'             => $request->sub_total,
                'discount_global'       => $request->discount_global_result,
                'total'                 => $request->total_global,
                'sisa_tagihan'          => $sisa_tagihan,
                'status'                => $status,
                'type_penjualan'        => $type_penjualan,
                'auth_create'           => Auth::user()->id,
                'akun_tujuan'           => $request->akun_tujuan,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }


        $parameter_detail = $request->hitung_row;
        $idpenjualan = DB::getPdo()->lastInsertId();

        if ($msg) {
            $nominal_pajak = 0;
            $persediaan_barang = 0;
            $total_discount = 0;
            for ($i = 0; $i <= $parameter_detail ; $i++) {

                if ($request->switch_jasa) {
                    $penjualan = new DetailPenjualan();
                    $penjualan->penjualan_id    = $idpenjualan;
                    $penjualan->nama_jasa      = $request->nama_jasa[$i];
                    $penjualan->harga_jasa      = $request->harga_jasa[$i];
                    $penjualan->product_id      = null;
                    $penjualan->qty_pembelian   = $request->qty_penjualan_jasa[$i];
                    $penjualan->discount        = $request->discount_per_jasa[$i];
                    $penjualan->besar_discount  = $request->total_discount_jasa[$i];
                    $penjualan->pajak_id        = $request->pajak_per_jasa[$i];
                    $penjualan->potongan_pajak  = $request->potongan_pajak_jasa[$i];
                    $penjualan->total           = $request->total_per_jasa[$i];
                    $penjualan->creat_by            = Auth::user()->id;
                    $penjualan->creat_by_company    = Auth::user()->pegawai->company->id;
                    $saveDetail = $penjualan->save();


                    // penjumlahan discount pajak dan persediaan barang
                    $nominal_pajak += $request->potongan_pajak_jasa[$i];
                    $persediaan_barang += $request->total_per_jasa[$i];
                    $total_discount += $request->total_discount_jasa[$i];

                    // input jurnal
                    if ($saveDetail) {

                        $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
                        foreach ($get_syarat_for_account as $gs) {
                            if ($gs->jangka_waktu > 0) {
                                $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 1)->get();
                                foreach ($get_rules_jurnal_entry as $grje) {
                                    $jurnal_pajak_id = $grje->rules_jurnal_akun_ppn;
                                    $jurnal_discount_id = $grje->rules_jurnal_akun_discount;
                                    $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                    $jurnal_kredit_id = $grje->rules_jurnal_akun_kredit;
                                }
                            }else{
                                $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 2)->get();
                                foreach ($get_rules_jurnal_entry as $grje) {
                                    $jurnal_pajak_id = $grje->rules_jurnal_akun_ppn;
                                    $jurnal_discount_id = $grje->rules_jurnal_akun_discount;
                                    $jurnal_kredit_id = $grje->rules_jurnal_akun_kredit;
                                }
                            }
                        }

                        // entry jurnal account PPN keluaran
                        if ($request->potongan_pajak_jasa[$i] > 0) {
                            // dd($request->discount_per_product);
                            $pajak = new JurnalEntry();
                            $pajak->transaksi_id       = $idpenjualan;
                            $pajak->account_id         = 13;
                            $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                            $pajak->debit              = 0;
                            $pajak->kredit             = $nominal_pajak;
                            $pajak->category           = 1;
                            $pajak->tahapan            = 1;
                            $pajak->keterangan         = NULL;
                            $pajak->creat_by           = Auth::user()->id;
                            $pajak->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $pajak->save();

                            $JE_L_1 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_1
                            ]);

                            $get_account_ppn = AccountBank::query()->where('id', 13)->get();
                            foreach ($get_account_ppn as $appn) {
                                AccountBank::query()->where('id', 13)->update(['saldo'=>$appn->saldo - $nominal_pajak]);
                            }
                        }


                        //  entry jurnal account Diskon penjualan
                        if ($request->discount_per_jasa[$i] > 0) {
                            $discount = new JurnalEntry();
                            $discount->transaksi_id       = $idpenjualan;
                            $discount->account_id         = 16;
                            $discount->tanggal_transaksi  = $request->tanggal_transaksi;
                            $discount->debit              = $total_discount;
                            $discount->kredit             = 0;
                            $discount->category           = 1;
                            $discount->tahapan            = 1;
                            $discount->keterangan         = NULL;
                            $discount->creat_by           = Auth::user()->id;
                            $discount->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $discount->save();

                            $JE_L_2 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_2
                            ]);

                            $get_account_discount = AccountBank::query()->where('id', 16)->get();
                            foreach ($get_account_discount as $adiscount) {
                                AccountBank::query()->where('id', 16)->update(['saldo'=>$adiscount->saldo + $total_discount]);
                            }
                        }

                        // entry jurnal account persediaan barang
                        $persedian_barang = new JurnalEntry();
                        $persedian_barang->transaksi_id       = $idpenjualan;
                        $persedian_barang->account_id         = 68;
                        $persedian_barang->tanggal_transaksi  = $request->tanggal_transaksi;
                        $persedian_barang->debit              = 0;
                        $persedian_barang->kredit             = $persediaan_barang + $total_discount - $nominal_pajak;
                        $persedian_barang->category           = 1;
                        $persedian_barang->tahapan            = 1;
                        $persedian_barang->keterangan         = NULL;
                        $persedian_barang->creat_by           = Auth::user()->id;
                        $persedian_barang->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveJurnal = $persedian_barang->save();

                        $JE_L_3 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_3
                        ]);

                        $get_account_persediaan = AccountBank::query()->where('id', 68)->get();
                        foreach ($get_account_persediaan as $ap) {
                            AccountBank::query()->where('id', 68)->update(['saldo'=>$ap->saldo - (($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak)]);
                        }

                        $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
                        foreach ($get_syarat_for_account as $gs) {
                            if ($gs->jangka_waktu > 0) {
                                $get_id_bank = AccountBank::query()->where('id', 9)->get();
                                foreach ($get_id_bank as $b) {
                                    $bank_id_final = $b->id;
                                    AccountBank::query()->where('id', 9)->update(['saldo'=>$b->saldo + $request->total_global]);
                                }

                                $akun_bank = new JurnalEntry();
                                $akun_bank->transaksi_id       = $idpenjualan;
                                $akun_bank->account_id         = 9;
                                $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                $akun_bank->debit              = $request->total_global;
                                $akun_bank->kredit             = 0;
                                $akun_bank->category           = 1;
                                $akun_bank->tahapan            = 1;
                                $akun_bank->keterangan         = NULL;
                                $akun_bank->creat_by           = Auth::user()->id;
                                $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $akun_bank->save();

                                $JE_L_4 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_4
                                ]);
                            }else{
                                $get_id_bank = AccountBank::query()->where('id', $request->akun_tujuan)->get();
                                foreach ($get_id_bank as $b) {
                                    AccountBank::query()->where('id', $request->akun_tujuan)->update(['saldo'=>$b->saldo + $request->total_global]);
                                }



                                $akun_bank = new JurnalEntry();
                                $akun_bank->transaksi_id       = $idpenjualan;
                                $akun_bank->account_id         = $request->akun_tujuan;
                                $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                $akun_bank->debit              = $request->total_global;
                                $akun_bank->kredit             = 0;
                                $akun_bank->category           = 1;
                                $akun_bank->tahapan            = 1;
                                $akun_bank->keterangan         = NULL;
                                $akun_bank->creat_by           = Auth::user()->id;
                                $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $akun_bank->save();

                                $JE_L_5 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_5
                                ]);



                                $data_tag = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
                                if ($data_tag == 0) {
                                    $kode = '10001';
                                }else{
                                    $max_kode = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_pembayaran');
                                    $kode = $max_kode+1;
                                }

                                $bayar_penjualan = new TagihanPenjualan();
                                $bayar_penjualan->penjualan_id              = $idpenjualan;
                                $bayar_penjualan->tanggal_bayar             = $request->tanggal_transaksi;
                                $bayar_penjualan->account_pembayar          = $request->akun_tujuan;
                                $bayar_penjualan->nominal_pembayaran        = $request->total_global;
                                $bayar_penjualan->transaksi                 = 'Bank Withdrawal';
                                $bayar_penjualan->no_pembayaran             = $kode;
                                $bayar_penjualan->keterangan                = 'Pembayaran '.$request->pesan;
                                $bayar_penjualan->auth_create               = Auth::user()->id;
                                $bayar_penjualan->creat_by_company          = Auth::user()->pegawai->company->id;
                                $savePembayaran = $bayar_penjualan->save();

                                $idTagihanPenjualan = DB::getPdo()->lastInsertId();


                                if ($savePembayaran) {

                                    $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 3)->get();
                                    foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                                        $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
                                    }

                                    $jurnal_entri = new JurnalEntry();
                                    $jurnal_entri->transaksi_id       = $idTagihanPenjualan;
                                    $jurnal_entri->account_id         = $jurnal_kredit_id_bar;
                                    $jurnal_entri->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $jurnal_entri->debit              = 0;
                                    $jurnal_entri->kredit             = $request->total_global;
                                    $jurnal_entri->category           = 1;
                                    $jurnal_entri->tahapan            = 2;
                                    $jurnal_entri->keterangan         = NULL;
                                    $jurnal_entri->creat_by           = Auth::user()->id;
                                    $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $jurnal_entri->save();

                                    $JE_L_6 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_6
                                    ]);

                                    $get_account_hutang = AccountBank::query()->where('id', $jurnal_kredit_id_bar)->get();
                                    foreach ($get_account_hutang as $ahut) {
                                        AccountBank::query()->where('id', $jurnal_kredit_id_bar)->update(['saldo'=>$ahut->saldo - $request->nominal_pembayaran]);
                                    }

                                    $jurnal_entri2 = new JurnalEntry();
                                    $jurnal_entri2->transaksi_id       = $idTagihanPenjualan;
                                    $jurnal_entri2->account_id         = $request->akun_tujuan;
                                    $jurnal_entri2->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $jurnal_entri2->debit              = $request->total_global;
                                    $jurnal_entri2->kredit             = 0;
                                    $jurnal_entri2->category           = 1;
                                    $jurnal_entri2->tahapan            = 2;
                                    $jurnal_entri2->keterangan         = NULL;
                                    $jurnal_entri2->creat_by           = Auth::user()->id;
                                    $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $jurnal_entri2->save();

                                    $JE_L_7 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_7
                                    ]);

                                    $get_account_kas = AccountBank::query()->where('id', $request->akun_tujuan)->get();
                                    foreach ($get_account_kas as $akas) {
                                        AccountBank::query()->where('id', $request->akun_tujuan)->update(['saldo'=>$akas->saldo + $request->nominal_pembayaran]);
                                    }
                                }



                            }
                        }
                    }

                }else{
                    $stock_barang_awal = Product::findOrFail($request->product_selected[$i]);
                    $log_transaksi = new LogTransaksi();
                    $log_transaksi->transaksi_id        = $idpenjualan;
                    $log_transaksi->transaksi_key       = 1;
                    $log_transaksi->account_bank_id     = null;
                    $log_transaksi->saldo_awal          = null;
                    $log_transaksi->saldo_akhir         = null;
                    $log_transaksi->product_id          = $request->product_selected[$i];
                    $log_transaksi->stock_awal          = $stock_barang_awal->qty;
                    $log_transaksi->stock_akhir         = $stock_barang_awal->qty - $request->qty_penjualan[$i];
                    $log_transaksi->creat_by            = Auth::user()->id;
                    $log_transaksi->creat_by_company    = Auth::user()->pegawai->company->id;
                    $saveLog = $log_transaksi->save();

                    $update_stock = Product::query()->where('id', $request->product_selected[$i])->update(['qty'=>$stock_barang_awal->qty - $request->qty_penjualan[$i]]);

                    $penjualan = new DetailPenjualan();
                    $penjualan->penjualan_id    = $idpenjualan;
                    $penjualan->product_id      = $request->product_selected[$i];
                    $penjualan->qty_pembelian   = $request->qty_penjualan[$i];
                    $penjualan->discount        = $request->discount_per_product[$i];
                    $penjualan->besar_discount  = $request->total_discount[$i];
                    $penjualan->pajak_id        = $request->pajak_per_product[$i];
                    $penjualan->potongan_pajak  = $request->potongan_pajak[$i];
                    $penjualan->total           = $request->total_per_product[$i];
                    $penjualan->creat_by            = Auth::user()->id;
                    $penjualan->creat_by_company    = Auth::user()->pegawai->company->id;
                    $saveDetail = $penjualan->save();


                    // penjumlahan discount pajak dan persediaan barang
                    $nominal_pajak += $request->potongan_pajak[$i];
                    $persediaan_barang += $request->total_per_product[$i];
                    $total_discount += $request->total_discount[$i];

                    // input jurnal
                    if ($saveDetail) {

                        $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
                        foreach ($get_syarat_for_account as $gs) {
                            if ($gs->jangka_waktu > 0) {
                                $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 4)->get();
                                foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                                    $jurnal_pajak_id_bar = $grjeb->rules_jurnal_akun_ppn;
                                    $jurnal_discount_id_bar = $grjeb->rules_jurnal_akun_discount;
                                    $jurnal_debit_id_bar = $grjeb->rules_jurnal_akun_debit;
                                    $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
                                }
                            }else{
                                $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 5)->get();
                                foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                                    $jurnal_pajak_id_bar = $grjeb->rules_jurnal_akun_ppn;
                                    $jurnal_discount_id_bar = $grjeb->rules_jurnal_akun_discount;
                                    $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
                                }
                            }
                        }

                        // entry jurnal account PPN keluaran
                        if ($request->potongan_pajak[$i] > 0) {
                            // dd($request->discount_per_product);
                            $pajak = new JurnalEntry();
                            $pajak->transaksi_id       = $idpenjualan;
                            $pajak->account_id         = 13;
                            $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                            $pajak->debit              = 0;
                            $pajak->kredit             = $nominal_pajak;
                            $pajak->category           = 1;
                            $pajak->tahapan            = 1;
                            $pajak->keterangan         = NULL;
                            $pajak->creat_by           = Auth::user()->id;
                            $pajak->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $pajak->save();

                            $JE_L_8 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_8
                            ]);

                            $get_account_ppn = AccountBank::query()->where('id', 13)->get();
                            foreach ($get_account_ppn as $appn) {
                                AccountBank::query()->where('id', 13)->update(['saldo'=>$appn->saldo - $nominal_pajak]);
                            }
                        }


                        //  entry jurnal account Diskon penjualan
                        if ($request->discount_per_product[$i] > 0) {
                            $discount = new JurnalEntry();
                            $discount->transaksi_id       = $idpenjualan;
                            $discount->account_id         = 16;
                            $discount->tanggal_transaksi  = $request->tanggal_transaksi;
                            $discount->debit              = $total_discount;
                            $discount->kredit             = 0;
                            $discount->category           = 1;
                            $discount->tahapan            = 1;
                            $discount->keterangan         = NULL;
                            $discount->creat_by           = Auth::user()->id;
                            $discount->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $discount->save();

                            $JE_L_9 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_9
                            ]);

                            $get_account_discount = AccountBank::query()->where('id', 16)->get();
                            foreach ($get_account_discount as $adiscount) {
                                AccountBank::query()->where('id', 16)->update(['saldo'=>$adiscount->saldo + $total_discount]);
                            }
                        }

                        // entry jurnal account persediaan barang
                        $persedian_barang = new JurnalEntry();
                        $persedian_barang->transaksi_id       = $idpenjualan;
                        $persedian_barang->account_id         = 64;
                        $persedian_barang->tanggal_transaksi  = $request->tanggal_transaksi;
                        $persedian_barang->debit              = 0;
                        $persedian_barang->kredit             = ($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak;
                        $persedian_barang->category           = 1;
                        $persedian_barang->tahapan            = 1;
                        $persedian_barang->keterangan         = NULL;
                        $persedian_barang->creat_by           = Auth::user()->id;
                        $persedian_barang->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveJurnal = $persedian_barang->save();

                        $JE_L_10 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_10
                        ]);

                        $get_account_persediaan = AccountBank::query()->where('id', 64)->get();
                        foreach ($get_account_persediaan as $ap) {
                            AccountBank::query()->where('id', 64)->update(['saldo'=>$ap->saldo - (($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak)]);
                        }

                        $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
                        foreach ($get_syarat_for_account as $gs) {
                            if ($gs->jangka_waktu > 0) {
                                $get_id_bank = AccountBank::query()->where('id', 9)->get();
                                foreach ($get_id_bank as $b) {
                                    $bank_id_final = $b->id;
                                    AccountBank::query()->where('id', 9)->update(['saldo'=>$b->saldo + $request->total_global]);
                                }

                                $akun_bank = new JurnalEntry();
                                $akun_bank->transaksi_id       = $idpenjualan;
                                $akun_bank->account_id         = 9;
                                $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                $akun_bank->debit              = $request->total_global;
                                $akun_bank->kredit             = 0;
                                $akun_bank->category           = 1;
                                $akun_bank->tahapan            = 1;
                                $akun_bank->keterangan         = NULL;
                                $akun_bank->creat_by           = Auth::user()->id;
                                $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $akun_bank->save();

                                $JE_L_11 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_11
                                ]);
                            }else{

                                $get_id_bank = AccountBank::query()->where('id', $request->akun_tujuan)->get();
                                foreach ($get_id_bank as $b) {
                                    AccountBank::query()->where('id', $request->akun_tujuan)->update(['saldo'=>$b->saldo + $request->total_global]);
                                }

                                $akun_bank = new JurnalEntry();
                                $akun_bank->transaksi_id       = $idpenjualan;
                                $akun_bank->account_id         = $request->akun_tujuan;
                                $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                $akun_bank->debit              = $request->total_global;
                                $akun_bank->kredit             = 0;
                                $akun_bank->category           = 1;
                                $akun_bank->tahapan            = 1;
                                $akun_bank->keterangan         = NULL;
                                $akun_bank->creat_by           = Auth::user()->id;
                                $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $akun_bank->save();

                                $JE_L_12 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_12
                                ]);



                                $data_tag = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
                                if ($data_tag == 0) {
                                    $kode = '10001';
                                }else{
                                    $max_kode = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_pembayaran');
                                    $kode = $max_kode+1;
                                }

                                $bayar_penjualan = new TagihanPenjualan();
                                $bayar_penjualan->penjualan_id              = $idpenjualan;
                                $bayar_penjualan->tanggal_bayar             = $request->tanggal_transaksi;
                                $bayar_penjualan->account_pembayar          = $request->akun_tujuan;
                                $bayar_penjualan->nominal_pembayaran        = $request->total_global;
                                $bayar_penjualan->transaksi                 = 'Bank Withdrawal';
                                $bayar_penjualan->no_pembayaran             = $kode;
                                $bayar_penjualan->keterangan                = 'Pembayaran '.$request->pesan;
                                $bayar_penjualan->auth_create               = Auth::user()->id;
                                $bayar_penjualan->creat_by_company          = Auth::user()->pegawai->company->id;
                                $savePembayaran = $bayar_penjualan->save();

                                $idTagihanPenjualan = DB::getPdo()->lastInsertId();


                                if ($savePembayaran) {

                                    $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 3)->get();
                                    foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                                        $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
                                    }

                                    $jurnal_entri = new JurnalEntry();
                                    $jurnal_entri->transaksi_id       = $idTagihanPenjualan;
                                    $jurnal_entri->account_id         = $jurnal_kredit_id_bar;
                                    $jurnal_entri->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $jurnal_entri->debit              = 0;
                                    $jurnal_entri->kredit             = $request->total_global;
                                    $jurnal_entri->category           = 1;
                                    $jurnal_entri->tahapan            = 2;
                                    $jurnal_entri->keterangan         = NULL;
                                    $jurnal_entri->creat_by           = Auth::user()->id;
                                    $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $jurnal_entri->save();

                                    $JE_L_13 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_13
                                    ]);

                                    $get_account_hutang = AccountBank::query()->where('id', $jurnal_kredit_id_bar)->get();
                                    foreach ($get_account_hutang as $ahut) {
                                        AccountBank::query()->where('id', $jurnal_kredit_id_bar)->update(['saldo'=>$ahut->saldo - $request->nominal_pembayaran]);
                                    }

                                    $jurnal_entri2 = new JurnalEntry();
                                    $jurnal_entri2->transaksi_id       = $idTagihanPenjualan;
                                    $jurnal_entri2->account_id         = $request->akun_tujuan;
                                    $jurnal_entri2->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $jurnal_entri2->debit              = $request->total_global;
                                    $jurnal_entri2->kredit             = 0;
                                    $jurnal_entri2->category           = 1;
                                    $jurnal_entri2->tahapan            = 2;
                                    $jurnal_entri2->keterangan         = NULL;
                                    $jurnal_entri2->creat_by           = Auth::user()->id;
                                    $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $jurnal_entri2->save();

                                    $JE_L_14 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_14
                                    ]);

                                    $get_account_kas = AccountBank::query()->where('id', $request->akun_tujuan)->get();
                                    foreach ($get_account_kas as $akas) {
                                        AccountBank::query()->where('id', $request->akun_tujuan)->update(['saldo'=>$akas->saldo + $request->nominal_pembayaran]);
                                    }
                                }


                            }
                        }
                    }

                }

            }
        }


        if ($saveJurnal) {
            $data = Penjualan::findOrFail($idpenjualan);
            return redirect()->route('penjualan.show', $data)->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('penjualan.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = Penjualan::findOrFail($id);

        $data_detail = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $data->id)->get();


        $pajak = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $data->id)->sum('potongan_pajak');



        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 1)->where('tahapan', 1)->orderBy('id', 'desc')->get();
        $sum_jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 1)->where('tahapan', 1)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 1)->where('tahapan', 1)->sum('kredit');
        return view('pages_finance.penjualan.detail', [
            'data'=> $data,
            'data_detail'=> $data_detail,
            'pajak' => $pajak,
            'jurnal_entry'=> $jurnal_entry,
            'sum_jurnal_debit'=> $sum_jurnal_debit,
            'sum_jurnal_kredit'=> $sum_jurnal_kredit,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $data = Penjualan::findOrFail($id);
        $customers = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $detail_penjualan = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $id)->get();

        $pajak = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $metodepembayaran = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $syaratpembayaran = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        $penjualan = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
        $product = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        $akun_tujuan = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();


        return view('pages_finance.penjualan.edit', [
            'data'              => $data,
            'customers'         => $customers,
            'pajak'             => $pajak,
            'metodepembayaran'  => $metodepembayaran,
            'syaratpembayaran'  => $syaratpembayaran,
            'penjualan'         => $penjualan,
            'product'           => $product,
            'detail_penjualan'  => $detail_penjualan,
            'akun_tujuan'       => $akun_tujuan,
            'account_bank'      => $account_bank
        ]);
    }

    public function lacak_pembayaran($id){
        $data = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $id)->with(['penjualan'])->get();

        return view('pages_finance.penjualan.lacakPembayaran', [
            'data'  => $data,
            'idData'    => $id
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
            'no_transaksi'          => 'required',
            'customer_id'           => 'required',
            'tanggal_transaksi'     => 'required',
            'syarat_pembayaran'     => 'required',
            'tanggal_jatuh_tempo'   => 'required',
            'alamat_penagihan'      => 'required',
            'sub_total'             => 'required',
            'total_global'          => 'required',
        ]);

        $item = Penjualan::findOrFail($id);

        $get_syarat = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
        foreach ($get_syarat as $gs) {
            if ($gs->jangka_waktu > 0) {
                $status = 1;
                $sisa_tagihan = $request->sisa_tagihan;
                $nominal_tagihan = $request->nominal_tagihan;
                $metodepembayaran = NULL;
            } else {
                $status = 2;
                $sisa_tagihan = NULL;
                $nominal_tagihan = NULL;
                $metodepembayaran = $request->metode_pembayaran;
            }

        }

        if ($request->switch_jasa) {
            $type_penjualan = 'Jasa';
        } else {
            $type_penjualan = 'Barang';
        }


        if (!empty($request->lampiran)) {
            Storage::disk('local')->delete('public/'. $request->lampiran_old);
            $updatePenjualan = $item->update([
                'transaksi'             => 'Sales Order',
                'no_transaksi'          => $request->no_transaksi,
                'customer_id'           => $request->customer_id,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'metode_pembayaran_id'  => $metodepembayaran,
                'syarat_pembayaran_id'  => $request->syarat_pembayaran,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'nominal_tagihan'       => $nominal_tagihan,
                'alamat_penagihan'      => $request->alamat_penagihan,
                'pesan'                 => $request->pesan,
                'lampiran'              => $request->file('lampiran')->store('assets/dokumen/lampiranPenjualan', 'public'),
                'sub_total'             => $request->sub_total,
                'discount_global'       => $request->discount_global_result,
                'total'                 => $request->total_global,
                'sisa_tagihan'          => $sisa_tagihan,
                'status'                => $status,
                'type_penjualan'        => $type_penjualan,
                'auth_create'           => Auth::user()->id,
                'akun_tujuan'           => $request->akun_tujuan,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        } else{
            $updatePenjualan = $item->update([
                'transaksi'             => 'Sales Order',
                'no_transaksi'          => $request->no_transaksi,
                'customer_id'           => $request->customer_id,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'metode_pembayaran_id'  => $metodepembayaran,
                'syarat_pembayaran_id'  => $request->syarat_pembayaran,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'nominal_tagihan'       => $nominal_tagihan,
                'alamat_penagihan'      => $request->alamat_penagihan,
                'pesan'                 => $request->pesan,
                'sub_total'             => $request->sub_total,
                'discount_global'       => $request->discount_global_result,
                'total'                 => $request->total_global,
                'sisa_tagihan'          => $sisa_tagihan,
                'status'                => $status,
                'type_penjualan'        => $type_penjualan,
                'auth_create'           => Auth::user()->id,
                'akun_tujuan'           => $request->akun_tujuan,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }

        if ($updatePenjualan) {
            $itemDel = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $id)->delete();

            if ($itemDel) {
                $parameter_detail = $request->hitung_row;

                if ($request->switch_jasa) {
                    $nominal_pajak_jasa = 0;
                    $persediaan_barang = 0;
                    $total_discount_jasa = 0;
                    for ($i=0; $i <= $parameter_detail; $i++) {

                        $penjualan = new DetailPenjualan();
                        $penjualan->penjualan_id    = $id;
                        $penjualan->product_id      = null;
                        $penjualan->nama_jasa       = $request->nama_jasa[$i];
                        $penjualan->harga_jasa      = $request->harga_jasa[$i];
                        $penjualan->qty_pembelian   = $request->qty_penjualan_jasa[$i];
                        $penjualan->discount        = $request->discount_per_jasa[$i];
                        $penjualan->besar_discount  = $request->total_discount_jasa[$i];
                        $penjualan->pajak_id        = $request->pajak_per_jasa[$i];
                        $penjualan->potongan_pajak  = $request->potongan_pajak_jasa[$i];
                        $penjualan->total           = $request->total_per_jasa[$i];
                        $penjualan->creat_by            = Auth::user()->id;
                        $penjualan->creat_by_company    = Auth::user()->pegawai->company->id;
                        $saveDetail = $penjualan->save();

                        // penjumlahan total discount, pajak dan persediaan barang
                        $nominal_pajak_jasa += $request->potongan_pajak_jasa[$i];
                        $persediaan_barang += $request->total_per_jasa[$i];
                        $total_discount_jasa += $request->total_discount_jasa[$i];

                        if ($saveDetail) {

                            // select jurnal debit by id transaksi
                            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->where('kredit', 0)->get();
                            foreach ($jurnal_debit as $j_deb) {
                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                                foreach ($get_account_debit as $ad) {
                                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                                }
                            }
                            // select jurnal kredit by id transaksi
                            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->where('debit', 0)->get();
                            foreach ($jurnal_kredit as $j_kred) {
                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                                foreach ($get_account_kredit as $ad) {
                                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                                }
                            }

                            $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->delete();

                            $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
                            foreach ($get_syarat_for_account as $gs) {
                                if ($gs->jangka_waktu > 0) {
                                    $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 1)->get();
                                    foreach ($get_rules_jurnal_entry as $grje) {
                                        $jurnal_pajak_id = $grje->rules_jurnal_akun_ppn;
                                        $jurnal_discount_id = $grje->rules_jurnal_akun_discount;
                                        $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                        $jurnal_kredit_id = $grje->rules_jurnal_akun_kredit;
                                    }
                                }else{
                                    $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 2)->get();
                                    foreach ($get_rules_jurnal_entry as $grje) {
                                        $jurnal_pajak_id = $grje->rules_jurnal_akun_ppn;
                                        $jurnal_discount_id = $grje->rules_jurnal_akun_discount;
                                        $jurnal_kredit_id = $grje->rules_jurnal_akun_kredit;
                                    }
                                }
                            }
                            $jurnalEnt = JurnalEntry::query()->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->delete();

                            // entry jurnal account PPN keluaran
                            if ($request->potongan_pajak_jasa[$i] > 0) {
                                $pajak = new JurnalEntry();
                                $pajak->transaksi_id       = $id;
                                $pajak->account_id         = 13;
                                $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                                $pajak->debit              = 0;
                                $pajak->kredit             = $nominal_pajak_jasa;
                                $pajak->category           = 1;
                                $pajak->tahapan            = 1;
                                $pajak->keterangan         = NULL;
                                $pajak->creat_by           = Auth::user()->id;
                                $pajak->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $pajak->save();

                                $JE_L_1 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_1
                                ]);

                                $get_account_ppn = AccountBank::query()->where('id', 13)->get();
                                foreach ($get_account_ppn as $appn) {
                                    AccountBank::query()->where('id', 13)->update(['saldo'=>$appn->saldo - $nominal_pajak_jasa]);
                                }
                            }

                            //  entry jurnal account Diskon penjualan
                            if ($request->discount_per_jasa[$i] > 0) {
                                $discount = new JurnalEntry();
                                $discount->transaksi_id       = $id;
                                $discount->account_id         = 16;
                                $discount->tanggal_transaksi  = $request->tanggal_transaksi;
                                $discount->debit              = $total_discount_jasa;
                                $discount->kredit             = 0;
                                $discount->category           = 1;
                                $discount->tahapan            = 1;
                                $discount->keterangan         = NULL;
                                $discount->creat_by           = Auth::user()->id;
                                $discount->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $discount->save();

                                $JE_L_2 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_2
                                ]);

                                $get_account_discount = AccountBank::query()->where('id', 16)->get();
                                foreach ($get_account_discount as $adiscount) {
                                    AccountBank::query()->where('id', 16)->update(['saldo'=>$adiscount->saldo + $total_discount_jasa]);
                                }
                            }

                            // entry jurnal account persediaan barang
                            $persedian_barang = new JurnalEntry();
                            $persedian_barang->transaksi_id       = $id;
                            $persedian_barang->account_id         = 68;
                            $persedian_barang->tanggal_transaksi  = $request->tanggal_transaksi;
                            $persedian_barang->debit              = 0;
                            $persedian_barang->kredit             = $persediaan_barang + $total_discount_jasa - $nominal_pajak_jasa;
                            $persedian_barang->category           = 1;
                            $persedian_barang->tahapan            = 1;
                            $persedian_barang->keterangan         = NULL;
                            $persedian_barang->creat_by           = Auth::user()->id;
                            $persedian_barang->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $persedian_barang->save();

                            $JE_L_3 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_3
                            ]);

                            $get_account_persediaan = AccountBank::query()->where('id', 68)->get();
                            foreach ($get_account_persediaan as $ap) {
                                AccountBank::query()->where('id', 68)->update(['saldo'=>$ap->saldo - (($persediaan_barang + ($request->discount_global_result + $total_discount_jasa))-$nominal_pajak_jasa)]);
                            }

                            $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
                            foreach ($get_syarat_for_account as $gs) {
                                if ($gs->jangka_waktu > 0) {
                                    $get_id_bank = AccountBank::query()->where('id', 9)->get();
                                    foreach ($get_id_bank as $b) {
                                        $bank_id_final = $b->id;
                                        AccountBank::query()->where('id', 9)->update(['saldo'=>$b->saldo + $request->total_global]);
                                    }

                                    $akun_bank = new JurnalEntry();
                                    $akun_bank->transaksi_id       = $id;
                                    $akun_bank->account_id         = 9;
                                    $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $akun_bank->debit              = $request->total_global;
                                    $akun_bank->kredit             = 0;
                                    $akun_bank->category           = 1;
                                    $akun_bank->tahapan            = 1;
                                    $akun_bank->keterangan         = NULL;
                                    $akun_bank->creat_by           = Auth::user()->id;
                                    $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $akun_bank->save();

                                    $JE_L_4 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_4
                                    ]);
                                }else{

                                    $get_id_bank2 = AccountBank::query()->where('id', $request->akun_tujuan2)->get();
                                    foreach ($get_id_bank2 as $b2) {
                                        AccountBank::query()->where('id', $request->akun_tujuan2)->update(['saldo'=>$b2->saldo - $request->total_global2]);
                                    }

                                    $get_id_bank = AccountBank::query()->where('id', $request->akun_tujuan)->get();
                                    foreach ($get_id_bank as $b) {
                                        AccountBank::query()->where('id', $request->akun_tujuan)->update(['saldo'=>$b->saldo + $request->total_global]);
                                    }

                                    // entry jurnal akun bank&kas
                                    $akun_bank = new JurnalEntry();
                                    $akun_bank->transaksi_id       = $id;
                                    $akun_bank->account_id         = $request->akun_tujuan;
                                    $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $akun_bank->debit              = $request->total_global;
                                    $akun_bank->kredit             = 0;
                                    $akun_bank->category           = 1;
                                    $akun_bank->tahapan            = 1;
                                    $akun_bank->keterangan         = NULL;
                                    $akun_bank->creat_by           = Auth::user()->id;
                                    $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $akun_bank->save();

                                    $JE_L_5 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_5
                                    ]);

                                    $get_pembayaran_transaksi = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $id)->get();
                                    foreach ($get_pembayaran_transaksi as $gpt) {
                                        // select jurnal debit by id transaksi pkembayaran
                                        $jurnal_debit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 1)->where('tahapan', 2)->where('kredit', 0)->get();
                                        foreach ($jurnal_debit_bay as $j_deb_bay) {
                                            jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb_bay->id)->delete();
                                            $get_account_debit = AccountBank::query()->where('id', $j_deb_bay->account_id)->get();
                                            foreach ($get_account_debit as $ad_bay) {
                                                AccountBank::query()->where('id', $j_deb_bay->account_id)->update(['saldo'=>$ad_bay->saldo - $j_deb_bay->debit]);
                                            }
                                        }
                                        // select jurnal kredit by id transaksi pembayaran
                                        $jurnal_kredit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 1)->where('tahapan', 2)->where('debit', 0)->get();
                                        foreach ($jurnal_kredit_bay as $j_kred_bay) {
                                            jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred_bay->id)->delete();
                                            $get_account_kredit_bay = AccountBank::query()->where('id', $j_kred_bay->account_id)->get();
                                            foreach ($get_account_kredit_bay as $ad) {
                                                AccountBank::query()->where('id', $j_kred_bay->account_id)->update(['saldo'=>$ad->saldo + $j_kred_bay->kredit]);
                                            }
                                        }
                                        $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 1)->where('tahapan', 2)->delete();
                                    }


                                    $data_tag = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
                                    if ($data_tag == 0) {
                                        $kode = '10001';
                                    }else{
                                        $max_kode = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_pembayaran');
                                        $kode = $max_kode+1;
                                    }

                                    $bayar_penjualan = new TagihanPenjualan();
                                    $bayar_penjualan->penjualan_id              = $id;
                                    $bayar_penjualan->tanggal_bayar             = $request->tanggal_transaksi;
                                    $bayar_penjualan->account_pembayar          = $request->akun_tujuan;
                                    $bayar_penjualan->nominal_pembayaran        = $request->total_global;
                                    $bayar_penjualan->transaksi                 = 'Bank Withdrawal';
                                    $bayar_penjualan->no_pembayaran             = $kode;
                                    $bayar_penjualan->keterangan                = 'Pembayaran '.$request->pesan;
                                    $bayar_penjualan->auth_create               = Auth::user()->id;
                                    $bayar_penjualan->creat_by_company          = Auth::user()->pegawai->company->id;
                                    $savePembayaran = $bayar_penjualan->save();

                                    $idTagihanPenjualan = DB::getPdo()->lastInsertId();


                                    if ($savePembayaran) {

                                        $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 3)->get();
                                        foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                                            $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
                                        }

                                        $jurnal_entri = new JurnalEntry();
                                        $jurnal_entri->transaksi_id       = $idTagihanPenjualan;
                                        $jurnal_entri->account_id         = $jurnal_kredit_id_bar;
                                        $jurnal_entri->tanggal_transaksi  = $request->tanggal_transaksi;
                                        $jurnal_entri->debit              = 0;
                                        $jurnal_entri->kredit             = $request->total_global;
                                        $jurnal_entri->category           = 1;
                                        $jurnal_entri->tahapan            = 2;
                                        $jurnal_entri->keterangan         = NULL;
                                        $jurnal_entri->creat_by           = Auth::user()->id;
                                        $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
                                        $saveJurnal = $jurnal_entri->save();

                                        $JE_L_6 = DB::getPdo()->lastInsertId();

                                        jurnal_penyesuaian::create([
                                            'jurnal_entry_id' => $JE_L_6
                                        ]);

                                        $get_account_hutang = AccountBank::query()->where('id', $jurnal_kredit_id_bar)->get();
                                        foreach ($get_account_hutang as $ahut) {
                                            AccountBank::query()->where('id', $jurnal_kredit_id_bar)->update(['saldo'=>$ahut->saldo - $request->nominal_pembayaran]);
                                        }

                                        $jurnal_entri2 = new JurnalEntry();
                                        $jurnal_entri2->transaksi_id       = $idTagihanPenjualan;
                                        $jurnal_entri2->account_id         = $request->akun_tujuan;
                                        $jurnal_entri2->tanggal_transaksi  = $request->tanggal_transaksi;
                                        $jurnal_entri2->debit              = $request->total_global;
                                        $jurnal_entri2->kredit             = 0;
                                        $jurnal_entri2->category           = 1;
                                        $jurnal_entri2->tahapan            = 2;
                                        $jurnal_entri2->keterangan         = NULL;
                                        $jurnal_entri2->creat_by           = Auth::user()->id;
                                        $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
                                        $saveJurnal = $jurnal_entri2->save();

                                        $JE_L_7 = DB::getPdo()->lastInsertId();

                                        jurnal_penyesuaian::create([
                                            'jurnal_entry_id' => $JE_L_7
                                        ]);

                                        $get_account_kas = AccountBank::query()->where('id', $request->akun_tujuan)->get();
                                        foreach ($get_account_kas as $akas) {
                                            AccountBank::query()->where('id', $request->akun_tujuan)->update(['saldo'=>$akas->saldo + $request->nominal_pembayaran]);
                                        }
                                    }


                                }
                            }
                        }
                    }
                } else {
                    $nominal_pajak = 0;
                    $persediaan_barang = 0;
                    $total_discount = 0;
                    for ($i=0; $i <= $parameter_detail; $i++) {

                        $dataLog = LogTransaksi::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('transaksi_key', 1)->get();
                        foreach ($dataLog as $us) {
                            $updateStockUlang = Product::where('id', $us->product_id)->update(['qty'=>$us->stock_awal]);
                        }
                        $stock_barang_awal = Product::findOrFail($request->product_selected[$i]);
                        $LogDel = LogTransaksi::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('transaksi_key', 1)->delete();

                        if ($LogDel) {
                            $log_transaksi = new LogTransaksi();
                            $log_transaksi->transaksi_id        = $id;
                            $log_transaksi->transaksi_key       = 1;
                            $log_transaksi->account_bank_id     = null;
                            $log_transaksi->saldo_awal          = null;
                            $log_transaksi->saldo_akhir         = null;
                            $log_transaksi->product_id          = $request->product_selected[$i];
                            $log_transaksi->stock_awal          = $stock_barang_awal->qty;
                            $log_transaksi->stock_akhir         = $stock_barang_awal->qty - $request->qty_penjualan[$i];
                            $log_transaksi->creat_by           = Auth::user()->id;
                            $log_transaksi->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveLog = $log_transaksi->save();
                        }

                        $update_stock = Product::query()->where('id', $request->product_selected[$i])->update(['qty'=>$stock_barang_awal->qty - $request->qty_penjualan[$i]]);


                        $penjualan = new DetailPenjualan();
                        $penjualan->penjualan_id    = $id;
                        $penjualan->product_id      = $request->product_selected[$i];
                        $penjualan->qty_pembelian   = $request->qty_penjualan[$i];
                        $penjualan->discount        = $request->discount_per_product[$i];
                        $penjualan->besar_discount  = $request->total_discount[$i];
                        $penjualan->pajak_id        = $request->pajak_per_product[$i];
                        $penjualan->potongan_pajak  = $request->potongan_pajak[$i];
                        $penjualan->total           = $request->total_per_product[$i];
                        $penjualan->creat_by           = Auth::user()->id;
                        $penjualan->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveDetail = $penjualan->save();

                        // penjumlahan total discount, pajak dan persediaan barang
                        $nominal_pajak += $request->potongan_pajak[$i];
                        $persediaan_barang += $request->total_per_product[$i];
                        $total_discount += $request->total_discount[$i];

                        if ($saveDetail) {

                            // select jurnal debit by id transaksi
                            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->where('kredit', 0)->get();
                            foreach ($jurnal_debit as $j_deb) {
                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                                foreach ($get_account_debit as $ad) {
                                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                                }
                            }
                            // select jurnal kredit by id transaksi
                            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->where('debit', 0)->get();
                            foreach ($jurnal_kredit as $j_kred) {
                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                                $get_account_kredit_bay = AccountBank::query()->where('id', $j_kred->account_id)->get();
                                foreach ($get_account_kredit_bay as $ad) {
                                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                                }
                            }

                            $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->delete();

                            $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
                            foreach ($get_syarat_for_account as $gs) {
                                if ($gs->jangka_waktu > 0) {
                                    $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 4)->get();
                                    foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                                        $jurnal_pajak_id_bar = $grjeb->rules_jurnal_akun_ppn;
                                        $jurnal_discount_id_bar = $grjeb->rules_jurnal_akun_discount;
                                        $jurnal_debit_id_bar = $grjeb->rules_jurnal_akun_debit;
                                        $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
                                    }
                                }else{
                                    $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 5)->get();
                                    foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                                        $jurnal_pajak_id_bar = $grjeb->rules_jurnal_akun_ppn;
                                        $jurnal_discount_id_bar = $grjeb->rules_jurnal_akun_discount;
                                        $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
                                    }
                                }
                            }
                            $jurnalEnt = JurnalEntry::query()->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->delete();

                            // entry jurnal account PPN keluaran
                            if ($request->potongan_pajak[$i] > 0) {
                                $pajak = new JurnalEntry();
                                $pajak->transaksi_id       = $id;
                                $pajak->account_id         = 13;
                                $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                                $pajak->debit              = 0;
                                $pajak->kredit             = $nominal_pajak;
                                $pajak->category           = 1;
                                $pajak->tahapan            = 1;
                                $pajak->keterangan         = NULL;
                                $pajak->creat_by           = Auth::user()->id;
                                $pajak->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $pajak->save();

                                $JE_L_8 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_8
                                ]);

                                $get_account_ppn = AccountBank::query()->where('id', 13)->get();
                                foreach ($get_account_ppn as $appn) {
                                    AccountBank::query()->where('id', 13)->update(['saldo'=>$appn->saldo - $nominal_pajak]);
                                }
                            }

                            //  entry jurnal account Diskon penjualan
                            if ($request->discount_per_product[$i] > 0) {
                                $discount = new JurnalEntry();
                                $discount->transaksi_id       = $id;
                                $discount->account_id         = 16;
                                $discount->tanggal_transaksi  = $request->tanggal_transaksi;
                                $discount->debit              = $total_discount;
                                $discount->kredit             = 0;
                                $discount->category           = 1;
                                $discount->tahapan            = 1;
                                $discount->keterangan         = NULL;
                                $discount->creat_by           = Auth::user()->id;
                                $discount->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $discount->save();

                                $JE_L_9 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_9
                                ]);

                                $get_account_discount = AccountBank::query()->where('id', 16)->get();
                                foreach ($get_account_discount as $adiscount) {
                                    AccountBank::query()->where('id', 16)->update(['saldo'=>$adiscount->saldo + $total_discount]);
                                }
                            }

                            // entry jurnal account persediaan barang
                            $persedian_barang = new JurnalEntry();
                            $persedian_barang->transaksi_id       = $id;
                            $persedian_barang->account_id         = 64;
                            $persedian_barang->tanggal_transaksi  = $request->tanggal_transaksi;
                            $persedian_barang->debit              = 0;
                            $persedian_barang->kredit             = ($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak;
                            $persedian_barang->category           = 1;
                            $persedian_barang->tahapan            = 1;
                            $persedian_barang->keterangan         = NULL;
                            $persedian_barang->creat_by           = Auth::user()->id;
                            $persedian_barang->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $persedian_barang->save();

                            $JE_L_10 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_10
                            ]);

                            $get_account_persediaan = AccountBank::query()->where('id', 64)->get();
                            foreach ($get_account_persediaan as $ap) {
                                AccountBank::query()->where('id', 64)->update(['saldo'=>$ap->saldo - (($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak)]);
                            }

                            $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran)->get();
                            foreach ($get_syarat_for_account as $gs) {
                                if ($gs->jangka_waktu > 0) {
                                    $get_id_bank = AccountBank::query()->where('id', 9)->get();
                                    foreach ($get_id_bank as $b) {
                                        $bank_id_final = $b->id;
                                        AccountBank::query()->where('id', 9)->update(['saldo'=>$b->saldo + $request->total_global]);
                                    }

                                    $akun_bank = new JurnalEntry();
                                    $akun_bank->transaksi_id       = $id;
                                    $akun_bank->account_id         = 9;
                                    $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $akun_bank->debit              = $request->total_global;
                                    $akun_bank->kredit             = 0;
                                    $akun_bank->category           = 1;
                                    $akun_bank->tahapan            = 1;
                                    $akun_bank->keterangan         = NULL;
                                    $akun_bank->creat_by           = Auth::user()->id;
                                    $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $akun_bank->save();

                                    $JE_L_11 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_11
                                    ]);
                                }else{
                                    $get_id_bank2 = AccountBank::query()->where('id', $request->akun_tujuan2)->get();
                                    foreach ($get_id_bank2 as $b2) {
                                        AccountBank::query()->where('id', $request->akun_tujuan2)->update(['saldo'=>$b2->saldo - $request->total_global2]);
                                    }

                                    $get_id_bank = AccountBank::query()->where('id', $request->akun_tujuan)->get();
                                    foreach ($get_id_bank as $b) {
                                        AccountBank::query()->where('id', $request->akun_tujuan)->update(['saldo'=>$b->saldo + $request->total_global]);
                                    }

                                    // entry jurnal akun bank&kas
                                    $akun_bank = new JurnalEntry();
                                    $akun_bank->transaksi_id       = $id;
                                    $akun_bank->account_id         = $request->akun_tujuan;
                                    $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $akun_bank->debit              = $request->total_global;
                                    $akun_bank->kredit             = 0;
                                    $akun_bank->category           = 1;
                                    $akun_bank->tahapan            = 1;
                                    $akun_bank->keterangan         = NULL;
                                    $akun_bank->creat_by           = Auth::user()->id;
                                    $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $akun_bank->save();

                                    $JE_L_12 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_12
                                    ]);


                                    $get_pembayaran_transaksi = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $id)->get();
                                    foreach ($get_pembayaran_transaksi as $gpt) {
                                        // select jurnal debit by id transaksi pkembayaran
                                        $jurnal_debit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 1)->where('tahapan', 2)->where('kredit', 0)->get();
                                        foreach ($jurnal_debit_bay as $j_deb_bay) {
                                            jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb_bay->id)->delete();
                                            $get_account_debit = AccountBank::query()->where('id', $j_deb_bay->account_id)->get();
                                            foreach ($get_account_debit as $ad_bay) {
                                                AccountBank::query()->where('id', $j_deb_bay->account_id)->update(['saldo'=>$ad_bay->saldo - $j_deb_bay->debit]);
                                            }
                                        }
                                        // select jurnal kredit by id transaksi pembayaran
                                        $jurnal_kredit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 1)->where('tahapan', 2)->where('debit', 0)->get();
                                        foreach ($jurnal_kredit_bay as $j_kred_bay) {
                                            jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred_bay->id)->delete();
                                            $get_account_kredit_bay = AccountBank::query()->where('id', $j_kred_bay->account_id)->get();
                                            foreach ($get_account_kredit_bay as $ad) {
                                                AccountBank::query()->where('id', $j_kred_bay->account_id)->update(['saldo'=>$ad->saldo + $j_kred_bay->kredit]);
                                            }
                                        }
                                        $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 1)->where('tahapan', 2)->delete();
                                    }



                                    $data_tag = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
                                    if ($data_tag == 0) {
                                        $kode = '10001';
                                    }else{
                                        $max_kode = TagihanPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_pembayaran');
                                        $kode = $max_kode+1;
                                    }

                                    $bayar_penjualan = new TagihanPenjualan();
                                    $bayar_penjualan->penjualan_id              = $id;
                                    $bayar_penjualan->tanggal_bayar             = $request->tanggal_transaksi;
                                    $bayar_penjualan->account_pembayar          = $request->akun_tujuan;
                                    $bayar_penjualan->nominal_pembayaran        = $request->total_global;
                                    $bayar_penjualan->transaksi                 = 'Bank Withdrawal';
                                    $bayar_penjualan->no_pembayaran             = $kode;
                                    $bayar_penjualan->keterangan                = 'Pembayaran '.$request->pesan;
                                    $bayar_penjualan->auth_create               = Auth::user()->id;
                                    $bayar_penjualan->creat_by_company          = Auth::user()->pegawai->company->id;
                                    $savePembayaran = $bayar_penjualan->save();

                                    $idTagihanPenjualan = DB::getPdo()->lastInsertId();


                                    if ($savePembayaran) {

                                        $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 3)->get();
                                        foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                                            $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
                                        }

                                        $jurnal_entri = new JurnalEntry();
                                        $jurnal_entri->transaksi_id       = $idTagihanPenjualan;
                                        $jurnal_entri->account_id         = $jurnal_kredit_id_bar;
                                        $jurnal_entri->tanggal_transaksi  = $request->tanggal_transaksi;
                                        $jurnal_entri->debit              = 0;
                                        $jurnal_entri->kredit             = $request->total_global;
                                        $jurnal_entri->category           = 1;
                                        $jurnal_entri->tahapan            = 2;
                                        $jurnal_entri->keterangan         = NULL;
                                        $jurnal_entri->creat_by           = Auth::user()->id;
                                        $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
                                        $saveJurnal = $jurnal_entri->save();

                                        $JE_L_13 = DB::getPdo()->lastInsertId();

                                        jurnal_penyesuaian::create([
                                            'jurnal_entry_id' => $JE_L_13
                                        ]);

                                        $get_account_hutang = AccountBank::query()->where('id', $jurnal_kredit_id_bar)->get();
                                        foreach ($get_account_hutang as $ahut) {
                                            AccountBank::query()->where('id', $jurnal_kredit_id_bar)->update(['saldo'=>$ahut->saldo - $request->nominal_pembayaran]);
                                        }

                                        $jurnal_entri2 = new JurnalEntry();
                                        $jurnal_entri2->transaksi_id       = $idTagihanPenjualan;
                                        $jurnal_entri2->account_id         = $request->akun_tujuan;
                                        $jurnal_entri2->tanggal_transaksi  = $request->tanggal_transaksi;
                                        $jurnal_entri2->debit              = $request->total_global;
                                        $jurnal_entri2->kredit             = 0;
                                        $jurnal_entri2->category           = 1;
                                        $jurnal_entri2->tahapan            = 2;
                                        $jurnal_entri2->keterangan         = NULL;
                                        $jurnal_entri2->creat_by           = Auth::user()->id;
                                        $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
                                        $saveJurnal = $jurnal_entri2->save();

                                        $JE_L_14 = DB::getPdo()->lastInsertId();

                                        jurnal_penyesuaian::create([
                                            'jurnal_entry_id' => $JE_L_14
                                        ]);

                                        $get_account_kas = AccountBank::query()->where('id', $request->akun_tujuan)->get();
                                        foreach ($get_account_kas as $akas) {
                                            AccountBank::query()->where('id', $request->akun_tujuan)->update(['saldo'=>$akas->saldo + $request->nominal_pembayaran]);
                                        }
                                    }


                                }
                            }
                        }
                    }
                }


                if ($saveJurnal) {
                    $data = Penjualan::findOrFail($id);
                    return redirect()->route('penjualan.show', $data)->with(['success' => 'Data Berhasil Diupdate']);
                } else {
                    return redirect()->route('penjualan.index')->with(['error' => 'Data Gagal Diupdate']);
                }
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
        $data = Penjualan::findOrFail($id);

        $file = $data->gambar;

        $dataLog = LogTransaksi::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('transaksi_key', 1)->get();
        foreach ($dataLog as $us) {
            $updateStockUlang = Product::where('id', $us->product_id)->update(['qty'=>$us->stock_awal]);
        }
        $LogDel = LogTransaksi::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('transaksi_key', 1)->delete();

        $detailDelete = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $id)->delete();

        if ($detailDelete) {
            // perintah untuk update saldo account pajak PPN
            $get_jurnal_pajak = JurnalEntry::query()->where('transaksi_id', $id)->where('account_id', 13)->where('category', 1)->where('tahapan', 1)->get();
            foreach ($get_jurnal_pajak as $jpajak) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $jpajak->id)->delete();
                $get_account_ppn = AccountBank::query()->where('id', 13)->get();
                foreach ($get_account_ppn as $appn) {
                    AccountBank::query()->where('id', 13)->update(['saldo'=>$appn->saldo + $jpajak->kredit]);
                }
            }

            // select jurnal debit by id transaksi
            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->where('kredit', 0)->get();
            foreach ($jurnal_debit as $j_deb) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                foreach ($get_account_debit as $ad) {
                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                }
            }
            // select jurnal kredit by id transaksi
            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 1)->where('debit', 0)->get();
            foreach ($jurnal_kredit as $j_kred) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                foreach ($get_account_kredit as $ad) {
                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                }
            }

            $jurnalDelete = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->delete();
        }

        if ($file != null) {
            Storage::disk('local')->delete('public/'.$file);

            $msg = $data->delete();

            if ($msg) {
                return redirect()->route('penjualan.index')->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('penjualan.index')->with(['error' => 'Data Gagal Dihapus']);
            }
        }else{
            $msg = $data->delete();

            if ($msg) {
                return redirect()->route('penjualan.index')->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('penjualan.index')->with(['error' => 'Data Gagal Dihapus']);
            }
        }

    }

    // public function delete_pembayaran_penjualan(Request $request){
    //     $idPenjualan = $request->id_penjualan;
    //     $nominal_bayar = $request->nominal_bayar;

    //     $id_pembayaran = $request->id_pembayaran;
    //     $get_bank = Penjualan::query()->where('id', $idPenjualan)->get();
    //         foreach ($get_bank as $get) {
    //             $bank_id = $get->account_bank_id;

    //             $bank = AccountBank::query()->where('id', $bank_id)->get();
    //             foreach ($bank as $b) {
    //                 $saldo_bank = $b->saldo;
    //                 $add_saldo = $saldo_bank - $nominal_bayar;
    //                 AccountBank::where('id', $bank_id)->update(['saldo' => $add_saldo]);
    //             }
    //         }

    //         $msg = TagihanPenjualan::where('id', $id_pembayaran)->delete();

    //         if ($msg) {
    //             return redirect()->url('fnc/lacak_pembayaran', $idPenjualan)->with(['success' => 'Data Berhasil Dihapus']);
    //         }else {
    //             return redirect()->url('fnc/lacak_pembayaran', $idPenjualan)->with(['error' => 'Data Gagal Dihapus']);
    //         }
    // }

    public function showBayar($id){
            $data = Penjualan::findOrFail($id);

            $bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
            return view('pages_finance.penjualan.showTagihan', [
                'data'  => $data,
                'bank'  => $bank
            ]);
    }

    public function kwitansi_penjualan($id){
        // $data = TagihanPenjualan::query()->with(['penjualan', 'penjualan.user_create', 'penjualan.user_create.pegawai', 'penjualan.user_create.pegawai.company'])->where('id', $id)->get();
        $data = TagihanPenjualan::findOrFail($id);

        // dd($data->penjualan->user_create);

        return view('pages_finance.penjualan.kwitansi', [
            'data'=> $data,
        ]);
    }

    public function invoice_penjualan($id){
        $data = Penjualan::findOrFail($id);

        // $data_detail = DetailPenjualan::findOrFail($data->id);
        $data_detail = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['product2'])->where('penjualan_id', $data->id)->get();
        // dd($data_detail);
        $data_detail_count = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $data->id)->count();
        $pajak = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $data->id)->sum('potongan_pajak');

        return view('pages_finance.penjualan.invoice', [
            'data'=> $data,
            'data_detail'=> $data_detail,
            'pajak' => $pajak,
            'data_detail_count'=> $data_detail_count
        ]);
    }

    public function faktur_penjualan($id){
        $data = Penjualan::findOrFail($id);

        // $data_detail = DetailPenjualan::findOrFail($data->id);
        $data_detail = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['product2'])->where('penjualan_id', $data->id)->get();
        // dd($data_detail);
        $data_detail_count = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $data->id)->count();
        $pajak = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $data->id)->sum('potongan_pajak');

        return view('pages_finance.penjualan.faktur', [
            'data'=> $data,
            'data_detail'=> $data_detail,
            'pajak' => $pajak,
            'data_detail_count'=> $data_detail_count
        ]);
    }

    public function show_jurnal_penjualan($id){
        $data = TagihanPenjualan::findOrFail($id);

        $data_detail = TagihanPenjualan::query()->where('id', $id)->get();

        $pajak = DetailPenjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('penjualan_id', $id)->sum('potongan_pajak');


        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 2)->orderBy('id', 'desc')->get();
        // dd($jurnal_entry);
        $sum_jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 2)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 2)->sum('kredit');
        return view('pages_finance.penjualan.show_jurnal', [
            'data'              => $data,
            'data_detail'       => $data_detail,
            'pajak'             => $pajak,
            'jurnal_entry'      => $jurnal_entry,
            'sum_jurnal_debit'  => $sum_jurnal_debit,
            'sum_jurnal_kredit' => $sum_jurnal_kredit,
        ]);
    }

    public function bayar_cicilan_penjualan(Request $request){
        $request->validate([
            'nominal_pembayaran'    => 'required',
            'account_pembayar'      => 'required',
            'tanggal_bayar'         => 'required|date',
            'keterangan'            => 'nullable|string'
        ]);

        $data = TagihanPenjualan::count();
        if ($data == 0) {
            $kode = '10001';
        }else{
            $max_kode = TagihanPenjualan::query()->max('no_pembayaran');
            $kode = $max_kode+1;
        }

        $bayar_penjualan = new TagihanPenjualan();
        $bayar_penjualan->penjualan_id              = $request->id_penjualan;
        $bayar_penjualan->tanggal_bayar             = $request->tanggal_bayar;
        $bayar_penjualan->account_pembayar          = $request->account_pembayar;
        $bayar_penjualan->nominal_pembayaran        = $request->nominal_pembayaran;
        $bayar_penjualan->transaksi                 = 'Bank Withdrawal';
        $bayar_penjualan->no_pembayaran             = $kode;
        $bayar_penjualan->keterangan                = $request->keterangan;
        $bayar_penjualan->auth_create               = Auth::user()->id;
        $bayar_penjualan->creat_by_company          = Auth::user()->pegawai->company->id;
        $savePembayaran = $bayar_penjualan->save();

        // get last id insert
        $idTagihanPenjualan = DB::getPdo()->lastInsertId();

        if ($savePembayaran) {
            $idPenjualan = $request->id_penjualan;
            $potongan = $request->sisa_tagihan2 - $request->nominal_pembayaran;
            if ($potongan > 0) {
                $update_Penjualan = Penjualan::query()->where('id', $idPenjualan)->update(['sisa_tagihan'=>$potongan]);
            }else{
                $update_Penjualan = Penjualan::query()->where('id', $idPenjualan)->update(['sisa_tagihan'=>0 , 'status'=>2]);
            }
        }

        if ($update_Penjualan) {

            $get_rules_jurnal_entry_bar = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 1)->where('rules_jurnal_category_2', 3)->get();
            foreach ($get_rules_jurnal_entry_bar as $grjeb) {
                $jurnal_kredit_id_bar = $grjeb->rules_jurnal_akun_kredit;
            }

            $jurnal_entri = new JurnalEntry();
            $jurnal_entri->transaksi_id       = $idTagihanPenjualan;
            $jurnal_entri->account_id         = 10;
            $jurnal_entri->tanggal_transaksi  = $request->tanggal_bayar;
            $jurnal_entri->debit              = 0;
            $jurnal_entri->kredit             = $request->nominal_pembayaran;
            $jurnal_entri->category           = 1;
            $jurnal_entri->tahapan            = 2;
            $jurnal_entri->keterangan         = NULL;
            $jurnal_entri->creat_by           = Auth::user()->id;
            $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $jurnal_entri->save();

            $JE_L_1 = DB::getPdo()->lastInsertId();

            jurnal_penyesuaian::create([
                'jurnal_entry_id' => $JE_L_1
            ]);

            $get_account_hutang = AccountBank::query()->where('id', 10)->get();
            foreach ($get_account_hutang as $ahut) {
                AccountBank::query()->where('id', 10)->update(['saldo'=>$ahut->saldo - $request->nominal_pembayaran]);
            }

            $jurnal_entri2 = new JurnalEntry();
            $jurnal_entri2->transaksi_id       = $idTagihanPenjualan;
            $jurnal_entri2->account_id         = $request->account_pembayar;
            $jurnal_entri2->tanggal_transaksi  = $request->tanggal_bayar;
            $jurnal_entri2->debit              = $request->nominal_pembayaran;
            $jurnal_entri2->kredit             = 0;
            $jurnal_entri2->category           = 1;
            $jurnal_entri2->tahapan            = 2;
            $jurnal_entri2->keterangan         = NULL;
            $jurnal_entri2->creat_by           = Auth::user()->id;
            $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $jurnal_entri2->save();

            $JE_L_2 = DB::getPdo()->lastInsertId();

            jurnal_penyesuaian::create([
                'jurnal_entry_id' => $JE_L_2
            ]);

            $get_account_kas = AccountBank::query()->where('id', $request->account_pembayar)->get();
            foreach ($get_account_kas as $akas) {
                AccountBank::query()->where('id', $request->account_pembayar)->update(['saldo'=>$akas->saldo + $request->nominal_pembayaran]);
            }
        }

        if ($saveJurnal) {
            $data = TagihanPenjualan::findOrFail($idTagihanPenjualan);
            return redirect()->route('showjurnal_penjualan', $data)->with(['success' => 'Pembayaran Berhasil']);
        } else {
            return redirect()->route('biaya.index')->with(['error' => 'Pembayaran Gagal']);
        }

    }

}

