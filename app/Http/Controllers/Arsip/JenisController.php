<?php

namespace App\Http\Controllers\Arsip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Arsip\Jenis_arsip;
use Auth;

class JenisController extends Controller
{
    public function index()
    {   
        $user = Auth::user();
        $role = $user->roles->pluck('name')->first();
        if($role == "Administrator"){
            $jenis = Jenis_arsip::orderBy('jenis_arsip', 'ASC')->get();
        }else{
            $jenis = Jenis_arsip::where(['dept_id' => $user->dept_id])->orderBy('jenis_arsip', 'ASC')->get();
        }  
        return view('arsip.jenis', compact('jenis'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'jenis_arsip' => 'required|string',
        ]);

        $jenis = new Jenis_arsip;
        $user = Auth::user();
        $jenis->jenis_arsip = $request->jenis_arsip;
        $jenis->status      = $request->status;
        $jenis->dept_id     = $user->dept_id;
        $jenis->created_by  = $user->id;
        $jenis->save();

        return redirect()->back()->with('success', $jenis->jenis_arsip.' berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $jenis = Jenis_arsip::findOrFail($id);
        $jenis->status      = $request->status;
        $jenis->save();

        return redirect()->back()->with('success', $jenis->jenis_arsip.' berhasil diupdate');
    }

    public function destroy($id)
    {
        $jenis = Jenis_arsip::findOrFail($id);
        $jenis->delete();
        return redirect()->back()->with('success', $jenis->jenis_arsip.' berhasil dihapus');
    }
}
