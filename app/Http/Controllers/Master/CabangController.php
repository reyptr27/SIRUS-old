<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;

class CabangController extends Controller
{
    public function index(){
        $cabangs = Cabang::OrderBy('nama_cabang', 'ASC')->get();
        return view('master.cabang', compact('cabangs'));
    }

    public function store(Request $request){
        $cabang = new Cabang;
        $cabang->nama_cabang = $request->nama_cabang;
        $cabang->kode_cabang = $request->kode_cabang;
        $cabang->status = $request->status;
        $cabang->save();

        return redirect()->route('cabang.index')->with('success', 'Data cabang berhasil ditambahkan');
    }

    public function update(Request $request, $id){
        $cabang = Cabang::find($id);
        $cabang->nama_cabang = $request->nama_cabang;
        $cabang->kode_cabang = $request->kode_cabang;
        $cabang->status = $request->status;
        $cabang->save();

        return redirect()->route('cabang.index')->with('success', 'Data cabang berhasil diupdate');
    }

    // public function destroy($id){
    //     $cabang = Cabang::find($id);
    //     $cabang->delete();

    //     return redirect()->route('cabang.index')->with('success', 'Data cabang berhasil dihapus');
    // }
}
