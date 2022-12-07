<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Bidang;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\JabatanRequest;


class JabatanController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:jabatan-list|jabatan-create|jabatan-edit|jabatan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:jabatan-create', ['only' => ['create','store']]);
         $this->middleware('permission:jabatan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jabatan-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) { 
            $query = Jabatan::all();
            // dd($query);
            $pesan = 'apakah yakinmau menghapus!';
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
                                    <a class="dropdown-item" href="' . route('jabatan.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('jabatan.destroy', $item->id) . '" method="POST">
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

        // $jabatan = Jabatan::query()->with(['bidang'])->get();
        // return response()->json($jabatan);
        return view('pages.jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JabatanRequest $request)
    {
        $data = $request->all();

        $jabatan = Jabatan::create($data);

        if ($jabatan) {
            return redirect()->route('jabatan.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('jabatan.index')->with(['error' => 'Data Gagal Diupload']);
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
        $jabatan = Jabatan::findOrFail($id);
        return view('pages.jabatan.edit', [
            'jabatan'    => $jabatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JabatanRequest $request, $id)
    {
        $data = $request->all();
        $item = Jabatan::findOrFail($id);

        $jabatan = $item->update($data);

        if ($jabatan) {
            return redirect()->route('jabatan.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('jabatan.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Jabatan::findOrFail($id);
        $jabatan = $item->delete();

        if ($jabatan) {
            return redirect()->route('jabatan.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('jabatan.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
