<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Divisi;

class DivisiController extends Controller
{
    public function index(){
        $divisis = Divisi::OrderBy('nama_divisi', 'ASC')->get();
        return view('master.divisi', compact('divisis'));
    }

    public function store(Request $request){
        $divisi = new Divisi;
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->status = $request->status;
        $divisi->save();

        return redirect()->route('divisi.index')->with('success', 'Data divisi berhasil ditambahkan');
    }

    public function update(Request $request, $id){
        $divisi = Divisi::find($id);
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->status = $request->status;
        $divisi->save();

        return redirect()->route('divisi.index')->with('success', 'Data divisi berhasil diupdate');
    }

    // public function destroy($id){
    //     $divisi = Divisi::find($id);
    //     $divisi->delete();

    //     return redirect()->route('divisi.index')->with('success', 'Data divisi berhasil dihapus');
    // }

}
