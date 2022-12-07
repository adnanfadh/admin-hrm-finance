<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountBank;
use App\Models\Finance\RulesJurnalInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RulesJurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            // $query = RulesJurnalInput::query()->with(['jurnal_akun_debit', 'jurnal_akun_kredit', 'jurnal_akun_discount', 'jurnal_akun_ppn'])->get();
            $query = RulesJurnalInput::query()->with(['jurnal_akun_debit', 'jurnal_akun_kredit', 'jurnal_akun_discount', 'jurnal_akun_ppn'])->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

            
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <a class="btn btn-primary" href="' . route('rulesJurnal.edit', $item->id) . '">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                Edit
                            </a>
                        </div>';
                })
                ->addColumn('rules_jurnal', function ($item) {
                    // rules jurnal category
                    // 1 -> Penjualan
                    // 2 -> Pembelian
                    // 3 -> Biaya
                    // 4 -> Kirim Uang
                    // 5 -> Terima Uang
                    // 6 -> Transfer Uang

                    if ($item->rules_jurnal_category == 1) {
                        return '<span class="badge badge-info">Penjualan</span>';
                    }elseif($item->rules_jurnal_category == 2){
                        return '<span class="badge badge-info">Pembelian</span>';
                    }elseif($item->rules_jurnal_category == 3){
                        return '<span class="badge badge-info">Biaya</span>';
                    }elseif($item->rules_jurnal_category == 4){
                        return '<span class="badge badge-info">Kirim Uang</span>';
                    }elseif($item->rules_jurnal_category == 5){
                        return '<span class="badge badge-info">Terima Uang</span>';
                    }else {
                        return '<span class="badge badge-info">Transfer Uang</span>';
                    }
                })
                ->addColumn('rules_debit', function ($item) {
                    if ($item->rules_jurnal_akun_debit == null) {
                        return '';
                    }else{
                        return $item->jurnal_akun_debit->nama;
                    }
                })
                ->addColumn('rules_kredit', function ($item) {
                    if ($item->rules_jurnal_akun_kredit == null) {
                        return '';
                    }else{
                        return $item->jurnal_akun_kredit->nama;
                    }
                })
                ->addColumn('rules_discount', function ($item) {
                    if ($item->rules_jurnal_akun_discount == null) {
                        return '';
                    }else{
                        return $item->jurnal_akun_discount->nama;
                    }
                })
                ->addColumn('rules_ppn', function ($item) {
                    if ($item->rules_jurnal_akun_ppn == null) {
                        return '';
                    }else{
                        return $item->jurnal_akun_ppn->nama;
                    }
                })
                ->rawColumns(['action', 'rules_jurnal', 'rules_debit', 'rules_kredit', 'rules_discount', 'rules_ppn'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages_finance.rules_jurnal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data = RulesJurnalInput::findOrFail($id);

        $account = AccountBank::all();

        return view('pages_finance.rules_jurnal.edit', [
            'data'  => $data,
            'account'   => $account
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

        $data = RulesJurnalInput::findOrFail($id);

        $item = $request->all();
        $item['creat_by'] = Auth::user()->id; 
        $item['creat_by_company'] = Auth::user()->pegawai->company->id;
        $update = $data->update($item);

        if ($update) {
            return redirect()->route('rulesJurnal.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else {
            return redirect()->route('rulesJurnal.index')->with(['error' => 'Data Gagal Diupdate']);
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
        //
    }
}
