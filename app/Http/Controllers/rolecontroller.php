<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class rolecontroller extends Controller
{
    // role view
    function role(){
        $permissions = Permission::all();
        $roles = role::all();
        return view('admin.role.role', [
            'permissions'=>$permissions,  
            'roles'=>$roles,
        ]);
    }

    // add permission
    function add_permission(Request $request){
        Permission::create(['name' => $request->permission]);
        return back();
    }

    // role
    function add_role(Request $request){
        $role =Role::create(['name' => $request->role]);
        $role->givePermissionTo($request->permission);
        return back();
    }
    // role delete
    function permition_delete($role_id){
        $role = role::find($role_id)->delete();

        return back();
    }

    // user role view
    function user_role(){
        $users = User::all();
        $roles = role::all();
        return view('admin.role.user_role', [
            'users'=>$users,
            'roles'=>$roles,
        ]);
    }
    //user role store
    function user_role_store(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role_id);
        return back();
    }
    // user role remove
    function remove_role($user_id){
        $user = User::find($user_id);
        $user->syncPermissions([]);
        $user->syncRoles([]);
        return back();
    }
}
