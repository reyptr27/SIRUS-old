<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::orderBy('name', 'ASC')->get();
        return view('permission.index', compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);
        
        //firstOrCreate agar tidak terdapat permission duplicate
        $permission = Permission::firstOrCreate(['name' => $request->name]);
        return redirect()->back()->with(['success' => 'Permission ' . $permission->name . ' berhasil ditambahkan']);
    }

    public function update(Request $request, $id){
        $permission = Permission::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $permission->name = $request->name;
        $permission->save();
        return redirect()->back()->with(['success' => 'Permission ' . $permission->name . ' berhasil diupdate']);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->back()->with(['success' => 'Permission ' . $permission->name . ' berhasil dihapus']);
    }

    //Permission-Role
    public function permissionRoleList($id)
    {   
        $permission   = Permission::findOrFail($id);
        $roles  = $permission->roles()->get();
        $roleall = Role::orderBy('name', 'asc')->get();
        return view('permission.rolelist', compact('roles','permission','roleall'));
    }

    public function permissionRoleAdd(Request $request, $id)
    {  
        $permission = Permission::findOrFail($id);

        for($i = 0 ; $i < count($request->role); $i++){
            $role = Role::where(['name' => $request->role[$i]])->first();
            $role->givePermissionTo($permission->name);
        }
        return redirect()->back()->with('success', 'Permission berhasil ditambahkan pada Role');
    }

    public function permissionRoleDelete(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $role = Role::where(['name' => $request->role])->first();
        $role->revokePermissionTo($permission->name);
        return redirect()->back()->with(['success' => 'Permission ' . $permission->name . ' berhasil dihapus dari '. $role->name ]);
    }

    //Permission User
    public function permissionUserList($id)
    {   
        $permission   = Permission::findOrFail($id);
        $userall  = User::orderBy('name', 'ASC')->get();
        $users = $permission->users()->get();
        return view('permission.userlist', compact('permission','userall','users'));
    }

    public function permissionUserAdd(Request $request, $id)
    {  
        $permission   = Permission::findOrFail($id);

        for($i = 0 ; $i < count($request->user_id); $i++){
            $user = User::where(['id' => $request->user_id[$i]])->first();
            $user->givePermissionTo($permission->name);
        }
        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function permissionUserDelete(Request $request, $id)
    {
        $permission   = Permission::findOrFail($id);
        $user = User::where(['id' => $request->user_id])->first();
        $user->revokePermissionTo($permission->name);
        return redirect()->back()->with(['success' => 'Permission ' . $permission->name . ' berhasil dihapus dari user '. $user->name ]);
    }
}
