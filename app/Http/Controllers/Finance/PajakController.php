<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\PajakRequest;
use App\Models\Finance\Pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PajakController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:pajak-list|pajak-create|pajak-edit|pajak-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pajak-create', ['only' => ['create','store']]);
         $this->middleware('permission:pajak-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pajak-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $query = Pajak::all();
            $query = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            // dd($query);
            // $pesan = 'apakah yakinmau menghapus!';
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPajak">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePajak">Delete</a>';

                    return $btn;;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages_finance.pajak.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages_finance.pajak.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PajakRequest $request)
    {
        $msg = Pajak::updateOrCreate(['id' => $request->Pajak_id],
        ['nama_pajak' => $request->nama_pajak, 'persentase' => $request->persentase, 'creat_by'=> Auth::user()->id, 'creat_by_company'=> Auth::user()->pegawai->company->id]);

        if ($msg) {
            return response()->json(['success'=>'Data saved successfully!']);
            // return redirect()->route('metodepembayaran.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return response()->json(['error'=>'Data saved failed!']);
            // return redirect()->route('metodepembayaran.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = Pajak::findOrFail($id);
        return response()->json($data);

        // return view('pages_finance.pajak.edit', [
        //     'pajak' => $data
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PajakRequest $request, $id)
    {
        $data = $request->all();

        $item = Pajak::findOrFail($id);

        $msg = $item->update($data);

        if ($msg) {
            return redirect()->route('pajak.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else {
            return redirect()->route('pajak.index')->with(['error' => 'Data Gagal Diupdate']);
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
        $data = Pajak::findOrFail($id);

        $msg = $data->delete();

        if ($msg) {
            return response()->json(['success'=>'Customer deleted!']);
        }else {
            return response()->json(['error'=>'Customer deleted!']);
        }
    }
}
