<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskProjectRequest;
use App\Models\TaskProject;
use Illuminate\Http\Request;

class TaskProjectController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:pegawai-list|pegawai-create|pegawai-edit|pegawai-delete', ['only' => ['index','store']]);
        $this->middleware('permission:task-create', ['only' => ['create','store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskProjectRequest $request)
    {
        $data = $request->all();
        $data['status_task'] = 0;

        $msg = TaskProject::create($data);

        if ($msg) {
            return redirect()->back()->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->back()->with(['error' => 'Data Gagal Diupload']);
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
        $taskproject = TaskProject::findOrFail($id);

        // return response()->json($task);
        return view('pages.project.task_project.edit', [
            'taskproject'   => $taskproject
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskProjectRequest $request, $id)
    {
        $data = $request->all();
        // dd($data);
        $item = TaskProject::findOrFail($id);

        $task = $item->update($data);

        if ($task) {
            return redirect()->route('project.show', $request->project_id )->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('project.show', $request->project_id)->with(['error' => 'Data Gagal Dirubah']);
        }
        // 'project'+ $request->project_id +'.show'
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = TaskProject::findOrFail($id);
        $msg = $item->delete();

        if ($msg) {
            return redirect()->back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->back()->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
