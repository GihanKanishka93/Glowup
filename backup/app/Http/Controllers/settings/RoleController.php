<?php

namespace App\Http\Controllers\settings;


 
use Illuminate\Http\Request;
use App\DataTables\roleDataTable;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
          $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
          $this->middleware('permission:role-create', ['only' => ['create','store']]);
          $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
          $this->middleware('permission:role-delete', ['only' => ['destroy']]);
     }

    /**
     * Display a listing of the resource.
     */
    public function index(roleDataTable $dataTable)
    {
        return $dataTable->render('settings.role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::whereNull('deleted_at')->get();
        return view('settings.role.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            // 'display_name' => 'required|unique:roles', 
            'permission' => 'required|array',
        ]);
    
        $role = Role::create(['name' => $request->input('name'),'guard_name'=>'web']);
        $role->syncPermissions($request->input('permission'));    
        return redirect()->route('role.index')
                        ->with('success','role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(role $role)
    {
         
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$role->id)
            ->get();
    
        return view('settings.role.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(role $role)
    {
        $permissions = Permission::whereNull('deleted_at')->get();
        $rolePermissions = $role->Permissions()->pluck('id')->toArray();
        return view('settings.role.edit',compact('role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, role $role)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$role->id,
            'permission' => 'required|array',
        ]);
    
 
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('role.index')
                        ->with('message','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(role $role)
    {
     //   $role->deleted_by = Auth::user()->id.
    //    $role->save();
        $role->delete();
        return redirect()->route('role.index')->with('message','Role Deleted');
    }
}
