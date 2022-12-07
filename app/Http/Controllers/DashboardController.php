<?php

namespace App\Http\Controllers;

use App\Models\Finance\Penjualan;
use App\Models\Finance\TagihanPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peserta;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Gaji;

class DashboardController extends Controller
{
    public function index(){
        //dashboard hrd-dti
        $pegawai = Pegawai::count();
        $gaji = Gaji::with('pegawai')->take(10)->latest()->get();
        $title = "Dashboard";

        return view('dashboard',[
            'pegawai'   => $pegawai,
            'gaji'      => $gaji,
            'title'     => $title
        ]);
    }
    public function signout(){
        Auth::logout();
        return redirect('/login');
    }

    
}

// Reservation::whereBetween('reservation_from', [$from, $to])->get();
