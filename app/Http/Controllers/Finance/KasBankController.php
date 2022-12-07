<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountBank;
use App\Models\Finance\KirimUang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KasBankController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:kasbank-list', ['only' => ['index']]); 
   }

   public function index()
    {
        if (request()->ajax()) {
            $query = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['pajak', 'category_account'])->where('category', 3)->where('nama_bank', '=', null)->get();
            
            return DataTables::of($query)
            ->addColumn('saldo', function($item){
                $data = number_format($item->saldo,2,',','.');
                return $data;
            })
            ->rawColumns(['saldo'])
            ->addIndexColumn()
            ->make();
        }

        return view('pages_finance.kas&bank.index');
    }


    public function bank(){
        if (request()->ajax()) {
            $query = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['pajak', 'category_account'])->where('category', 3)->where('nama_bank', '!=', null)->get();
            
            return DataTables::of($query)
            ->addColumn('saldo', function($item){
                $data = number_format($item->saldo,2,',','.');
                return $data;
            })
            ->rawColumns(['saldo'])
            ->addIndexColumn()
            ->make();
        }
    }
}
