<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarLainnyaController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:daftarlainnya-list', ['only' => ['index']]);
    }
    public function index(){
        return view('pages_finance.daftar_lainnya.index');
    }
}
