<?php

namespace App\Http\Controllers\BaGudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Beritaacara\Ba_Gudang_Alamat;
use Auth;

class AlamatController extends Controller
{
    public function index(){
        $alamats = Ba_Gudang_Alamat::OrderBy('nama_gudang', 'ASC')->get();
        return view('ba_gudang.alamatgudang', compact('alamats'));
    }

    public function store(Request $request){
        $alamats = new Ba_Gudang_Alamat;
        $alamats->nama_gudang = $request->nama_gudang;
        $alamats->alamat = $request->alamat;
        $alamats->status = $request->status;
        $alamats->save();

        return redirect()->route('alamatgudang.index')->with('success', 'Data Alamat Gudang berhasil ditambahkan');
    }

    public function update(Request $request, $id){
        $alamats = Ba_Gudang_Alamat ::find($id);
        $alamats->nama_gudang = $request->nama_gudang;
        $alamats->alamat = $request->alamat;
        $alamats->status = $request->status;
        $alamats->save();

        return redirect()->route('alamatgudang.index')->with('success', 'Data Alamat Gudang berhasil diupdate');
    }

    public function destroy($id){
        $alamats = Ba_Gudang_Alamat ::find($id);
        $alamats->delete();

        return redirect()->route('alamatgudang.index')->with('success', 'Data Alamat Gudang berhasil dihapus');
    }
}
