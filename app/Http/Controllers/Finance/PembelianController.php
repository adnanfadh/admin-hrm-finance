<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountBank;
use App\Models\Finance\DetailPembelian;
use App\Models\Finance\DetailPengajuan;
use App\Models\Finance\jurnal_penyesuaian;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\LogTransaksi;
use App\Models\Finance\MetodePembayaran;
use App\Models\Finance\Pajak;
use App\Models\Finance\Pembelian;
use App\Models\Finance\Product;
use App\Models\Finance\Supplier;
use App\Models\Finance\SyaratPembayaran;
use App\Models\Finance\TagihanPembelian;
use App\Models\Finance\RulesJurnalInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:pembelian-list|pembelian-create|pembelian-edit|pembelian-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pembelian-create', ['only' => ['create','store']]);
         $this->middleware('permission:pembelian-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pembelian-delete', ['only' => ['destroy']]);
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
        $seluruh_pembelian = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->sum('total');
        $pembelian_bulan_ini = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('tanggal_transaksi', 'like', '%'. $month .'%' )->sum('total');
        $pembelian_hari_ini = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('tanggal_transaksi', 'like', '%'. $day .'%' )->sum('total');


        // dd($pembelian_hari_ini);
        if (request()->ajax()) {
            // $query = Kebijakanhr::with(['pegawai'])->get();
            $query = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['supplier', 'metode_pembayaran', 'syarat_pembayaran', 'detail_pembelian'])->where('jenis_pembelian', 'Default Pembelian')->orderBy('id', 'DESC')->get();
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
                            <a class="dropdown-item" href="' . route('pembelian.show', $item->id) . '">
                                Detail
                            </a>
                            <a class="dropdown-item" href="' . url('fnc/lacak_pembayaran_pembelian', $item->id) . '">
                                Riwayat Pembayaran
                            </a>
                            <form action="' . route('pembelian.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>';
                })
                ->addColumn('sisa_tagihan', function ($item) {
                    if ($item->sisa_tagihan == null) {
                        return number_format(0,2,',','.');
                    } else {
                        return number_format($item->sisa_tagihan,2,',','.');
                    }

                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 2) {
                        return '<span class="badge badge-success">Telah Dibayar</span>';
                    } else {
                        return '<span class="badge badge-warning">Belum Dibayar</span>';
                    }
                })
                ->addColumn('total', function ($item) {
                    return number_format($item->total,2,',','.');
                })
                ->rawColumns(['action', 'sisa_tagihan', 'status', 'total'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages_finance.pembelian.index', [
            'seluruh_pembelian' => $seluruh_pembelian,
            'pembelian_bulan_ini'   => $pembelian_bulan_ini,
            'pembelian_hari_ini'    => $pembelian_hari_ini
        ]);
    }



    // index rab table
    public function index_rab()
    {
        if (request()->ajax()) {
            // $query = Kebijakanhr::with(['pegawai'])->get();
            $query = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['supplier', 'metode_pembayaran', 'syarat_pembayaran', 'detail_pembelian'])->where('jenis_pembelian', 'Pembelian RAB')->orderBy('id', 'DESC')->get();
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
                            <a class="dropdown-item" href="' . route('pembelian.show', $item->id) . '">
                                Detail
                            </a>
                            <a class="dropdown-item" href="' . url('fnc/lacak_pembayaran_pembelian', $item->id) . '">
                                Riwayat Pembayaran
                            </a>
                            <form action="' . route('pembelian.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>';
                })
                ->addColumn('sisa_tagihan', function ($item) {
                    if ($item->sisa_tagihan == null) {
                        return number_format(0,2,',','.');
                    } else {
                        return number_format($item->sisa_tagihan,2,',','.');
                    }

                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 2) {
                        return '<span class="badge badge-success">Telah Dibayar</span>';
                    } else {
                        return '<span class="badge badge-warning">Belum Dibayar</span>';
                    }
                })
                ->addColumn('total', function ($item) {
                    return number_format($item->total,2,',','.');
                })
                ->rawColumns(['action', 'sisa_tagihan', 'status', 'total'])
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
        $suppliers = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pajak = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $metodepembayaran = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $syaratpembayaran = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pembelian = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
        // dd($pembelian); 
        $account_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        return view('pages_finance.pembelian.create', [
            'suppliers' => $suppliers,
            'pajak'     => $pajak,
            'metodepembayaran'  => $metodepembayaran,
            'syaratpembayaran'  => $syaratpembayaran,
            'pembelian'         => $pembelian,
            'account_bank'      => $account_bank
        ]);
    }

    public function showTagihanPembelian(){
        $pembelian = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['supplier'])->get();
        // dd($pembelian);
        return view('pages_finance.pembelian.showTagihan', [
            'pembelian' => $pembelian
        ]);
    }

    public function get_suppliers_pembelian(){
        $suppliers = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        return response()->json($suppliers);
    }

    public function get_suppliers_id_pembelian($id){
        $data = Supplier::where('id', $id)->get();
        return response()->json($data);
    }

    public function get_products_id_pembelian($id){
        $data = Product::where('id', $id)->get();
        return response()->json($data);
    }

    public function get_pengajuan_id_pembelian($id){
        $data = DetailPengajuan::where('id', $id)->get();
        return response()->json($data);
    }


    public function get_product_pembelian(){
        $products = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
        // $products = Product::all();
        return response()->json($products);
    }

    public function get_pengajuan_pembelian(){
        $pengajuan = DetailPengajuan::query()->whereHas('pengajuan', function($pengajuan){$pengajuan->where('creat_by_company', Auth::user()->pegawai->company->id);})->get();

        return response()->json($pengajuan);
    }

    public function get_metode_pembelian(){
        $metodepembayaran = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        // $metodepembayaran = Product::all();
        return response()->json($metodepembayaran);
    }

    public function get_syarat_pembelian(){
        $syaratpembayaran = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        // $syaratpembayaran = Product::all();
        return response()->json($syaratpembayaran);
    }

    public function get_syarat_pembayaran_id($id){
        $data = SyaratPembayaran::findOrFail($id);
        return response()->json($data);
    }

    public function get_pajaks_pembelian(){
        $data = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        return response()->json($data);
    }

    public function get_pajak_id_pembelian($id){
        $data = Pajak::where('id', $id)->get();
        return response()->json($data);
    }

    public function get_account_bank_pembelian(){
        $data = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        // $data = AccountBank::query()->where('category', 1)->get();
        return response()->json($data);
    }


    public function get_pembelian_id_pembelian($id){
        $data = Pembelian::where('id', $id)->with(['supplier', 'metode_pembayaran', 'syarat_pembayaran', 'detail_pembelian'])->get();
        return response()->json($data);
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
            'no_transaksi'          => 'required',
            'supplier_id'           => 'required',
            'tanggal_transaksi'     => 'required',
            'syarat_pembayaran_id'  => 'required',
            'tanggal_jatuh_tempo'   => 'required',
            'alamat_penagihan'      => 'required',
            'sub_total'             => 'required',
            'total_global'          => 'required',
            'sisa_tagihan'          => 'required',
        ]);

        $data = $request->all();
        
        if ($request->switch_rab == 1) {
            $jenis_pembelian = 'Pembelian RAB';
        }else{
            $jenis_pembelian = 'Default Pembelian';
        }
        // dd($request->switch_rab);

        $get_syarat = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
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
                $metodepembayaran = $request->metode_pembayaran_id;
            }

        }

        //store ke table pembelian parent
        if (!empty($request->lampiran)) {
            $msg = Pembelian::create([
                'transaksi'             => "Purchase Invoice",
                'no_transaksi'          => $request->no_transaksi,
                'supplier_id'           => $request->supplier_id,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'metode_pembayaran_id'  => $metodepembayaran,
                'syarat_pembayaran_id'  => $request->syarat_pembayaran_id,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'nominal_tagihan'       => $nominal_tagihan,
                'alamat_penagihan'      => $request->alamat_penagihan,
                'pesan'                 => $request->pesan,
                'lampiran'              => $request->file('lampiran')->store('assets/dokumen/lampiranPembelian', 'public'),
                'sub_total'             => $request->sub_total,
                'discount_pembelian'    => $request->discount_global_result,
                'total'                 => $request->total_global,
                'sisa_tagihan'          => $sisa_tagihan,
                'status'                => $status,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id,
                'jenis_pembelian'       => $jenis_pembelian
            ]);
        }else{
            $msg = Pembelian::create([
                'transaksi'             => "Purchase Invoice",
                'no_transaksi'          => $request->no_transaksi,
                'supplier_id'           => $request->supplier_id,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'metode_pembayaran_id'  => $metodepembayaran,
                'syarat_pembayaran_id'  => $request->syarat_pembayaran_id,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'nominal_tagihan'       => $nominal_tagihan,
                'alamat_penagihan'      => $request->alamat_penagihan,
                'pesan'                 => $request->pesan,
                'sub_total'             => $request->sub_total,
                'discount_pembelian'    => $request->discount_global_result,
                'total'                 => $request->total_global,
                'sisa_tagihan'          => $sisa_tagihan,
                'status'                => $status,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id,
                'jenis_pembelian'       => $jenis_pembelian
            ]);
        }

        //mengambil value parameter untuk total perulangan pada baris
        $parameter_detail = $request->hitung_row;

        //mengambil value id terakhir yang di insert ke table parent
        $idpembelian = DB::getPdo()->lastInsertId();


        //
        
        if ($msg) {
            if ($request->switch_rab == 1) {
                // dd($request->switch_rab);
                //$jenis_pembelian = 'Pembelian RAB';
                for ($i = 0; $i <= $parameter_detail ; $i++) {
                    $pembelian = new DetailPembelian();
                    $pembelian->pembelian_id        = $idpembelian;
                    $pembelian->creat_by            = Auth::user()->id;
                    $pembelian->creat_by_company    = Auth::user()->pegawai->company->id;
                    $pembelian->item_pengajuan      = $request->pengajuan_selected[$i];
                    $msg2 = $pembelian->save();
    
                    // input ke jurnal
                    if ($msg2) {
                        // get rules dari table rules untuk kebutuhan input jurnal entry
                        $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
                        foreach ($get_syarat_for_account as $gs) {
                            if ($gs->jangka_waktu > 0) {
                                $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 1)->get();
                                foreach ($get_rules_jurnal_entry as $grje) {
                                    $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                    $jurnal_kredit_id = $grje->rules_jurnal_akun_kredit;
                                }
                            }else{
                                $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 2)->get();
                                foreach ($get_rules_jurnal_entry as $grje) {
                                    $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                }
                            }
                        }

                        //jurnal entry debit
                        $persedian_barang = new JurnalEntry();
                        $persedian_barang->transaksi_id       = $idpembelian;
                        $persedian_barang->account_id         = 6;
                        $persedian_barang->tanggal_transaksi  = $request->tanggal_transaksi;
                        $persedian_barang->debit              = $request->total_budget[$i];
                        $persedian_barang->kredit             = 0;
                        $persedian_barang->category           = 2;
                        $persedian_barang->tahapan            = 1;
                        $persedian_barang->keterangan         = NULL;
                        $persedian_barang->creat_by           = Auth::user()->id;
                        $persedian_barang->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveJurnal = $persedian_barang->save();

                        $JE_L_1 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_1
                        ]);
    
                        $get_account_persediaan = AccountBank::query()->where('id', 6)->get();
                        foreach ($get_account_persediaan as $ap) {
                            AccountBank::query()->where('id', 6)->update(['saldo'=> $request->total_budget[$i]]);
                        }
    
                        $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
                        foreach ($get_syarat_for_account as $gs) {
                            if ($gs->jangka_waktu > 0) {
                                $get_id_bank_hutang = AccountBank::query()->where('id', 10)->get();
                                foreach ($get_id_bank_hutang as $bh) {
                                    $bank_id_final_hutang = $bh->id;
                                    AccountBank::query()->where('id', 10)->update(['saldo'=>$bh->saldo - $request->total_budget[$i]]);
                                }
                                $akun_bank = new JurnalEntry();
                                $akun_bank->transaksi_id       = $idpembelian;
                                $akun_bank->account_id         = $bank_id_final_hutang;
                                $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                $akun_bank->debit              = 0;
                                $akun_bank->kredit             = $request->total_budget[$i];
                                $akun_bank->category           = 2;
                                $akun_bank->tahapan            = 1;
                                $akun_bank->keterangan         = NULL;
                                $akun_bank->creat_by           = Auth::user()->id;
                                $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $akun_bank->save();

                                $JE_L_2 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_2
                                ]);
                            } else {
                                //find payment method and get account bank by payment method
                                $account_bank = MetodePembayaran::findOrFail($request->metode_pembayaran_id);
                                $id_bank = $account_bank->account_bank;
    
                                // get id bank from Account bank table where id equal in result previous method 
                                $get_id_bank = AccountBank::query()->where('id', $id_bank)->get();
                                foreach ($get_id_bank as $b) {
                                    $bank_id_final = $b->id;
                                    AccountBank::query()->where('id', $id_bank)->update(['saldo'=>$b->saldo - $request->total_budget[$i]]);
                                } 

                                
                                $akun_bank = new JurnalEntry();
                                $akun_bank->transaksi_id       = $idpembelian;
                                $akun_bank->account_id         = $bank_id_final;
                                $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                $akun_bank->debit              = 0;
                                $akun_bank->kredit             = $request->total_budget[$i];
                                $akun_bank->category           = 2;
                                $akun_bank->tahapan            = 1;
                                $akun_bank->keterangan         = NULL;
                                $akun_bank->creat_by           = Auth::user()->id;
                                $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $akun_bank->save();

                                $JE_L_3 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_3
                                ]);
    
    
                                // count data tagihan pembelian berdasarkan 
                                $data_tag = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $idpembelian)->count();
                                    if ($data_tag == 0) {
                                        $kode = '10001';
                                    }else{
                                        $max_kode = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $idpembelian)->max('no_pembayaran');
                                        $kode = $max_kode+1;
                                    }
    
    
                                    //input tagihan pembelian ketika pembelian dengan 
                                $bayar_pembelian = new TagihanPembelian();
                                $bayar_pembelian->pembelian_id            = $idpembelian;
                                $bayar_pembelian->tanggal_bayar          = $request->tanggal_transaksi;
                                $bayar_pembelian->account_pembayar      = $bank_id_final;
                                $bayar_pembelian->nominal_pembayaran           = $request->total_global;
                                $bayar_pembelian->transaksi            = 'Bank Withdrawal';
                                $bayar_pembelian->no_pembayaran      = $kode;
                                $bayar_pembelian->keterangan      = $request->pesan;
                                $bayar_pembelian->creat_by           = Auth::user()->id;
                                $bayar_pembelian->creat_by_company   = Auth::user()->pegawai->company->id;
                                $savePembayaran = $bayar_pembelian->save();
    
                                $idTagihanPembelian = DB::getPdo()->lastInsertId();
    
    
                                if ($savePembayaran) {
                                    $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 3)->get();
                                    foreach ($get_rules_jurnal_entry as $grje) {
                                        $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                    }
    
                                    $jurnal_entri = new JurnalEntry();
                                    $jurnal_entri->transaksi_id       = $idTagihanPembelian;
                                    $jurnal_entri->account_id         = $jurnal_debit_id;
                                    $jurnal_entri->tanggal_transaksi       = $request->tanggal_transaksi;
                                    $jurnal_entri->debit              = $request->total_global;
                                    $jurnal_entri->kredit             = 0;
                                    $jurnal_entri->category           = 2;
                                    $jurnal_entri->tahapan            = 2;
                                    $jurnal_entri->keterangan         = NULL;
                                    $jurnal_entri->creat_by           = Auth::user()->id;
                                    $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $jurnal_entri->save();

                                    $JE_L_4 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_4
                                    ]);
    
                                    $get_account_hutang = AccountBank::query()->where('id', $jurnal_debit_id)->get();
                                    foreach ($get_account_hutang as $ahut) {
                                        AccountBank::query()->where('id', $jurnal_debit_id)->update(['saldo'=>$ahut->saldo + $request->nominal_pembayaran]);
                                    }
    
                                    $jurnal_entri2 = new JurnalEntry();
                                    $jurnal_entri2->transaksi_id       = $idTagihanPembelian;
                                    $jurnal_entri2->account_id         = $bank_id_final;
                                    $jurnal_entri2->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $jurnal_entri2->debit              = 0;
                                    $jurnal_entri2->kredit             = $request->total_global;
                                    $jurnal_entri2->category           = 2;
                                    $jurnal_entri2->tahapan            = 2;
                                    $jurnal_entri2->keterangan         = NULL;
                                    $jurnal_entri2->creat_by           = Auth::user()->id;
                                    $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $jurnal_entri2->save();

                                    $JE_L_5 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_5
                                    ]);
    
                                    $get_account_kas = AccountBank::query()->where('id', $bank_id_final)->get();
                                    foreach ($get_account_kas as $akas) {
                                        AccountBank::query()->where('id', $bank_id_final)->update(['saldo'=>$akas->saldo - $request->nominal_pembayaran]);
                                    }
                                }
    
    
                            }
    
                        }
    
                    }
                }
            }else{
                $nominal_pajak = 0;
                $persediaan_barang = 0;
                $total_discount = 0;
                for ($i = 0; $i <= $parameter_detail ; $i++) {
                    $stock_barang_awal = Product::findOrFail($request->product_selected[$i]);
    
                    $log_transaksi = new LogTransaksi();
                    $log_transaksi->transaksi_id        = $idpembelian;
                    $log_transaksi->transaksi_key       = 2;
                    $log_transaksi->account_bank_id     = null;
                    $log_transaksi->saldo_awal          = null;
                    $log_transaksi->saldo_akhir         = null;
                    $log_transaksi->product_id          = $request->product_selected[$i];
                    $log_transaksi->stock_awal          = $stock_barang_awal->qty;
                    $log_transaksi->stock_akhir         = $stock_barang_awal->qty + $request->qty_pembelian[$i];
                    $log_transaksi->creat_by            = Auth::user()->id;
                    $log_transaksi->creat_by_company    = Auth::user()->pegawai->company->id;
                    $saveLog = $log_transaksi->save();
    
                    $update_stock = Product::query()->where('id', $request->product_selected[$i])->update(['qty'=>$stock_barang_awal->qty + $request->qty_pembelian[$i]]);
    
                    $pembelian = new DetailPembelian();
                    $pembelian->pembelian_id        = $idpembelian;
                    $pembelian->product_id          = $request->product_selected[$i];
                    $pembelian->qty_pembelian       = $request->qty_pembelian[$i];
                    $pembelian->discount_product    = $request->discount_per_product[$i];
                    $pembelian->total_discount      = $request->total_discount[$i];
                    $pembelian->pajak_id            = $request->pajak_per_product[$i];
                    $pembelian->potongan_pajak      = $request->potongan_pajak[$i];
                    $pembelian->total               = $request->total_per_product[$i];
                    $pembelian->creat_by            = Auth::user()->id;
                    $pembelian->creat_by_company    = Auth::user()->pegawai->company->id;
                    $msg2 = $pembelian->save();
                    $nominal_pajak += $request->potongan_pajak[$i];
                    $persediaan_barang += $request->total_per_product[$i];
                    $total_discount += $request->total_discount[$i];
    
                    // input ke jurnal
                    if ($msg2) {
                        // get rules dari table rules untuk kebutuhan input jurnal entry
                        $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
                        foreach ($get_syarat_for_account as $gs) {
                            if ($gs->jangka_waktu > 0) {
                                $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 1)->get();
                                foreach ($get_rules_jurnal_entry as $grje) {
                                    $jurnal_pajak_id = $grje->rules_jurnal_akun_ppn;
                                    $jurnal_discount_id = $grje->rules_jurnal_akun_discount;
                                    $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                    $jurnal_kredit_id = $grje->rules_jurnal_akun_kredit;
                                }
                            }else{
                                $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 2)->get();
                                foreach ($get_rules_jurnal_entry as $grje) {
                                    $jurnal_pajak_id = $grje->rules_jurnal_akun_ppn;
                                    $jurnal_discount_id = $grje->rules_jurnal_akun_discount;
                                    $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                }
                            }
                        }
    
                        
                        if ($request->potongan_pajak[$i] > 0) {
                            $pajak = new JurnalEntry();
                            $pajak->transaksi_id       = $idpembelian;
                            $pajak->account_id         = 8;
                            $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                            $pajak->debit              = $nominal_pajak;
                            $pajak->kredit             = 0;
                            $pajak->category           = 2;
                            $pajak->tahapan            = 1;
                            $pajak->keterangan         = NULL;
                            $pajak->creat_by           = Auth::user()->id;
                            $pajak->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $pajak->save();

                            $JE_L_6 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_6
                            ]);
    
                            $get_account_ppn = AccountBank::query()->where('id', 8)->get();
                            foreach ($get_account_ppn as $appn) {
                                AccountBank::query()->where('id', 8)->update(['saldo'=>$appn->saldo + $nominal_pajak]);
                            }
                        }
    
                        if ($request->discount_per_product[$i] > 0) {
                            $discount = new JurnalEntry();
                            $discount->transaksi_id       = $idpembelian;
                            $discount->account_id         = 20;
                            $discount->tanggal_transaksi  = $request->tanggal_transaksi;
                            $discount->debit              = 0;
                            $discount->kredit             = $total_discount;
                            $discount->category           = 2;
                            $discount->tahapan            = 1;
                            $discount->keterangan         = NULL;
                            $discount->creat_by           = Auth::user()->id;
                            $discount->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $discount->save();

                            $JE_L_7 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_7
                            ]);
    
                            $get_account_discount = AccountBank::query()->where('id', 20)->get();
                            foreach ($get_account_discount as $adiscount) {
                                AccountBank::query()->where('id', 20)->update(['saldo'=>$adiscount->saldo - $total_discount]);
                            }
                        }
    
                        $persedian_barang = new JurnalEntry();
                        $persedian_barang->transaksi_id       = $idpembelian;
                        $persedian_barang->account_id         = 6;
                        $persedian_barang->tanggal_transaksi  = $request->tanggal_transaksi;
                        $persedian_barang->debit              = ($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak;
                        $persedian_barang->kredit             = 0;
                        $persedian_barang->category           = 2;
                        $persedian_barang->tahapan            = 1;
                        $persedian_barang->keterangan         = NULL;
                        $persedian_barang->creat_by           = Auth::user()->id;
                        $persedian_barang->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveJurnal = $persedian_barang->save();

                        $JE_L_8 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_8
                        ]);
    
                        $get_account_persediaan = AccountBank::query()->where('id', 6)->get();
                        foreach ($get_account_persediaan as $ap) {
                            AccountBank::query()->where('id', 6)->update(['saldo'=>$ap->saldo + (($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak)]);
                        }
    
                        $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
                        foreach ($get_syarat_for_account as $gs) {
                            if ($gs->jangka_waktu > 0) {
                                $get_id_bank_hutang = AccountBank::query()->where('id', 10)->get();
                                foreach ($get_id_bank_hutang as $bh) {
                                    $bank_id_final_hutang = $bh->id;
                                    AccountBank::query()->where('id', 10)->update(['saldo'=>$bh->saldo - $request->total_global]);
                                }
                                $akun_bank = new JurnalEntry();
                                $akun_bank->transaksi_id       = $idpembelian;
                                $akun_bank->account_id         = $bank_id_final_hutang;
                                $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                $akun_bank->debit              = 0;
                                $akun_bank->kredit             = $request->total_global;
                                $akun_bank->category           = 2;
                                $akun_bank->tahapan            = 1;
                                $akun_bank->keterangan         = NULL;
                                $akun_bank->creat_by           = Auth::user()->id;
                                $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $akun_bank->save();

                                $JE_L_9 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_9
                                ]);
                            } else {
                                $account_bank = MetodePembayaran::findOrFail($request->metode_pembayaran_id);
                                $id_bank = $account_bank->account_bank;
    
                                $get_id_bank = AccountBank::query()->where('id', $id_bank)->get();
                                foreach ($get_id_bank as $b) {
                                    $bank_id_final = $b->id;
                                    AccountBank::query()->where('id', $id_bank)->update(['saldo'=>$b->saldo - $request->total_global]);
                                }
                                $akun_bank = new JurnalEntry();
                                $akun_bank->transaksi_id       = $idpembelian;
                                $akun_bank->account_id         = $bank_id_final;
                                $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                $akun_bank->debit              = 0;
                                $akun_bank->kredit             = $request->total_global;
                                $akun_bank->category           = 2;
                                $akun_bank->tahapan            = 1;
                                $akun_bank->keterangan         = NULL;
                                $akun_bank->creat_by           = Auth::user()->id;
                                $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $akun_bank->save();

                                $JE_L_10 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_10
                                ]);
    
    
                                // count data tagihan pembelian berdasarkan 
                                $data_tag = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $idpembelian)->count();
                                    if ($data_tag == 0) {
                                        $kode = '10001';
                                    }else{
                                        $max_kode = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $idpembelian)->max('no_pembayaran');
                                        $kode = $max_kode+1;
                                    }
    
    
                                $bayar_pembelian = new TagihanPembelian();
                                $bayar_pembelian->pembelian_id            = $idpembelian;
                                $bayar_pembelian->tanggal_bayar          = $request->tanggal_transaksi;
                                $bayar_pembelian->account_pembayar      = $bank_id_final;
                                $bayar_pembelian->nominal_pembayaran           = $request->total_global;
                                $bayar_pembelian->transaksi            = 'Bank Withdrawal';
                                $bayar_pembelian->no_pembayaran      = $kode;
                                $bayar_pembelian->keterangan      = $request->pesan;
                                $bayar_pembelian->creat_by           = Auth::user()->id;
                                $bayar_pembelian->creat_by_company   = Auth::user()->pegawai->company->id;
                                $savePembayaran = $bayar_pembelian->save();
    
                                $idTagihanPembelian = DB::getPdo()->lastInsertId();
    
    
                                if ($savePembayaran) {
                                    $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 3)->get();
                                    foreach ($get_rules_jurnal_entry as $grje) {
                                        $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                    }
    
                                    $jurnal_entri = new JurnalEntry();
                                    $jurnal_entri->transaksi_id       = $idTagihanPembelian;
                                    $jurnal_entri->account_id         = $jurnal_debit_id;
                                    $jurnal_entri->tanggal_transaksi       = $request->tanggal_transaksi;
                                    $jurnal_entri->debit              = $request->total_global;
                                    $jurnal_entri->kredit             = 0;
                                    $jurnal_entri->category           = 2;
                                    $jurnal_entri->tahapan            = 2;
                                    $jurnal_entri->keterangan         = NULL;
                                    $jurnal_entri->creat_by           = Auth::user()->id;
                                    $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $jurnal_entri->save();

                                    $JE_L_11 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_11
                                    ]);
    
                                    $get_account_hutang = AccountBank::query()->where('id', $jurnal_debit_id)->get();
                                    foreach ($get_account_hutang as $ahut) {
                                        AccountBank::query()->where('id', $jurnal_debit_id)->update(['saldo'=>$ahut->saldo + $request->nominal_pembayaran]);
                                    }
    
                                    $jurnal_entri2 = new JurnalEntry();
                                    $jurnal_entri2->transaksi_id       = $idTagihanPembelian;
                                    $jurnal_entri2->account_id         = $bank_id_final;
                                    $jurnal_entri2->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $jurnal_entri2->debit              = 0;
                                    $jurnal_entri2->kredit             = $request->total_global;
                                    $jurnal_entri2->category           = 2;
                                    $jurnal_entri2->tahapan            = 2;
                                    $jurnal_entri2->keterangan         = NULL;
                                    $jurnal_entri2->creat_by           = Auth::user()->id;
                                    $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $jurnal_entri2->save();

                                    $JE_L_12 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_12
                                    ]);
    
                                    $get_account_kas = AccountBank::query()->where('id', $bank_id_final)->get();
                                    foreach ($get_account_kas as $akas) {
                                        AccountBank::query()->where('id', $bank_id_final)->update(['saldo'=>$akas->saldo - $request->nominal_pembayaran]);
                                    }
                                }
    
    
                            }
    
                        }
    
                    }
                }
            }
        }



        if ($saveJurnal) {
            $data = Pembelian::findOrFail($idpembelian);
            return redirect()->route('pembelian.show', $data)->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('pembelian.index')->with(['error' => 'Data Gagal Diupload']);
        }

    }

    
    public function show($id)
    {
        $data = Pembelian::findOrFail($id);

        $data_detail = DetailPembelian::query()->with(['pengajuan'])->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $data->id)->get();
        $pajak = DetailPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $data->id)->sum('potongan_pajak');
        // dd($data_detail);
        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 2)->where('tahapan', 1)->get();
        $sum_jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 2)->where('tahapan', 1)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 2)->where('tahapan', 1)->sum('kredit');
        return view('pages_finance.pembelian.detail', [
            'data'=> $data,
            'data_detail'=> $data_detail,
            'pajak' => $pajak,
            'jurnal_entry'=> $jurnal_entry,
            'sum_jurnal_debit'=> $sum_jurnal_debit,
            'sum_jurnal_kredit'=> $sum_jurnal_kredit
        ]);
    }

    
    public function edit($id)
    {
        $account_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $data = Pembelian::findOrFail($id);
        $pengajuan = DetailPengajuan::query()->whereHas('pengajuan', function($pengajuan){$pengajuan->where('creat_by_company', Auth::user()->pegawai->company->id);})->get();
        $suppliers = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $detail_pembelian = DetailPembelian::query()->with(['pengajuan'])->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->get();

        $pajak = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $metodepembayaran = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $syaratpembayaran = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        $pembelian = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
        $product = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();


        return view('pages_finance.pembelian.edit', [
            'data'              => $data,
            'suppliers'         => $suppliers,
            'pajak'             => $pajak,
            'metodepembayaran'  => $metodepembayaran,
            'syaratpembayaran'  => $syaratpembayaran,
            'pembelian'         => $pembelian,
            'product'           => $product,
            'detail_pembelian'  => $detail_pembelian,
            'pengajuan'         => $pengajuan,
            'account_bank'      => $account_bank
        ]);
    }

    public function lacak_pembayaran_pembelian($id){
        $data = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->with(['pembelian'])->get();

        // dd($data);
        return view('pages_finance.pembelian.lacakPembayaran', [
            'data'  => $data,
            'idData'    => $id
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_transaksi'          => 'required',
            'supplier_id'           => 'required',
            'tanggal_transaksi'     => 'required',
            'syarat_pembayaran_id'  => 'required',
            'tanggal_jatuh_tempo'   => 'required',
            'alamat_penagihan'      => 'required',
            'sub_total'             => 'required', 
            'total_global'          => 'required',
            'sisa_tagihan'          => 'required',
        ]);

        $item = Pembelian::findOrFail($id);

        if ($request->switch_rab == 1) {
            $jenis_pembelian = 'Pembelian RAB';
        }else{
            $jenis_pembelian = 'Default Pembelian';
        }

        $get_syarat = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
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
                $metodepembayaran = $request->metode_pembayaran_id;
            }

        }

        if (!empty($request->lampiran)) {
            Storage::disk('local')->delete('public/'. $request->lampiran_old);
            $updatePembelian = $item->update([
                'transaksi'             => "Purchase Invoice",
                'no_transaksi'          => $request->no_transaksi,
                'supplier_id'           => $request->supplier_id,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'metode_pembayaran_id'  => $metodepembayaran,
                'syarat_pembayaran_id'  => $request->syarat_pembayaran_id,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'nominal_tagihan'       => $nominal_tagihan,
                'alamat_penagihan'      => $request->alamat_penagihan,
                'pesan'                 => $request->pesan,
                'lampiran'              => $request->file('lampiran')->store('assets/dokumen/lampiranPembelian', 'public'),
                'sub_total'             => $request->sub_total,
                'discount_pembelian'    => $request->discount_global_result,
                'total'                 => $request->total_global,
                'sisa_tagihan'          => $sisa_tagihan,
                'status'                => $status,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id,
                'jenis_pembelian'       => $jenis_pembelian
            ]);
        } else{
            $updatePembelian = $item->update([
                'transaksi'             => "Purchase Invoice",
                'no_transaksi'          => $request->no_transaksi,
                'supplier_id'           => $request->supplier_id,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'metode_pembayaran_id'  => $metodepembayaran,
                'syarat_pembayaran_id'  => $request->syarat_pembayaran_id,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'nominal_tagihan'       => $nominal_tagihan,
                'alamat_penagihan'      => $request->alamat_penagihan,
                'pesan'                 => $request->pesan,
                'sub_total'             => $request->sub_total,
                'discount_pembelian'    => $request->discount_global_result,
                'total'                 => $request->total_global,
                'sisa_tagihan'          => $sisa_tagihan,
                'status'                => $status,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id,
                'jenis_pembelian'       => $jenis_pembelian
            ]);
        }
        //get parameter detail
        $parameter_detail = $request->hitung_row;

        if ($updatePembelian) {
            $itemDel = DetailPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->delete();

            if ($itemDel) {
                if ($request->switch_rab == 1) {
                    for ($i = 0; $i <= $parameter_detail ; $i++) {
                        $pembelian = new DetailPembelian();
                        $pembelian->pembelian_id        = $id;
                        $pembelian->creat_by            = Auth::user()->id;
                        $pembelian->creat_by_company    = Auth::user()->pegawai->company->id;
                        $pembelian->item_pengajuan      = $request->pengajuan_selected[$i];
                        $msg2 = $pembelian->save();
        
                        // input ke jurnal
                        if ($msg2) {
                            // select jurnal debit by id transaksi
                            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 1)->where('kredit', 0)->get();
                            foreach ($jurnal_debit as $j_deb) {
                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                                foreach ($get_account_debit as $ad) {
                                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                                }
                            }
                            // select jurnal kredit by id transaksi
                            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 1)->where('debit', 0)->get();
                            foreach ($jurnal_kredit as $j_kred) {
                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                                foreach ($get_account_kredit as $ad) {
                                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                                }
                            }

                            // delete jurnal entry sebelumnya
                            JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 1)->delete();
        
                            // get rules dari table rules untuk kebutuhan input jurnal entry
                            $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
                            foreach ($get_syarat_for_account as $gs) {
                                if ($gs->jangka_waktu > 0) {
                                    $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 1)->get();
                                    foreach ($get_rules_jurnal_entry as $grje) {
                                        $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                        $jurnal_kredit_id = $grje->rules_jurnal_akun_kredit;
                                    }
                                }else{
                                    $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 2)->get();
                                    foreach ($get_rules_jurnal_entry as $grje) {
                                        $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                    }
                                }
                            }
    
                            //jurnal entry debit
                            $persedian_barang = new JurnalEntry();
                            $persedian_barang->transaksi_id       = $id;
                            $persedian_barang->account_id         = 6;
                            $persedian_barang->tanggal_transaksi  = $request->tanggal_transaksi;
                            $persedian_barang->debit              = $request->total_budget[$i];
                            $persedian_barang->kredit             = 0;
                            $persedian_barang->category           = 2;
                            $persedian_barang->tahapan            = 1;
                            $persedian_barang->keterangan         = NULL;
                            $persedian_barang->creat_by           = Auth::user()->id;
                            $persedian_barang->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $persedian_barang->save();

                            $JE_L_1 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_1
                            ]);
        
                            $get_account_persediaan = AccountBank::query()->where('id', 6)->get();
                            foreach ($get_account_persediaan as $ap) {
                                AccountBank::query()->where('id', 6)->update(['saldo'=> $request->total_budget[$i]]);
                            }

                            
                            $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
                            foreach ($get_syarat_for_account as $gs) {
                                if ($gs->jangka_waktu > 0) {
                                    $get_id_bank_hutang = AccountBank::query()->where('id', 10)->get();
                                    foreach ($get_id_bank_hutang as $bh) {
                                        $bank_id_final_hutang = $bh->id;
                                        AccountBank::query()->where('id', 10)->update(['saldo'=>$bh->saldo - $request->total_budget[$i]]);
                                    }
                                    $akun_bank = new JurnalEntry();
                                    $akun_bank->transaksi_id       = $id;
                                    $akun_bank->account_id         = $bank_id_final_hutang;
                                    $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $akun_bank->debit              = 0;
                                    $akun_bank->kredit             = $request->total_budget[$i];
                                    $akun_bank->category           = 2;
                                    $akun_bank->tahapan            = 1;
                                    $akun_bank->keterangan         = NULL;
                                    $akun_bank->creat_by           = Auth::user()->id;
                                    $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $akun_bank->save();

                                    $JE_L_2 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_2
                                    ]);
                                } else {
                                    //find payment method and get account bank by payment method
                                    $account_bank = MetodePembayaran::findOrFail($request->metode_pembayaran_id);
                                    $id_bank = $account_bank->account_bank;
        
                                    // get id bank from Account bank table where id equal in result previous method 
                                    $get_id_bank = AccountBank::query()->where('id', $id_bank)->get();
                                    foreach ($get_id_bank as $b) {
                                        $bank_id_final = $b->id;
                                        AccountBank::query()->where('id', $id_bank)->update(['saldo'=>$b->saldo - $request->total_budget[$i]]);
                                    }
    
                                    
                                    $akun_bank = new JurnalEntry();
                                    $akun_bank->transaksi_id       = $id;
                                    $akun_bank->account_id         = $bank_id_final;
                                    $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $akun_bank->debit              = 0;
                                    $akun_bank->kredit             = $request->total_budget[$i];
                                    $akun_bank->category           = 2;
                                    $akun_bank->tahapan            = 1;
                                    $akun_bank->keterangan         = NULL;
                                    $akun_bank->creat_by           = Auth::user()->id;
                                    $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $akun_bank->save();

                                    $JE_L_3 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_3
                                    ]);


                                    $get_pembayaran_transaksi = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->get();
                                        foreach ($get_pembayaran_transaksi as $gpt) {
                                            // select jurnal debit by id transaksi pkembayaran
                                            $jurnal_debit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->where('kredit', 0)->get();
                                            foreach ($jurnal_debit_bay as $j_deb_bay) {
                                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb_bay->id)->delete();
                                                $get_account_debit = AccountBank::query()->where('id', $j_deb_bay->account_id)->get();
                                                foreach ($get_account_debit as $ad_bay) {
                                                    AccountBank::query()->where('id', $j_deb_bay->account_id)->update(['saldo'=>$ad_bay->saldo - $j_deb_bay->debit]);
                                                }
                                            }
                                            // select jurnal kredit by id transaksi pembayaran
                                            $jurnal_kredit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->where('debit', 0)->get();
                                            foreach ($jurnal_kredit_bay as $j_kred_bay) {
                                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred_bay->id)->delete();
                                                $get_account_kredit_bay = AccountBank::query()->where('id', $j_kred_bay->account_id)->get();
                                                foreach ($get_account_kredit_bay as $ad) {
                                                    AccountBank::query()->where('id', $j_kred_bay->account_id)->update(['saldo'=>$ad->saldo + $j_kred_bay->kredit]);
                                                }
                                            }
                                            $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->delete();
                                            TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->delete();
                                        }
        
        
                                    // count data tagihan pembelian berdasarkan 
                                    $data_tag = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->count();
                                        if ($data_tag == 0) {
                                            $kode = '10001';
                                        }else{
                                            $max_kode = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->max('no_pembayaran');
                                            $kode = $max_kode+1;
                                        }
        
        
                                        //input tagihan pembelian ketika pembelian dengan 
                                    $bayar_pembelian = new TagihanPembelian();
                                    $bayar_pembelian->pembelian_id            = $id;
                                    $bayar_pembelian->tanggal_bayar          = $request->tanggal_transaksi;
                                    $bayar_pembelian->account_pembayar      = $bank_id_final;
                                    $bayar_pembelian->nominal_pembayaran           = $request->total_global;
                                    $bayar_pembelian->transaksi            = 'Bank Withdrawal';
                                    $bayar_pembelian->no_pembayaran      = $kode;
                                    $bayar_pembelian->keterangan      = $request->pesan;
                                    $bayar_pembelian->creat_by           = Auth::user()->id;
                                    $bayar_pembelian->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $savePembayaran = $bayar_pembelian->save();
        
                                    $idTagihanPembelian = DB::getPdo()->lastInsertId();
        
        
                                    if ($savePembayaran) {
                                        $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 3)->get();
                                        foreach ($get_rules_jurnal_entry as $grje) {
                                            $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                        }
        
                                        $jurnal_entri = new JurnalEntry();
                                        $jurnal_entri->transaksi_id       = $idTagihanPembelian;
                                        $jurnal_entri->account_id         = $jurnal_debit_id;
                                        $jurnal_entri->tanggal_transaksi       = $request->tanggal_transaksi;
                                        $jurnal_entri->debit              = $request->total_global;
                                        $jurnal_entri->kredit             = 0;
                                        $jurnal_entri->category           = 2;
                                        $jurnal_entri->tahapan            = 2;
                                        $jurnal_entri->keterangan         = NULL;
                                        $jurnal_entri->creat_by           = Auth::user()->id;
                                        $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
                                        $saveJurnal = $jurnal_entri->save();

                                        $JE_L_4 = DB::getPdo()->lastInsertId();

                                        jurnal_penyesuaian::create([
                                            'jurnal_entry_id' => $JE_L_4
                                        ]);
        
                                        $get_account_hutang = AccountBank::query()->where('id', $jurnal_debit_id)->get();
                                        foreach ($get_account_hutang as $ahut) {
                                            AccountBank::query()->where('id', $jurnal_debit_id)->update(['saldo'=>$ahut->saldo + $request->nominal_pembayaran]);
                                        }
        
                                        $jurnal_entri2 = new JurnalEntry();
                                        $jurnal_entri2->transaksi_id       = $idTagihanPembelian;
                                        $jurnal_entri2->account_id         = $bank_id_final;
                                        $jurnal_entri2->tanggal_transaksi  = $request->tanggal_transaksi;
                                        $jurnal_entri2->debit              = 0;
                                        $jurnal_entri2->kredit             = $request->total_global;
                                        $jurnal_entri2->category           = 2;
                                        $jurnal_entri2->tahapan            = 2;
                                        $jurnal_entri2->keterangan         = NULL;
                                        $jurnal_entri2->creat_by           = Auth::user()->id;
                                        $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
                                        $saveJurnal = $jurnal_entri2->save();

                                        $JE_L_5 = DB::getPdo()->lastInsertId();

                                        jurnal_penyesuaian::create([
                                            'jurnal_entry_id' => $JE_L_5
                                        ]);
        
                                        $get_account_kas = AccountBank::query()->where('id', $bank_id_final)->get();
                                        foreach ($get_account_kas as $akas) {
                                            AccountBank::query()->where('id', $bank_id_final)->update(['saldo'=>$akas->saldo - $request->nominal_pembayaran]);
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
                    for ($i = 0; $i <= $parameter_detail ; $i++) {
                        $dataLog = LogTransaksi::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('transaksi_key', 2)->get();
                        foreach ($dataLog as $us) {
                            $updateStockUlang = Product::where('id', $us->product_id)->update(['qty'=>$us->stock_awal]);
                        }
                        $stock_barang_awal = Product::findOrFail($request->product_selected[$i]);
                        $LogDel = LogTransaksi::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('transaksi_key', 2)->delete();
    
                        if ($LogDel) {
                            $log_transaksi = new LogTransaksi();
                            $log_transaksi->transaksi_id        = $id;
                            $log_transaksi->transaksi_key       = 2;
                            $log_transaksi->account_bank_id     = null;
                            $log_transaksi->saldo_awal          = null;
                            $log_transaksi->saldo_akhir         = null;
                            $log_transaksi->product_id          = $request->product_selected[$i];
                            $log_transaksi->stock_awal          = $stock_barang_awal->qty;
                            $log_transaksi->stock_akhir         = $stock_barang_awal->qty + $request->qty_pembelian[$i];
                            $log_transaksi->creat_by           = Auth::user()->id;
                            $log_transaksi->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveLog = $log_transaksi->save();
                        }
    
                        $update_stock = Product::query()->where('id', $request->product_selected[$i])->update(['qty'=>$stock_barang_awal->qty + $request->qty_pembelian[$i]]);
    
    
                        $pembelian = new DetailPembelian();
                        $pembelian->pembelian_id        = $id;
                        $pembelian->product_id          = $request->product_selected[$i];
                        $pembelian->qty_pembelian       = $request->qty_pembelian[$i];
                        $pembelian->discount_product    = $request->discount_per_product[$i];
                        $pembelian->total_discount      = $request->total_discount[$i];
                        $pembelian->pajak_id            = $request->pajak_per_product[$i];
                        $pembelian->potongan_pajak      = $request->potongan_pajak[$i];
                        $pembelian->total               = $request->total_per_product[$i];
                        $pembelian->creat_by           = Auth::user()->id;
                        $pembelian->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveDetail = $pembelian->save();
                        $nominal_pajak += $request->potongan_pajak[$i];
                        $persediaan_barang += $request->total_per_product[$i];
                        $total_discount += $request->total_discount[$i];
                        // input ke jurnal
                        if ($saveDetail) {
    
                            // select jurnal debit by id transaksi
                            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 1)->where('kredit', 0)->get();
                            foreach ($jurnal_debit as $j_deb) {
                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                                foreach ($get_account_debit as $ad) {
                                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                                }
                            }
                            // select jurnal kredit by id transaksi
                            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 1)->where('debit', 0)->get();
                            foreach ($jurnal_kredit as $j_kred) {
                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                                foreach ($get_account_kredit as $ad) {
                                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                                }
                            }
    
                            // delete jurnal entry sebelumnya
                            JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 1)->delete();
    
                            $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
    
                            foreach ($get_syarat_for_account as $gs) {
                                if ($gs->jangka_waktu > 0) {
                                    $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 1)->get();
                                    foreach ($get_rules_jurnal_entry as $grje) {
                                        $jurnal_pajak_id = $grje->rules_jurnal_akun_ppn;
                                        $jurnal_discount_id = $grje->rules_jurnal_akun_discount;
                                        $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                        $jurnal_kredit_id = $grje->rules_jurnal_akun_kredit;
                                    }
                                }else{
                                    $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 2)->get();
                                    foreach ($get_rules_jurnal_entry as $grje) {
                                        $jurnal_pajak_id = $grje->rules_jurnal_akun_ppn;
                                        $jurnal_discount_id = $grje->rules_jurnal_akun_discount;
                                        $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                    }
                                }
                            }
    
                            // input kembali jurnal entry yang baru
                            if ($request->potongan_pajak[$i] > 0) {
                                // dd($request->discount_per_product[$i]);
                                $pajak = new JurnalEntry();
                                $pajak->transaksi_id       = $id;
                                $pajak->account_id         = 8;
                                $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                                $pajak->debit              = $nominal_pajak;
                                $pajak->kredit             = 0;
                                $pajak->category           = 2;
                                $pajak->tahapan            = 1;
                                $pajak->keterangan         = NULL;
                                $pajak->creat_by           = Auth::user()->id;
                                $pajak->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $pajak->save();

                                $JE_L_6 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_6
                                ]);
    
                                $get_account_ppn = AccountBank::query()->where('id', 8)->get();
                                foreach ($get_account_ppn as $appn) {
                                    AccountBank::query()->where('id', 8)->update(['saldo'=>$appn->saldo + $nominal_pajak]);
                                }
                            }
    
                            if ($request->discount_per_product[$i] > 0) {
                                $discount = new JurnalEntry();
                                $discount->transaksi_id       = $id;
                                $discount->account_id         = 20;
                                $discount->tanggal_transaksi  = $request->tanggal_transaksi;
                                $discount->debit              = 0;
                                $discount->kredit             = $total_discount;
                                $discount->category           = 2;
                                $discount->tahapan            = 1;
                                $discount->keterangan         = NULL;
                                $discount->creat_by           = Auth::user()->id;
                                $discount->creat_by_company   = Auth::user()->pegawai->company->id;
                                $saveJurnal = $discount->save();

                                $JE_L_7 = DB::getPdo()->lastInsertId();

                                jurnal_penyesuaian::create([
                                    'jurnal_entry_id' => $JE_L_7
                                ]);
    
                                $get_account_discount = AccountBank::query()->where('id', 20)->get();
                                foreach ($get_account_discount as $adiscount) {
                                    AccountBank::query()->where('id', 20)->update(['saldo'=>$adiscount->saldo - $total_discount]);
                                }
                            }
    
                            $persedian_barang = new JurnalEntry();
                            $persedian_barang->transaksi_id       = $id;
                            $persedian_barang->account_id         = 6;
                            $persedian_barang->tanggal_transaksi  = $request->tanggal_transaksi;
                            $persedian_barang->debit              = ($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak;
                            $persedian_barang->kredit             = 0;
                            $persedian_barang->category           = 2;
                            $persedian_barang->tahapan            = 1;
                            $persedian_barang->keterangan         = NULL;
                            $persedian_barang->creat_by           = Auth::user()->id;
                            $persedian_barang->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $persedian_barang->save();

                            $JE_L_8 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_8
                            ]);
    
                            $get_account_persediaan = AccountBank::query()->where('id', 6)->get();
                            foreach ($get_account_persediaan as $ap) {
                                AccountBank::query()->where('id', 6)->update(['saldo'=>$ap->saldo + (($persediaan_barang + ($request->discount_global_result + $total_discount))-$nominal_pajak)]);
                            }
    
                            $get_syarat_for_account = SyaratPembayaran::query()->where('id', $request->syarat_pembayaran_id)->get();
                            foreach ($get_syarat_for_account as $gs) {
                                if ($gs->jangka_waktu > 0) {
                                    $get_id_bank_hutang = AccountBank::query()->where('id', 10)->get();
                                    foreach ($get_id_bank_hutang as $bh) {
                                        $bank_id_final_hutang = $bh->id;
                                        AccountBank::query()->where('id', 10)->update(['saldo'=>$bh->saldo - $request->total_global]);
                                    }
                                    $akun_bank = new JurnalEntry();
                                    $akun_bank->transaksi_id       = $id;
                                    $akun_bank->account_id         = $bank_id_final_hutang;
                                    $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $akun_bank->debit              = 0;
                                    $akun_bank->kredit             = $request->total_global;
                                    $akun_bank->category           = 2;
                                    $akun_bank->tahapan            = 1;
                                    $akun_bank->keterangan         = NULL;
                                    $akun_bank->creat_by           = Auth::user()->id;
                                    $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $akun_bank->save();

                                    $JE_L_9 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_9
                                    ]);
                                }else{
                                    $account_bank = MetodePembayaran::findOrFail($request->metode_pembayaran_id);
                                    $id_bank = $account_bank->account_bank;
                                    $get_id_bank = AccountBank::query()->where('id', $id_bank)->get();
                                    foreach ($get_id_bank as $b) {
                                        $bank_id_final = $b->id;
                                        AccountBank::query()->where('id', $id_bank)->update(['saldo'=>$b->saldo - $request->total_global]);
                                    }
                                    $akun_bank = new JurnalEntry();
                                    $akun_bank->transaksi_id       = $id;
                                    $akun_bank->account_id         = $bank_id_final;
                                    $akun_bank->tanggal_transaksi  = $request->tanggal_transaksi;
                                    $akun_bank->debit              = 0;
                                    $akun_bank->kredit             = $request->total_global;
                                    $akun_bank->category           = 2;
                                    $akun_bank->tahapan            = 1;
                                    $akun_bank->keterangan         = NULL;
                                    $akun_bank->creat_by           = Auth::user()->id;
                                    $akun_bank->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $saveJurnal = $akun_bank->save();

                                    $JE_L_10 = DB::getPdo()->lastInsertId();

                                    jurnal_penyesuaian::create([
                                        'jurnal_entry_id' => $JE_L_10
                                    ]);
    
    
                                    $get_pembayaran_transaksi = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->get();
                                        foreach ($get_pembayaran_transaksi as $gpt) {
                                            // select jurnal debit by id transaksi pkembayaran
                                            $jurnal_debit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->where('kredit', 0)->get();
                                            foreach ($jurnal_debit_bay as $j_deb_bay) {
                                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb_bay->id)->delete();
                                                $get_account_debit = AccountBank::query()->where('id', $j_deb_bay->account_id)->get();
                                                foreach ($get_account_debit as $ad_bay) {
                                                    AccountBank::query()->where('id', $j_deb_bay->account_id)->update(['saldo'=>$ad_bay->saldo - $j_deb_bay->debit]);
                                                }
                                            }
                                            // select jurnal kredit by id transaksi pembayaran
                                            $jurnal_kredit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->where('debit', 0)->get();
                                            foreach ($jurnal_kredit_bay as $j_kred_bay) {
                                                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred_bay->id)->delete();
                                                $get_account_kredit_bay = AccountBank::query()->where('id', $j_kred_bay->account_id)->get();
                                                foreach ($get_account_kredit_bay as $ad) {
                                                    AccountBank::query()->where('id', $j_kred_bay->account_id)->update(['saldo'=>$ad->saldo + $j_kred_bay->kredit]);
                                                }
                                            }
                                            $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->delete();
                                            TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->delete();
                                        }
    
    
    
                                    $data_tag = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
                                    if ($data_tag == 0) {
                                        $kode = '10001';
                                    }else{
                                        $max_kode = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_pembayaran');
                                        $kode = $max_kode+1;
                                    }
    
    
                                    $bayar_pembelian = new TagihanPembelian();
                                    $bayar_pembelian->pembelian_id            = $id;
                                    $bayar_pembelian->tanggal_bayar          = $request->tanggal_transaksi;
                                    $bayar_pembelian->account_pembayar      = $bank_id_final;
                                    $bayar_pembelian->nominal_pembayaran           = $request->total_global;
                                    $bayar_pembelian->transaksi            = 'Bank Withdrawal';
                                    $bayar_pembelian->no_pembayaran      = $kode;
                                    $bayar_pembelian->keterangan      = $request->pesan;
                                    $bayar_pembelian->creat_by           = Auth::user()->id;
                                    $bayar_pembelian->creat_by_company   = Auth::user()->pegawai->company->id;
                                    $savePembayaran = $bayar_pembelian->save();
    
                                    $idTagihanPembelian = DB::getPdo()->lastInsertId();
    
    
                                    if ($savePembayaran) {
                                        $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 3)->get();
                                        foreach ($get_rules_jurnal_entry as $grje) {
                                            $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
                                        }
    
                                        $jurnal_entri = new JurnalEntry();
                                        $jurnal_entri->transaksi_id       = $idTagihanPembelian;
                                        $jurnal_entri->account_id         = $jurnal_debit_id;
                                        $jurnal_entri->tanggal_transaksi       = $request->tanggal_transaksi;
                                        $jurnal_entri->debit              = $request->total_global;
                                        $jurnal_entri->kredit             = 0;
                                        $jurnal_entri->category           = 2;
                                        $jurnal_entri->tahapan            = 2;
                                        $jurnal_entri->keterangan         = NULL;
                                        $jurnal_entri->creat_by           = Auth::user()->id;
                                        $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
                                        $saveJurnal = $jurnal_entri->save();

                                        $JE_L_11 = DB::getPdo()->lastInsertId();

                                        jurnal_penyesuaian::create([
                                            'jurnal_entry_id' => $JE_L_11
                                        ]);
    
                                        $get_account_hutang = AccountBank::query()->where('id', $jurnal_debit_id)->get();
                                        foreach ($get_account_hutang as $ahut) {
                                            AccountBank::query()->where('id', $jurnal_debit_id)->update(['saldo'=>$ahut->saldo + $request->nominal_pembayaran]);
                                        }
    
                                        $jurnal_entri2 = new JurnalEntry();
                                        $jurnal_entri2->transaksi_id       = $idTagihanPembelian;
                                        $jurnal_entri2->account_id         = $bank_id_final;
                                        $jurnal_entri2->tanggal_transaksi  = $request->tanggal_transaksi;
                                        $jurnal_entri2->debit              = 0;
                                        $jurnal_entri2->kredit             = $request->total_global;
                                        $jurnal_entri2->category           = 2;
                                        $jurnal_entri2->tahapan            = 2;
                                        $jurnal_entri2->keterangan         = NULL;
                                        $jurnal_entri2->creat_by           = Auth::user()->id;
                                        $jurnal_entri2->creat_by_company   = Auth::user()->pegawai->company->id;
                                        $saveJurnal = $jurnal_entri2->save();

                                        $JE_L_12 = DB::getPdo()->lastInsertId();

                                        jurnal_penyesuaian::create([
                                            'jurnal_entry_id' => $JE_L_12
                                        ]);
    
                                        $get_account_kas = AccountBank::query()->where('id', $bank_id_final)->get();
                                        foreach ($get_account_kas as $akas) {
                                            AccountBank::query()->where('id', $bank_id_final)->update(['saldo'=>$akas->saldo - $request->nominal_pembayaran]);
                                        }
                                    }
    
    
                                }
                            }
                        }
                    }
                }
                




                if ($saveJurnal) {
                    $data = Pembelian::findOrFail($id);
                    return redirect()->route('pembelian.show', $data)->with(['success' => 'Data Berhasil Diupdate']);
                } else {
                    return redirect()->route('pembelian.index')->with(['error' => 'Data Gagal Diupdate']);
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
        $data = Pembelian::findOrFail($id);

        $file = $data->gambar;

        $dataLog = LogTransaksi::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('transaksi_key', 2)->get();
        foreach ($dataLog as $us) {
            $updateStockUlang = Product::where('id', $us->product_id)->update(['qty'=>$us->stock_awal]);
        }

        $LogDel = LogTransaksi::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('transaksi_key', 2)->delete();

        $detailDelete = DetailPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->delete();

        if ($detailDelete) {

            // select jurnal debit by id transaksi
            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 1)->where('kredit', 0)->get();
            foreach ($jurnal_debit as $j_deb) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                foreach ($get_account_debit as $ad) {
                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                }
            }
            // select jurnal kredit by id transaksi
            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 1)->where('debit', 0)->get();
            foreach ($jurnal_kredit as $j_kred) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                foreach ($get_account_kredit as $ad) {
                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                }
            }

            $jurnalDelete = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->delete();

        }

        $get_pembayaran_transaksi = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->get();
        foreach ($get_pembayaran_transaksi as $gpt) {
            // select jurnal debit by id transaksi pkembayaran
            $jurnal_debit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->where('kredit', 0)->get();
            foreach ($jurnal_debit_bay as $j_deb_bay) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb_bay->id)->delete();
                $get_account_debit = AccountBank::query()->where('id', $j_deb_bay->account_id)->get();
                foreach ($get_account_debit as $ad_bay) {
                    AccountBank::query()->where('id', $j_deb_bay->account_id)->update(['saldo'=>$ad_bay->saldo - $j_deb_bay->debit]);
                }
            }
            // select jurnal kredit by id transaksi pembayaran
            $jurnal_kredit_bay = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->where('debit', 0)->get();
            foreach ($jurnal_kredit_bay as $j_kred_bay) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred_bay->id)->delete();
                $get_account_kredit_bay = AccountBank::query()->where('id', $j_kred_bay->account_id)->get();
                foreach ($get_account_kredit_bay as $ad) {
                    AccountBank::query()->where('id', $j_kred_bay->account_id)->update(['saldo'=>$ad->saldo + $j_kred_bay->kredit]);
                }
            }
            $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $gpt->id)->where('category', 2)->where('tahapan', 2)->delete();
            TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->delete();
        }

        if ($file != null) {
            Storage::disk('local')->delete('public/'.$file);

            $msg = $data->delete();

            if ($msg) {
                return redirect()->route('pembelian.index')->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('pembelian.index')->with(['error' => 'Data Gagal Dihapus']);
            }
        }else{
            $msg = $data->delete();

            if ($msg) {
                return redirect()->route('pembelian.index')->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('pembelian.index')->with(['error' => 'Data Gagal Dihapus']);
            }
        }
    }


    public function showBayar($id){
        $data = Pembelian::findOrFail($id);
        // dd($data);
        $bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
        return view('pages_finance.pembelian.showTagihan', [
            'data'  => $data,
            'bank'  => $bank
        ]);
    }

    public function show_jurnal_pembelian($id)
    {
        $data = TagihanPembelian::findOrFail($id);
        // $tagihan = Pembelian::query()->where('pembelian_id', $id)->get();

        $data_detail = TagihanPembelian::query()->where('id', $id)->get();
        $pajak = DetailPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('pembelian_id', $id)->sum('potongan_pajak');

        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 2)->where('tahapan', 2)->orderBy('id', 'desc')->get();
        $sum_jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 2)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 2)->sum('kredit');
        return view('pages_finance.pembelian.show_jurnal', [
            'data'=> $data,
            'data_detail'=> $data_detail,
            'pajak' => $pajak,
            'jurnal_entry'=> $jurnal_entry,
            'sum_jurnal_debit'=> $sum_jurnal_debit,
            'sum_jurnal_kredit'=> $sum_jurnal_kredit,
        ]);
    }

    public function bayar_cicilan_pembelian(Request $request){
        $request->validate([
            'nominal_pembayaran' => 'required',
            'account_pembayar'  => 'required',
            'tanggal_bayar' => 'required|date',
            'keterangan'    => 'nullable|string'
        ]);

        $data = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
        if ($data == 0) {
            $kode = '10001';
        }else{
            $max_kode = TagihanPembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_pembayaran');
            $kode = $max_kode+1;
        }

        $bayar_pembelian = new TagihanPembelian();
        $bayar_pembelian->pembelian_id            = $request->id_pembelian;
        $bayar_pembelian->tanggal_bayar          = $request->tanggal_bayar;
        $bayar_pembelian->account_pembayar      = $request->account_pembayar;
        $bayar_pembelian->nominal_pembayaran           = $request->nominal_pembayaran;
        $bayar_pembelian->transaksi            = 'Bank Withdrawal';
        $bayar_pembelian->no_pembayaran      = $kode;
        $bayar_pembelian->keterangan      = $request->keterangan;
        $bayar_pembelian->creat_by           = Auth::user()->id;
        $bayar_pembelian->creat_by_company   = Auth::user()->pegawai->company->id;
        $savePembayaran = $bayar_pembelian->save();

        $idTagihanPembelian = DB::getPdo()->lastInsertId();



        if ($savePembayaran) {
            $idPembelian = $request->id_pembelian;
            $potongan = $request->sisa_tagihan2 - $request->nominal_pembayaran;
            if ($potongan > 0) {
                $update_Pembelian = Pembelian::query()->where('id', $idPembelian)->update(['sisa_tagihan'=>$potongan]);
            }else{
                $update_Pembelian = Pembelian::query()->where('id', $idPembelian)->update(['sisa_tagihan'=>0, 'status'=>2]);
            }
        }

        if ($update_Pembelian) {
            $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 3)->get();
            foreach ($get_rules_jurnal_entry as $grje) {
                $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
            }

            $jurnal_entri = new JurnalEntry();
            $jurnal_entri->transaksi_id       = $idTagihanPembelian;
            $jurnal_entri->account_id         = 10;
            $jurnal_entri->tanggal_transaksi       = $request->tanggal_bayar;
            $jurnal_entri->debit              = $request->nominal_pembayaran;
            $jurnal_entri->kredit             = 0;
            $jurnal_entri->category           = 2;
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
                AccountBank::query()->where('id', 10)->update(['saldo'=>$ahut->saldo + $request->nominal_pembayaran]);
            }

            $jurnal_entri2 = new JurnalEntry();
            $jurnal_entri2->transaksi_id       = $idTagihanPembelian;
            $jurnal_entri2->account_id         = $request->account_pembayar;
            $jurnal_entri2->tanggal_transaksi  = $request->tanggal_bayar;
            $jurnal_entri2->debit              = 0;
            $jurnal_entri2->kredit             = $request->nominal_pembayaran;
            $jurnal_entri2->category           = 2;
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
                AccountBank::query()->where('id', $request->account_pembayar)->update(['saldo'=>$akas->saldo - $request->nominal_pembayaran]);
            }
        }

        if ($saveJurnal) {
            $data = TagihanPembelian::findOrFail($idTagihanPembelian);
            return redirect()->route('showjurnal_pembelian', $data)->with(['success' => 'Pembayaran Berhasil']);
        } else {
            return redirect()->route('biaya.index')->with(['error' => 'Pembayaran Gagal']);
        }

    }

    public function delete_pembayaran_pembelian(Request $request, $id){
        $idPenjualan = $request->id_penjualan;
        $nominal_bayar = $request->nominal_bayar;

        $get_rules_jurnal_entry = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 2)->where('rules_jurnal_category_2', 3)->get();
            foreach ($get_rules_jurnal_entry as $grje) {
                $jurnal_debit_id = $grje->rules_jurnal_akun_debit;
            }

            $get_jurnal_hutang = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('account_id', $jurnal_debit_id)->where('category', 2)->where('tahapan', 2)->get();
            foreach ($get_jurnal_hutang as $jhutang) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $jhutang->id)->delete();
                $get_account_hutang = AccountBank::query()->where('id', 10)->get();
                foreach ($get_account_hutang as $ahutang) {
                    AccountBank::query()->where('id', 10)->update(['saldo'=>$ahutang->saldo - $jhutang->debit]);
                }
            }

            $get_jurnal_bayar = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('account_id', $request->account_bayar)->where('category', 2)->where('tahapan', 2)->get();
            foreach ($get_jurnal_bayar as $jbayar) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $jbayar->id)->delete();
                $get_account_bayar = AccountBank::query()->where('id', $request->account_bayar)->get();
                foreach ($get_account_bayar as $abayar) {
                    AccountBank::query()->where('id', $request->account_bayar)->update(['saldo'=>$abayar->saldo + $jbayar->kredit]);
                }
            }

            $get_pembelian = Pembelian::query()->where('id', $idPenjualan)->get();
            foreach ($get_pembelian as $gb) {
                Pembelian::query()->where('id', $idPenjualan)->update(['sisa_tagihan'=> $gb->sisa_tagihan + $nominal_bayar, 'status'=> 1 ]);
            }

            JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 2)->where('tahapan', 2)->delete();

            $msg = TagihanPembelian::where('id', $id)->delete();

            if ($msg) {
                return redirect()->route('pembelian.index')->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('pembelian.index')->with(['error' => 'Data Gagal Dihapus']);
            }
    }

}
