<?php

namespace App\Http\Controllers\RoleManagement;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserRolesController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:userroles-list|userroles-create|userroles-edit|userroles-delete', ['only' => ['index','store']]);
         $this->middleware('permission:userroles-create', ['only' => ['create','store']]);
         $this->middleware('permission:userroles-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:userroles-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query = User::with(['pegawai'])->get();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <div class="row text-center d-flex flex-row">
                    <a class="btn btn-primary m-1" href="' . route('users.show', $item->id) . '">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </div>
                    ';
                })
                ->addColumn('action2', function ($item) {
                    if (!empty($item->getRoleNames())) {
                        for ($i=0; $i < $item->getRoleNames()->count() ; $i++) {
                            // foreach ($item->getRoleNames() as $key => $v) {
                                //     dd($key);
                                // }
                                $dataku =  '<label class="badge badge-success">'. json_decode($item->getRoleNames())[$i] .'</label>';
                                return json_decode($item->getRoleNames());
                            }
                    }
                })
                ->rawColumns(['action', 'action2'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages_role_management.users.index');
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $pegawais = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages_role_management.users.create', compact(['roles','pegawais']));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'pegawai_id' => 'required',
            // 'image.*'    => 'mimes:jpg,png,jpeg,gif,svg'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        if (!empty($request->photo)) {
            $input['photo'] = $request->file('photo')->store('assets/dokumen/userProfil', 'public');
        }

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        $pegawais = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages_role_management.users.show',compact(['user', 'pegawais']));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $pegawais = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();

        return view('pages_role_management.users.edit',compact('user','roles','userRole', 'pegawais'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
        if (!empty($request->photo)) {
            Storage::disk('local')->delete('public/'.$request->old_photo);
            $input['photo'] = $request->file('photo')->store('assets/dokumen/userProfil', 'public');
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

}
