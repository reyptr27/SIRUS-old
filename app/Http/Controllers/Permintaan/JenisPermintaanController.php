<?php

namespace App\Http\Controllers\Permintaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permintaan\Jenis_Permintaan;

class JenisPermintaanController extends Controller
{
    public function index(){
        $jenispermintaans = Jenis_Permintaan::OrderBy('kode', 'ASC')->get();
        return view('permintaan.jenispermintaan', compact('jenispermintaans'));
    }

    public function store(Request $request){
        $jenispermintaans = new Jenis_Permintaan;
        $jenispermintaans->kode = $request->kode;
        $jenispermintaans->spesifikasi = $request->spesifikasi;
        $jenispermintaans->status = $request->status;
        $jenispermintaans->save();

        return redirect()->route('jenispermintaan.index')->with('success', 'Data jenis permintaan berhasil ditambahkan');
    }

    public function update(Request $request, $id){
        $jenispermintaans = Jenis_Permintaan ::find($id);
        $jenispermintaans->kode = $request->kode;
        $jenispermintaans->spesifikasi = $request->spesifikasi;
        $jenispermintaans->status = $request->status;
        $jenispermintaans->save();

        return redirect()->route('jenispermintaan.index')->with('success', 'Data jenis permintaan berhasil diupdate');
    }

    public function destroy($id){
        $jenispermintaans = Jenis_Permintaan ::find($id);
        $jenispermintaans->delete();

        return redirect()->route('jenispermintaan.index')->with('success', 'Data jenis permintaan berhasil dihapus');
    }
}
