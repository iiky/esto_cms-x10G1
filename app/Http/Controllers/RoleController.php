<?php

namespace App\Http\Controllers;

use App\Traits\RolesAuthorizable;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\PermissionGroup;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use RolesAuthorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['roles'] = Role::all();

        return view('role.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['action'] = route('role.store');
        return view('role.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create($request->all());

        return redirect()->route('role.index')->with('success', 'New role has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->data['action'] = route('role.showaction',$role->id);
        $this->data['permission_groups'] = PermissionGroup::whereNull('permission_group_id')->get();
        $this->data['permissions'] = Permission::whereNull('permission_group_id')->get();

        $this->data['role'] = $role;

        return view('role.permission', $this->data);
    }

    public function showaction(Request $request, Role $role)
    {
        $rawPermissions = $request->input('permission');
        $permission_array = !empty($rawPermissions) ? array_filter(explode(',', $rawPermissions)) : [];

        $permissions = Permission::whereIn('id', $permission_array)->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('role.index')->with('success', 'Permission has been updated!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->data['role_data'] = $role;
        $this->data['action'] = route('role.update',$role->id);
        return view('role.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return redirect()->route('role.index')->with('success', 'Role has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()->route('role.index')->with('error', 'Role Super Admin tidak dapat dihapus!');
        }

        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role has been deleted!');
    }
}
