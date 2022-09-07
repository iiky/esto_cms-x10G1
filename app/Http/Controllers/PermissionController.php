<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('Permission Access'), 403);
        $this->data['permissions'] = Permission::all();
        
        return view('permission.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('Permission Create'), 403);

        $this->data['permissiongroups'] = PermissionGroup::all();   

        $this->data['action'] = "/permission";
        return view('permission.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        abort_if(Gate::denies('Permission Create'), 403);

        Permission::create($request->all());

        return redirect('/permission')->with('success', 'New permission has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('Permission Update'), 403);

        $this->data['permissiongroups'] = PermissionGroup::all(); 

        $this->data['permission_data'] = $permission;
        $this->data['action'] = "/permission/".$permission->id;
        return view('permission.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        abort_if(Gate::denies('Permission Update'), 403);

        Permission::find($permission->id)
            ->update($request->all());

        return redirect('/permission')->with('success', 'Permission has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('Permission Delete'), 403);

        Permission::destroy($permission->id);
        return redirect('/permission')->with('success', 'Permission has been deleted!');
    }
}
