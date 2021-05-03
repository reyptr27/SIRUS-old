<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use App\User;
use App\Models\Cabang;
use App\Models\Departemen;
use Image;
use File;
use Carbon\Carbon; use Auth; use DB;

class UserController extends Controller
{
    public function json()
    {
        $users = DB::table('users')
            ->leftJoin('m_cabang', 'm_cabang.id', '=', 'users.cabang_id')
            ->leftJoin('m_departemen', 'm_departemen.id', '=', 'users.dept_id')
            ->leftJoin('users as atasan', 'atasan.id', '=', 'users.atasan_id')
            ->select([
                'users.id','users.name', 'users.nik','users.email','users.jabatan','users.username',
                'users.no_telp','users.cabang_id','m_cabang.nama_cabang','m_cabang.kode_cabang',
                'users.dept_id','m_departemen.nama_departemen','m_departemen.kode_departemen','users.atasan_id',
                'atasan.name as nama_atasan','users.active','users.image','users.created_at','users.updated_at'
            ])
        ->get(); 
    
        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('image', function ($users){
                if($users->image == null){
                    $url=asset("images/profile/default-profile.jpg"); 
                    return '<img src='.$url.' width="75" height="75" >';
                }else{
                    $url=asset("images/profile/$users->image"); 
                    return '<img src='.$url.' width="75" height="75" >';
                }
            })
            ->editColumn('kode_cabang', function ($users){
                if($users->kode_cabang == null){
                    return '<label class="label label-warning">Belum Diset</label>';
                }else{
                    return $users->kode_cabang;
                }
            })
            ->editColumn('kode_departemen', function ($users){
                if($users->kode_departemen == null){
                    return '<label class="label label-warning">Belum Diset</label>';
                }else{
                    return $users->kode_departemen;
                }
            })
            ->editColumn('created_at', function ($users){
                return date('d-m-Y', strtotime($users->created_at) );
            })
            ->editColumn('active', function ($users){
                if($users->active == 5){
                    return "<label for='' class='label label-danger'>Non-Aktif</label>";
                }else if($users->active == 4){
                    return "<label for='' class='label label-success'>Aktif</label>";
                }else if($users->active == 3){
                    return "<label for='' class='label label-info'>Diapprove Controller</label>";
                }else if($users->active == 2){
                    return "<label for='' class='label label-warning'>Diapprove PIC</label>";
                }else{
                    return "<label for='' class='label label-warning'>Belum Diapprove</label>";
                }
            })
            ->addColumn('action', 'users.datatables.action')
            ->addColumn('kol-role', 'users.datatables.role')
            ->rawColumns(['action','kol-role'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }
       
    public function index()
    {
        $users = User::orderBy('name', 'ASC')->get();
        $cabangs = Cabang::OrderBy('nama_cabang','ASC')->get();
        $departemens = Departemen::orderBy('nama_departemen','ASC')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $role = Role::orderBy('name', 'ASC')->get();
        $users = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4']])->get();
        $cabangs = Cabang::OrderBy('nama_cabang','ASC')->get();
        $departemens = Departemen::orderBy('nama_departemen','ASC')->get();
        return view('users.create', compact('role','cabangs','departemens','users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'jabatan' => 'nullable|string',
            'nik'    => 'required|string|unique:users',
            'cabang_id'  => 'nullable|string',
            'dept_id'    => 'nullable|string',
            'atasan_id'  => 'nullable|string'
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->nik      = $request->nik;
        $user->jabatan  = $request->jabatan;
        $user->no_telp  = $request->no_telp;
        $user->cabang_id= $request->cabang_id;
        $user->dept_id  = $request->departemen_id;
        $user->atasan_id= $request->atasan_id;
        $user->active   = $request->active; 
        
        if($request->file){
            $file = $request->file('file');
            $ekstensi = $file->getClientOriginalExtension();
            $nama_file  = $request->nik.'.'.$ekstensi; 
            $file_resize = Image::make($file->getRealPath());
            $file_resize->resize(215,215);
            $file_resize->save(public_path('images/profile/'.$nama_file));
            $user->image = $nama_file;
        }
        $user->save();
        $user->assignRole('User');

        return redirect(route('users.index'))->with(['success' => 'User ' . $user->name . ' berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $karyawan = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4']])->get();
        $cabangs = Cabang::OrderBy('nama_cabang','ASC')->get();
        $departemens = Departemen::orderBy('nama_departemen','ASC')->get();
        return view('users.edit', compact('user','karyawan','cabangs','departemens'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'nik'    => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        
        $password = !empty($request->password) ? bcrypt($request->password):$user->password;
        
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->password = $password;
        $user->nik      = $request->nik;
        $user->jabatan  = $request->jabatan;
        $user->no_telp  = $request->no_telp;
        $user->cabang_id= $request->cabang_id;
        $user->dept_id  = $request->departemen_id;
        $user->atasan_id= $request->atasan_id;
        $user->active   = $request->active;

        // if($request->file){
        //     if(!empty($user->image)){
        //         File::delete('public/images/profile/'.$user->image);
        //     }

        //     $file = $request->file('file');
        //     $ekstensi = $file->getClientOriginalExtension();
        //     $nama_file  = $request->nik.'.'.$ekstensi; 
        //     $file_resize = Image::make($file->getRealPath());
        //     $file_resize->resize(215,215);
        //     $file_resize->save(public_path('images/profile/'.$nama_file));
            
        //     $user->image = $nama_file;
        // }

        $user->save();
        return redirect(route('users.index'))->with(['success' => 'User ' . $user->name . ' berhasil diupdate']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        //hapus foto profil
        if(!empty($user->image)){
            File::delete('public/images/profile/'.$user->image);
        }
        //hapus semua role user
        for($i = count($user->roles) ; $i > 0 ; $i--){
            $user->removeRole($user->roles->first());
        }
        //hapus semua permisi user
        for($i = count($user->permissions) ; $i > 0 ; $i--){
            $user->revokePermissionTo($user->permissions->first);
        }

        $user->delete();
        return redirect()->back()->with(['success' => 'User ' . $user->name . ' berhasil dihapus']);
    }

    //User-Role
    public function userRoleList($id)
    {   
        $user   = User::findOrFail($id);
        $roles  = Role::orderBy('name', 'ASC')->get();
        return view('users.rolelist', compact('user','roles'));
    }

    public function userRoleAdd(Request $request, $id)
    {  
        $user = User::findOrFail($id);

        for($i = 0 ; $i < count($request->role); $i++){
            $user->assignRole($request->role[$i]);
        }
        return redirect()->back()->with('success', 'Role berhasil ditambahkan');
    }

    public function userRoleDelete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->removeRole($request->role);
        return redirect()->back()->with(['success' => 'Role ' . $request->role . ' berhasil dihapus dari '. $user->name ]);
    }

    //User-Permission
    public function userPermissionList($id)
    {   
        $user   = User::findOrFail($id);
        $permissions  = Permission::orderBy('name', 'ASC')->get();
        return view('users.permissionlist', compact('user','permissions'));
    }

    public function userPermissionAdd(Request $request, $id)
    {  
        $user = User::findOrFail($id);

        for($i = 0 ; $i < count($request->permission); $i++){
            $user->givePermissionTo($request->permission[$i]);
        }
        return redirect()->back()->with('success', 'Permission berhasil ditambahkan');
    }

    public function userPermissionDelete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->revokePermissionTo($request->permission);
        return redirect()->back()->with(['success' => 'Permission ' . $request->permission . ' berhasil dihapus dari '. $user->name ]);
    }

}
