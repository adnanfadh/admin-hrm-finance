<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Http\Requests\ShiftRequest;
use Yajra\DataTables\Facades\DataTables;

class ShiftController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:shift-list|shift-create|shift-edit|shift-delete', ['only' => ['index','store']]);
        $this->middleware('permission:shift-create', ['only' => ['create','store']]);
        $this->middleware('permission:shift-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:shift-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) { 
            $query = Shift::all();
            // dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return ' 
                        <div class="btn d-flex flex-row">
                                    <a class="btn btn-primary mr-2" href="' . route('shift.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('shift.destroy', $item->id) . '" method="POST">
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
            return view('pages.shift.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.shift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftRequest $request)
    {
        $data = $request->all();
        $data['hari_kerja'] = json_encode($request->input('hari_kerja'));
        $shift = Shift::create($data);

        if ($shift) {
            return redirect()->route('shift.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('shift.index')->with(['error' => 'Data Gagal Diupload']);
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
        $shift = Shift::findOrFail($id);
        $datas = $shift->hari_kerja;
        $dataku = json_decode($datas);
        // $min = explode(",", $datas);
        $d = count($dataku);
        // dd($dataku);

        return view('pages.shift.edit', [
            'shift'    => $shift,
            'dataku'      => $dataku,
            'd'     =>$d
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
        $item = Shift::findOrFail($id);

        $shift = $item->update($data);

        if ($shift) {
            return redirect()->route('shift.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('shift.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Shift::findOrFail($id);
        $shift = $item->delete();

        if ($shift) {
            return redirect()->route('shift.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('shift.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
