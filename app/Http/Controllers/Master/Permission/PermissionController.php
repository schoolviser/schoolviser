<?php

namespace App\Http\Controllers\Master\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Delgont\Auth\Models\Role;
use Delgont\Auth\Models\PermissionGroup;
use Delgont\Auth\Models\Permission;

class PermissionController extends Controller
{
    //

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'usertype:master'
        ]);
    }


    public function index()
    {
        $roles = Role::all();
        $permissionGroup = PermissionGroup::all();

        return view('.dashboard.master.roles.permissions.index', compact(['roles', 'permissionGroup']));
    }

    public function show($permission_group_id, $role_id)
    {
        $rolePermissionsArray = [];
        
        $permissionGroup =  PermissionGroup::whereId($permission_group_id)->with('permissions')->firstOrFail();

        $role = Role::with('permissions')->findOrFail($role_id);

        $rolePermissionsArray = collect($role->permissions)->map(function($permission, $index){
            return $permission->name;
        })->toArray();

        return view('dashboard.master.roles.permissions.show', compact(['role','permissionGroup','rolePermissionsArray']));
    }


    public function setPermissions(Request $request, $role_id, $permission_group_id)
    {
        $role = Role::findOrFail($role_id);

        $permissionsOfGroup =  Permission::whereHas('group', function($q) use($permission_group_id){
            $q->where('permission_group_id', $permission_group_id);
        })->get();

        $permissions = collect($permissionsOfGroup)->map(function($item, $key){
            return $item->id;
        });

        $role->permissions()->detach($permissions);

        $role->permissions()->where('role_id', $role_id)->syncWithOutDetaching($request->permissions);

        //($request->permissions) ? $role->permissions()->where('role_id', $role_id)->sync($request->permissions) : '';
        return back()->withInput();
    }
    
}
