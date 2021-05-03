<?php

namespace App\Http\Controllers\CAPA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CAPA\Lokasi;

class LokasiController extends Controller
{
    public function index(){
        $lokasis = Lokasi::OrderBy('lokasi', 'ASC')->get();
        return view('capa.lokasi', compact('lokasis'));
    }

    public function store(Request $request){
        $lokasi = new Lokasi;
        $lokasi->lokasi = $request->lokasi;
        $lokasi->alamat = $request->alamat;
        $lokasi->status = $request->status;
        $lokasi->save();

        return redirect()->route('capa.lokasi.index')->with('success', $lokasi->lokasi.' berhasil ditambahkan');
    }

    public function update(Request $request, $id){
        $lokasi = Lokasi::find($id);
        $lokasi->lokasi = $request->lokasi;
        $lokasi->alamat = $request->alamat;
        $lokasi->status = $request->status;
        $lokasi->save();

        return redirect()->route('capa.lokasi.index')->with('success', $lokasi->lokasi.' berhasil diupdate');
    }

    public function destroy($id){
        $lokasi = Lokasi::find($id);
        $lokasi->delete();

        return redirect()->route('capa.lokasi.index')->with('success', $lokasi->lokasi.' berhasil dihapus');
    }
}
