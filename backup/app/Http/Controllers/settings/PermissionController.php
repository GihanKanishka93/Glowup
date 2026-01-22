<?php

namespace App\Http\Controllers\settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DataTables\permissionDataTable;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(permissionDataTable $dataTable)
    {
        return $dataTable->render('settings.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:1|unique:permissions,name',
            'display_name'=>'required|min:1'
        ]);

        Permission::create([
            'guard_name'=>'web',
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'description'=>$request->description
        ]);
        return redirect()->route('permission.index')->with('message','Permission Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('settings.permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, permission $permission)
    {
        $request->validate([
            'name'=>'required|min:1|unique:permissions,name,'.$permission->id,
            'display_name'=>'required|min:1'
        ]);

        $permission->update([
            'guard_name'=>'web',
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'description'=>$request->description
        ]);
        return redirect()->route('permission.index')->with('message','Permission Created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->deleted_by = Auth::user()->id;
        $permission->save();
        $permission->delete();
        return redirect()->route('permission.index')->with('danger','Permission deleted');
    }
}
