<?php

namespace App\Http\Controllers;

use App\Http\Requests\KebijakanhrRequest;
use App\Models\Kebijakanhr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KebijakanhrController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:kebijakan-list|kebijakan-create|kebijakan-edit|kebijakan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kebijakan-create', ['only' => ['create','store']]);
         $this->middleware('permission:kebijakan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kebijakan-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) { 
            $query = Kebijakanhr::with(['pegawai'])->get();
            // dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return ' 
                        <div class="btn d-flex flex-row">
                                    <a class="btn btn-primary mr-2" href="' . route('kebijakanhr.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('kebijakanhr.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                    </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }
            return view('pages.hr.kebijakan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.hr.kebijakan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KebijakanhrRequest $request)
    {
        $data = $request->all();
        $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('assets/dokumen/kebijakanhr', 'public');
        $data['created_by'] = Auth::user()->id;

        $msg = Kebijakanhr::create($data);

        if ($msg) {
            return redirect()->route('kebijakanhr.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('kebijakanhr.index')->with(['error' => 'Data Gagal Diupload']);
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
        $kebijakanhr = Kebijakanhr::findOrFail($id);
        return view('pages.hr.kebijakan.edit', [
            'kebijakanhr'    => $kebijakanhr
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KebijakanhrRequest $request, $id)
    {
        if (!empty($request->dokumen_pendukung)) {
            $data = $request->all();
            
            Storage::disk('local')->delete('public/'. $request->dokumen_pendukung_lawas);

            $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('assets/dokumen/kebijakanhr', 'public');
            $data['created_by'] = Auth::user()->id;

            $item = Kebijakanhr::findOrFail($id);

            $kebijakanhr = $item->update($data);
            if ($kebijakanhr) {
                return redirect()->route('kebijakanhr.index')->with(['success' => 'Data Berhasil Dirubah']);
            } else {
                return redirect()->route('kebijakanhr.index')->with(['error' => 'Data Gagal Dirubah']);
            }
        }else{
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $item = Kebijakanhr::findOrFail($id);

            $msg = $item->update($data);

            if ($msg) {
                return redirect()->route('kebijakanhr.index')->with(['success' => 'Data Berhasil Dirubah']);
            } else {
                return redirect()->route('kebijakanhr.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Kebijakanhr::findOrFail($id);
        $file = $item->dokumen_pendukung;
        // dd($file);
        $hay = Storage::disk('local')->delete('public/'.$file);
        // dd($hay);
        $msg = $item->delete();

        if ($msg) {
            return redirect()->route('kebijakanhr.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('kebijakanhr.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
