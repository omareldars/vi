<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Permission;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Requests\StorePermissionRequest;

class PermissionsController extends Controller
{
    public function index()
    {

        $this->preProcessingCheck('view_permissions');

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $this->preProcessingCheck('edit_permissions');

        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $this->preProcessingCheck('edit_permissions');
        $permission = Permission::create($request->all());
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('permissions.index');
    }

    public function edit(Permission $permission)
    {
        $this->preProcessingCheck('edit_permissions');
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $this->preProcessingCheck('edit_permissions');
        $permission->update($request->all());
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('permissions.index');
    }

    public function show(Permission $permission)
    {
        $this->preProcessingCheck('view_permissions');

        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        $this->preProcessingCheck('edit_permissions');
        $permission->delete();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return back();
    }

}
