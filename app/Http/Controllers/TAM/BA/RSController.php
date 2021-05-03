<?php

namespace App\Http\Controllers\TAM\BA;

use Illuminate\Http\Request;
use App\Imports\RSImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\TAM\BA\RS;
use Auth;

class RSController extends Controller
{
    public function index(){
        $login = Auth::user();
        $data_rs = RS::OrderBy('nama_rs', 'ASC')
        ->where([['cabang_id','=',$login->cabang_id]])->get();
        return view('tam.ba.rs', compact('data_rs'));
    }



    public function store(Request $request){
        $login = Auth::user();
        $data_rs = new RS;
        $data_rs->nama_rs = $request->nama_rs;
        $data_rs->status = $request->status;
        $data_rs->cabang_id = $login->cabang_id;
        $data_rs->save();
        return redirect()->route('tam.ba.index')->with('success', 'Data Rumah Sakit berhasil ditambahkan');
    }

    public function import_excel(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('public/documents/import_rs',$nama_file);
 
		// import data
		Excel::import(new RSImport, public_path('/documents/import_rs/'.$nama_file));
 
		// notifikasi dengan session
		// Session::flash('sukses','Data Rumah Sakit Berhasil Diimport!');
 
		// alihkan halaman kembali
		return redirect('/tam/ba/data_rs')->with('success', 'Data Rumah Sakit berhasil diimport!');
	}

    public function update(Request $request, $id){
        $data_rs = RS::find($id);
        $data_rs->nama_rs = $request->nama_rs;
        $data_rs->status = $request->status;
        $data_rs->save();

        return redirect()->route('tam.ba.index')->with('success', 'Data Rumah Sakit berhasil diupdate');
    }

    public function destroy($id){
        $data_rs = RS::find($id);
        $data_rs->delete();

        return redirect()->route('tam.ba.index')->with('success', 'Data Rumah Sakit berhasil dihapus');
    }
}
