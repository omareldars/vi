<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\StoreRoleRequest;

class RolesController extends Controller
{
    public function index()
    {
        $this->preProcessingCheck('view_roles');
        $roles = Role::with(['permissions'])->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->preProcessingCheck('manage_roles');
        $permissions = Permission::pluck('name', 'id');
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->preProcessingCheck('manage_roles');
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        $this->preProcessingCheck('manage_roles');
        $permissions = Permission::pluck('name', 'id');
        $role->load('permissions');
        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->preProcessingCheck('manage_roles');
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('roles.index');
    }

    public function show(Role $role)
    {
        $this->preProcessingCheck('view_roles');
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }

    public function destroy(Role $role)
    {
        $this->preProcessingCheck('manage_roles');
        $role->delete();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return back();
    }

}
