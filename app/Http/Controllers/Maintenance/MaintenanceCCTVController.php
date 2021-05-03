<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\Maintenance_cctv;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;


class MaintenanceCCTVController extends Controller
{
    public function index(){
        $mt_cctv = Maintenance_cctv::OrderBy('no_document', 'ASC')->get();
        $officers = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4'],['dept_id','=','1']])->get();
        
        return view('maintenance.cctv.index', compact('mt_cctv','officers'));
    }



    public function store(Request $request){
        
        $this->validate($request, [
            
            'nama_server' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'tanggal' => 'required|date',            
            
           
        ]);
        $nomorterakhir = Maintenance_cctv::Orderby('created_at','DESC')->first();
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        
        $mt_cctv = new Maintenance_cctv;

        if($nomorterakhir == null){
            $hasil = "1";

        }else{
            $nomor = $nomorterakhir->no_document;
            $pisah = explode('/',$nomor);

            if((int)$pisah[3] > 0 && $pisah[1] != date('Y')){
                $hasil='1';
            }else{
                $hasil=(int)$pisah[3]+1;

            }
        }

        $datano = sprintf("%04s" , $hasil);
        $nomordocument = "MT-CCTV/".date('Y')."/".$bulanRomawi[date('n')]."/".$datano;

        $mt_cctv->no_document = $nomordocument;
        $mt_cctv->nama_server = $request->nama_server;
        $mt_cctv->lokasi = $request->lokasi;
        $mt_cctv->officer_id = $request->officer_id;
        $mt_cctv->tanggal = $request->tanggal;
        $mt_cctv->status = $request->status;
        // $mt_cctv->atasan = $request->atasan;
        $mt_cctv->catatan = $request->catatan;
        $mt_cctv->status1 = $request->status1;
        $mt_cctv->tindakan1 = $request->tindakan1;
        $mt_cctv->status2 = $request->status2;
        $mt_cctv->tindakan2 = $request->tindakan2;
        $mt_cctv->status3 = $request->status3;
        $mt_cctv->tindakan3 = $request->tindakan3;
        $mt_cctv->status4 = $request->status4;
        $mt_cctv->tindakan4 = $request->tindakan4;
        $mt_cctv->status5 = $request->status5;
        $mt_cctv->tindakan5 = $request->tindakan5;
        $mt_cctv->status6 = $request->status6;
        $mt_cctv->tindakan6 = $request->tindakan6;
        $mt_cctv->status7 = $request->status7;
        $mt_cctv->tindakan7 = $request->tindakan7;
        $mt_cctv->status8 = $request->status8;
        $mt_cctv->tindakan8 = $request->tindakan8;
        $mt_cctv->status9 = $request->status9;
        $mt_cctv->tindakan9 = $request->tindakan9;
        $mt_cctv->status10 = $request->status10;
        $mt_cctv->tindakan10 = $request->tindakan10;

        $mt_cctv->save();

        return redirect()->route('maintenance_cctv.index')->with('success','Data Maintenance CCTV Berhasil ditambahkan');

    }

    public function update(Request $request, $id){

        $mt_cctv = Maintenance_cctv::find($id);
        $users = User::orderBy('created_at', 'DESC')->where(['id' => $mt_cctv->officer_id ])->get();
        // $mt_cctvs->nomor_document = $request->nomor_document;
        $mt_cctv->nama_server = $request->nama_server;
        $mt_cctv->lokasi = $request->lokasi;
        $mt_cctv->officer_id = $request->officer_id;
        $mt_cctv->tanggal = $request->tanggal;
        $mt_cctv->status = $request->status;
        // $mt_cctv->atasan = $request->atasan;
        $mt_cctv->catatan = $request->catatan;
        $mt_cctv->status1 = $request->status1;
        $mt_cctv->tindakan1 = $request->tindakan1;
        $mt_cctv->status2 = $request->status2;
        $mt_cctv->tindakan2 = $request->tindakan2;
        $mt_cctv->status3 = $request->status3;
        $mt_cctv->tindakan3 = $request->tindakan3;
        $mt_cctv->status4 = $request->status4;
        $mt_cctv->tindakan4 = $request->tindakan4;
        $mt_cctv->status5 = $request->status5;
        $mt_cctv->tindakan5 = $request->tindakan5;
        $mt_cctv->status6 = $request->status6;
        $mt_cctv->tindakan6 = $request->tindakan6;
        $mt_cctv->status7 = $request->status7;
        $mt_cctv->tindakan7 = $request->tindakan7;
        $mt_cctv->status8 = $request->status8;
        $mt_cctv->tindakan8 = $request->tindakan8;
        $mt_cctv->status9 = $request->status9;
        $mt_cctv->tindakan9 = $request->tindakan9;
        $mt_cctv->status10 = $request->status10;
        $mt_cctv->tindakan10 = $request->tindakan10;
        $mt_cctv->save();

        return redirect()->route('maintenance_cctv.index')->with('success','Data Maintenance CCTV Berhasil diupdate');
        // return response()->json($mt_cctv);
    }

    public function autofill($id){
        $users = User::find($id);
        // $users = User::orderBy('created_at', 'DESC')->where(['id' => $request->officer_id ])->get();
        // $atasan = $users->atasan->name;
        return response()->json($users);

    }
    
    public function destroy($id){

        $mt_cctv = Maintenance_cctv::find($id);
        $mt_cctv->delete();

        return redirect()->route('maintenance_cctv.index')->with('success','Data Maintenance CCTV Berhasil dihapus');

    }

    public function cetakPDF($id){

        $mt_cctv = Maintenance_cctv::find($id);
        $users = User::orderBy('created_at', 'DESC')->where(['id' => $mt_cctv->officer_id ])->get();
        $pdf = PDF::loadView('Maintenance.cctv.pdf', compact('mt_cctv', 'users'));

        return $pdf->stream($mt_cctv->no_document.'.pdf');
        // return response()->json($mt_cctv);

    }
}
