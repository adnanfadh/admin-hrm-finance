<?php

namespace App\Http\Controllers\RoleManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:rolesManagement-list|rolesManagement-create|rolesManagement-edit|rolesManagement-delete', ['only' => ['index','store']]);
         $this->middleware('permission:rolesManagement-create', ['only' => ['create','store']]);
         $this->middleware('permission:rolesManagement-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:rolesManagement-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request) 
    {
            // if (request()->ajax()) {
            //     $query = Role::orderBy('id','DESC')->get();
            //     return DataTables::of($query)
            //         ->addColumn('action', function ($item) {
            //             return '
            //             <div class="row text-center d-flex flex-row">
            //                 <a class="btn btn-primary m-1" href="' . route('roles.show', $item->id) . '">
            //                     <i class="fa fa-eye" aria-hidden="true"></i>
            //                 </a>    
            //             </div>
            //             ';
            //         })
            //         ->addColumn('names', function ($item) {
            //             foreach ($item as $key => $role) {
            //                 return $item->name;
            //             }
            //         })
            //         ->rawColumns(['action'])
            //         ->addIndexColumn()
            //         ->make();
            // }
            // return view('pages_role_management.roles.index');

            $roles = Role::orderBy('id','DESC')->paginate(5);
            return view('pages_role_management.roles.index',compact('roles'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }

    public function create()
    {
        $permission = Permission::get();
        $list = 'list';
        $create = 'create';
        $edit = 'edit';
        $delete = 'delete';
        $permission_list = Permission::query()->where('name','LIKE','%'. $list .'%')->get();
        $permission_create = Permission::query()->where('name','LIKE','%'. $create .'%')->get();
        $permission_edit = Permission::query()->where('name','LIKE','%'. $edit .'%')->get();
        $permission_delete = Permission::query()->where('name','LIKE','%'. $delete .'%')->get();

        return view('pages_role_management.roles.create',compact('permission','permission_list','permission_create','permission_edit', 'permission_delete'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    // public function show($id)
    // {
    //     $role = Role::find($id);
    //     $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
    //         ->where("role_has_permissions.role_id",$id)
    //         ->get();
    
    //     return view('roles.show',compact('role','rolePermissions'));
    // }

    public function edit($id)
    {

        $list = 'list';
            $create = 'create';
            $edit = 'edit';
            $delete = 'delete';

        $role = Role::find($id);
        $permission = Permission::get();
        $role_permission_list = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        $role_permission_create = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        $role_permission_edit = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        $role_permission_delete = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

            
            $permission_list = Permission::query()->where('name','LIKE','%'. $list .'%')->get();
            $permission_create = Permission::query()->where('name','LIKE','%'. $create .'%')->get();
            $permission_edit = Permission::query()->where('name','LIKE','%'. $edit .'%')->get();
            $permission_delete = Permission::query()->where('name','LIKE','%'. $delete .'%')->get();
    
        return view('pages_role_management.roles.edit',compact('role','permission', 'permission_list', 'permission_create', 'permission_edit', 'permission_delete', 'role_permission_list', 'role_permission_create', 'role_permission_edit', 'role_permission_delete'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
