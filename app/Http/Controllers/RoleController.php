<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use DB;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = Role::orderBy('name', 'ASC')->get();
        return view('role.index', compact('role'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);
        
        //firstOrCreate agar tidak terdapat role duplicate
        $role = Role::firstOrCreate(['name' => $request->name]);
        return redirect()->back()->with(['success' => 'Role ' . $role->name . ' berhasil ditambahkan']);
    }

    public function update(Request $request, $id){
        $role = Role::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $role->name = $request->name;
        $role->save();
        return redirect()->back()->with(['success' => 'Role ' . $role->name . ' berhasil diupdate']);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        //hapus semua permission pada role
        for($i = count($role->permissions) ; $i > 0 ; $i--){
            $role->revokePermissionTo($role->permissions->first);
        }
        $role->delete();
        return redirect()->back()->with(['success' => 'Role ' . $role->name . ' berhasil dihapus']);
    }

    //Role-Permission
    public function rolePermissionList($id)
    {   
        $role   = Role::findOrFail($id);
        $permissions  = Permission::orderBy('name', 'ASC')->get();
        return view('role.permissionlist', compact('role','permissions'));
    }

    public function rolePermissionAdd(Request $request, $id)
    {  
        $role = Role::findOrFail($id);

        for($i = 0 ; $i < count($request->permission); $i++){
            $role->givePermissionTo($request->permission[$i]);
        }
        return redirect()->back()->with('success', 'Permission berhasil ditambahkan');
    }

    public function rolePermissionDelete(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->revokePermissionTo($request->permission);
        return redirect()->back()->with(['success' => 'Permission ' . $request->permission . ' berhasil dihapus dari '. $role->name ]);
    }

    //Role User
    public function roleUserList($id)
    {   
        $role   = Role::findOrFail($id);
        $users  = User::orderBy('name', 'ASC')->get();
        return view('role.userlist', compact('role','users'));
    }

    public function roleUserAdd(Request $request, $id)
    {  
        $role = Role::findOrFail($id);

        for($i = 0 ; $i < count($request->user_id); $i++){
            $user = User::where(['id' => $request->user_id[$i]])->first();
            $user->assignRole($role->name);
        }
        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function roleUserDelete(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $user = User::where(['id' => $request->user_id])->first();
        $user->removeRole($role->name);
        return redirect()->back()->with(['success' => 'User ' . $user->name . ' berhasil dihapus dari '. $role->name ]);
    }
}
