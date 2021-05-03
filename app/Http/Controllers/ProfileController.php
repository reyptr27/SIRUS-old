<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Models\Departemen;
use App\Models\Cabang;
use App\User;
use Image; use File; use Carbon\Carbon; use DataTables; use Validator; use Hash; use Auth;

class ProfileController extends Controller
{
    public function edit($id)
    {
        $user = User::find($id);
        $karyawan = User::orderBy('name', 'ASC')->get();
        $cabangs = Cabang::OrderBy('nama_cabang','ASC')->get();
        $departemens = Departemen::orderBy('nama_departemen','ASC')->get();
        return view('users.editprofile', compact('user','karyawan','cabangs','departemens'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        
        $user->name = $request->name;
        $user->email    = $request->email;
        $user->jabatan  = $request->jabatan;
        $user->no_telp  = $request->no_telp;

        // if($request->file){
        //     if(!empty($user->image)){
        //         File::delete('public/images/profile/'.$user->image);
        //     }

        //     $file = $request->file('file');
        //     $ekstensi = $file->getClientOriginalExtension();
        //     $nama_file  = $user->nik.'.'.$ekstensi; 
        //     $file_resize = Image::make($file->getRealPath());
        //     // $file_resize->resize(215,215);
        //     $file_resize->save(public_path('images/profile/'.$nama_file));
            
        //     $user->image = $nama_file;
        // }

        $user->save();
        return redirect(route('dashboard'))->with(['success' => 'Data profile ' . $user->name . ' berhasil diupdate']);
    }

    public function imageUpload(Request $request, $id)
    {   
        $user = User::findOrFail($id);
        
        if($request->ajax())
        {   
            if(!empty($user->image)){
                File::delete('public/images/profile/'.$user->image);
            }
            $image_data     = $request->image;
            $image_array_1  = explode(";", $image_data);
            $image_array_2  = explode(",", $image_array_1[1]);
            $data           = base64_decode($image_array_2[1]);
            $image_name     = time().'.png';
            $user->image    = $image_name;
            $user->save();
            
            $upload_path    = public_path().'/images/profile/'.$image_name;
            file_put_contents($upload_path, $data);
            
            // return response()->json(['path' => 'public/images/profile/' . $image_name]);
            return response()->json([
                'status' => 'success',
                'path' => '/images/profile/'.$image_name
            ]);
        }
    }
    
    public function editPassword($id){
        $user = User::find($id);
        return view('users.password', compact('user'));
    }

    public function updatePassword()
    {
         // custom validator
         Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, \Auth::user()->password);
        });
 
        // pesan validasi
        $messages = [
            'password' => 'Password lama salah.',
        ];
 
        // validasi form
        $validator = Validator::make(request()->all(), [
            'current_password'      => 'required|password',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
 
        ], $messages);
 
        // jika validasi error
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }
 
        // update password
        $user = User::find(Auth::id());
 
        $user->password = bcrypt(request('password'));
        $user->save();
 
        return redirect()
            ->route('profile.edit',$user->id)
            ->withSuccess('Password berhasil diupdate');
    
    }
}
