<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\Cabang;
use App\User; use Auth;

class AccountController extends Controller
{
    public function approvalpic()
    {
        $login = Auth::user();
        $users = User::orderBy('created_at', 'DESC')->where('atasan_id','=',$login->id)->get();
        $karyawan = User::whereHas('roles', function($q){ 
            $q->where('name', 'PIC'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();
        
        $cabangs = Cabang::OrderBy('nama_cabang','ASC')->get();
        $departemens = Departemen::orderBy('nama_departemen','ASC')->get();

        return view('users.approvalpic', compact('users','karyawan','cabangs','departemens'));
    }

    public function updateapprovalpic(Request $request, $id)
    {
       
        $user = User::findOrFail($id);                   
        
        $user->jabatan  = $request->jabatan;      
        $user->name     = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->no_telp  = $request->no_telp;
        $user->cabang_id  = $request->cabang_id;
        $user->dept_id    = $request->departemen_id;
        $user->atasan_id  = $request->atasan_id;

        $user->save();
        return redirect(route('approvalpic'))->with(['success' => 'User ' . $user->name . ' berhasil diupdate']);
        // return $request->all();
    }

    public function approvepic(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->active = 2;         
        $user->save();

        return redirect(route('approvalpic'))->with(['success' => 'User ' . $user->name . ' Telah Diapprove']);
    }

    public function approvalcontroller()
    {
        // $login = Auth::user();
        $users = User::orderBy('updated_at', 'DESC')->where('name','!=','Admin')->get();
        $karyawan = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4']])->get();
        $cabangs = Cabang::OrderBy('nama_cabang','ASC')->get();
        $departemens = Departemen::orderBy('nama_departemen','ASC')->get();
        // return response()->json($karyawan);
        // if($users )
        return view('users.approvalcontroller', compact('users','karyawan','cabangs','departemens'));
    }

    
    public function approvecontroller(Request $request, $id)
    {
        $user = User::findOrFail($id);             
        $user->active = 3;        
        $user->save();
        return redirect(route('approvalcontroller'))->with(['success' => 'User ' . $user->name . ' Telah Diapprove']);
    }

    public function rejectcontroller(Request $request, $id)
    {
        $user = User::findOrFail($id);             
        $user->active = 1;        
        $user->save();
        return redirect()->back()->with(['success' => 'User ' . $user->name . ' Telah Direject']);
    }
}
