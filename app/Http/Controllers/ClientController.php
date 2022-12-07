<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Requests\ClientRequest;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:client-list|client-create|client-edit|client-delete', ['only' => ['index','store']]);
         $this->middleware('permission:client-create', ['only' => ['create','store']]);
         $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:client-delete', ['only' => ['destroy']]);
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
            $query = Client::query()->with(['user'])->get();
            // dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return ' 
                        <div class="btn d-flex flex-row">
                                    <a class="btn btn-primary mr-2" href="' . route('client.edit', $item->id) . '">
                                        Show
                                    </a>
                                    <form action="' . route('client.destroy', $item->id) . '" method="POST">
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
        return view('pages.client.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        return view('pages.client.create', [
            'user'  => $user
        ]);
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

        $msg = Client::create($data);

        if ($msg) {
            return redirect()->route('client.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('client.index')->with(['error' => 'Data Gagal Diupload']);
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
        $user = User::all();
        $client = Client::findOrFail($id);
        return view('pages.client.edit', [
            'user'  => $user,
            'client'  => $client
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
        $item = Client::findOrFail($id);

        $msg = $item->update($data);

        if ($msg) {
            return redirect()->route('client.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('client.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Client::findOrFail($id);
        $msg = $item->delete();

        if ($msg) {
            return redirect()->route('client.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('client.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
