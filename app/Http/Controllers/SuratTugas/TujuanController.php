<?php

namespace App\Http\Controllers\SuratTugas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Surattugas\Tujuan_st;

class TujuanController extends Controller
{
    public function index()
    {
        $tujuans = Tujuan_st::where(['status' => 1])->orderBy('nama_tujuan', 'ASC')->get();
        return view('surat_tugas.tujuan', compact('tujuans'));
    }

    public function store(Request $request){
        $tujuan = new Tujuan_st;
        $tujuan->nama_tujuan = $request->nama_tujuan;
        $tujuan->status = $request->status;
        $tujuan->save();

        return redirect()->back()->with('success', $tujuan->nama_tujuan.' berhasil ditambahkan');
    }

    public function update(Request $request, $id){
        $tujuan = Tujuan_st::find($id);
        $tujuan->nama_tujuan = $request->nama_tujuan;
        $tujuan->status = $request->status;
        $tujuan->save();

        return redirect()->back()->with('success', $tujuan->nama_tujuan.' berhasil diupdate');
    }

    public function destroy($id){
        $tujuan = Tujuan_st::find($id);
        $tujuan->delete();

        return redirect()->back()->with('success', $tujuan->nama_tujuan.' berhasil dihapus');
    }
}
