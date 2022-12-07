<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\ProjectRequest;
use App\Models\Client;
use App\Models\Pegawai;
use App\Models\TaskProject;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index','store']]);
        $this->middleware('permission:project-create', ['only' => ['create','store']]);
        $this->middleware('permission:project-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Project::with(['client', 'pegawai'])->get();
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
                                    <a class="dropdown-item" href="' . route('project.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <a class="dropdown-item" href="' . route('project.show', $item->id) . '">
                                        Task Project
                                    </a>
                                    <form action="' . route('project.destroy', $item->id) . '" method="POST">
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
        return view('pages.project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        $client    = Client::all();
        return view('pages.project.create', [
            'pegawai'   => $pegawai,
            'client'    => $client
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
        $data['pegawai_id'] = json_encode($request->pegawai_id);

        $msg = Project::create($data);

        if ($msg) {
            return redirect()->route('project.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('project.index')->with(['error' => 'Data Gagal Diupload']);
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
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        $client    = Client::all();
        // $project = Project::findOrFail($id)->with(['client'])->get();
        $project = Project::with(['client'])->where('id', $id)->get();
        // dd($project);

        $task_project_0 = TaskProject::query()->where('status_task', 0)->where('project_id', $id)->get();
        $task_project_1 = TaskProject::query()->where('status_task', 1)->where('project_id', $id)->get();
        $task_project_2 = TaskProject::query()->where('status_task', 2)->where('project_id', $id)->get();
        return view('pages.project.task_project.index', [
            // 'pegawai'   => $pegawai,
            // 'client'    => $client,
            'project'   => $project,
            'task_project_0'   => $task_project_0,
            'task_project_1'   => $task_project_1,
            'task_project_2'   => $task_project_2,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        $client    = Client::all();
        $project    = Project::findOrFail($id);
        $datas = $project->pegawai_id;
        $dataku = json_decode($datas);
        // $min = explode(",", $datas);
        $dat = count($dataku);
        return view('pages.project.edit', [
            'pegawai'   => $pegawai,
            'client'    => $client,
            'project'   => $project,
            'dataku'    => $dataku,
            'dat'         => $dat
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
        $item = Project::findOrFail($id);

        $msg = $item->update($data);

        if ($msg) {
            return redirect()->route('project.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('project.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Project::findOrFail($id);
        $msg = $item->delete();

        if ($msg) {
            return redirect()->route('project.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('project.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
