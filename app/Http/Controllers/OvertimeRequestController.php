<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LemburRequest;
use App\Models\Pegawai;
use Yajra\DataTables\Facades\DataTables;

class OvertimeRequestController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:overtime-list|overtime-create|overtime-edit|overtime-delete', ['only' => ['index','store']]);
         $this->middleware('permission:overtime-create', ['only' => ['create','store']]);
         $this->middleware('permission:overtime-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:overtime-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) { 
            // $query = Kebijakanhr::with(['pegawai'])->get();
            $query = Lembur::query()->with(['pegawai'])->where('pegawai_id', Auth::user()->pegawai->id)->get();
            // dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return ' 
                        <div class="btn d-flex flex-row">
                                    <a class="btn btn-primary mr-2" href="' . route('overtime.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('overtime.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                    </div>';
                })->addColumn('status', function ($item) {
                    if ($item->status_lembur == 0) {
                        // $show_data = "not verified";
                        $show_data = '<span class="badge bg-danger text-white">not verified</span>';
                    }elseif ($item->status_lembur == 1) {
                        // $show_data = "verified";
                        $show_data = '<span class="badge bg-warning text-white"> verified</span>';
                    }else{
                        // $show_data = "finished";
                        $show_data = '<span class="badge bg-success text-white"> finished</span>';
                    }
                    return ' 
                        <div class="btn d-flex flex-row">
                            ' . $show_data . '
                        </div>';
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make();
        }
            return view('pages.lembur.overtime.index');
        
        
        // return view('pages.lembur.overtime.index', [
        //     'overtime'      => $overtime
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.lembur.overtime.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['pegawai_id'] = Auth::user()->pegawai->id;
        $data['status_lembur'] = 0;

        $lembur = Lembur::create($data);

        if ($lembur) {
            return redirect()->route('overtime.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('overtime.index')->with(['error' => 'Data Gagal Diupload']);
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
        $overtime = Lembur::findOrFail($id);
        return view('pages.lembur.overtime.edit', [
            'overtime'    => $overtime
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
        $data = $request->all();
        $data['pegawai_id'] = Auth::user()->pegawai->id;
        $data['status_lembur'] = 0;

        $item = Lembur::findOrFail($id);

        $lembur = $item->update($data);

        if ($lembur) {
            return redirect()->route('overtime.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('overtime.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Lembur::findOrFail($id);
        $lembur = $item->delete();

        if ($lembur) {
            return redirect()->route('overtime.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('overtime.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
