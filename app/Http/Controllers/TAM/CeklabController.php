<?php

namespace App\Http\Controllers\TAM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TAM\BA\RS;
use App\Models\TAM\ceklab;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use DB; use DataTables;
use Auth;
use Storage;


class CeklabController extends Controller
{
   
    public function json(){
        $login = Auth::user();
        if($login->hasPermissionTo('tam-ba-all')){
            $ba = DB::table('tam_ceklab')
                ->leftJoin('users as pemohon', 'tam_ceklab.pemohon_id', '=', 'pemohon.id')
                ->leftJoin('users as pembuat', 'tam_ceklab.created_by', '=', 'pembuat.id')
                ->leftJoin('users as updater', 'tam_ceklab.updated_by', '=', 'updater.id')
                ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ceklab.rs_id', '=', 'rumah_sakit.id')
                        ->select([
                            'tam_ceklab.*','pemohon.name as pemohon','pemohon.jabatan as jabatan', 
                            'rumah_sakit.nama_rs as nama_rs',
                            'pembuat.name as pembuat','updater.name as updater'
                        ])        
                ->get();
        }else{

            $ba = DB::table('tam_ceklab')
                ->leftJoin('users as pemohon', 'tam_ceklab.pemohon_id', '=', 'pemohon.id')
                ->leftJoin('users as pembuat', 'tam_ceklab.created_by', '=', 'pembuat.id')
                ->leftJoin('users as updater', 'tam_ceklab.updated_by', '=', 'updater.id')
                ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ceklab.rs_id', '=', 'rumah_sakit.id')
                        ->select([
                            'tam_ceklab.*','pemohon.name as pemohon','pemohon.jabatan as jabatan', 
                            'rumah_sakit.nama_rs as nama_rs',
                            'pembuat.name as pembuat','updater.name as updater'
                        ])  
                        ->where('tam_ceklab.cabang_id','=',$login->cabang_id)                                                
                ->get();
        }
                        
        return DataTables::of($ba)
            ->addIndexColumn()
            ->editColumn('created_at', function ($ba){
                return date('d-M-Y', strtotime($ba->created_at) );
            })
            ->editColumn('pihak_ketiga', function ($ba){
                if($ba->pihak_ketiga== 1){
                    return 'PT. SUCOFINDO - Laboratory Surabaya';
                }
                elseif($ba->pihak_ketiga== 2){
                    return 'PERSADA LABORATORY - Mojokerto';
                }
                elseif($ba->pihak_ketiga== 3){
                    return 'Balai Besar Laboratorium Kesehatan(BBLK) - Surabaya';
                }
                else{
                    return 'PT. CITO DIAGNOSTIKA UTAMA - Semarang';
                }
            })  
            
            ->addColumn('upload', 'tam.ceklab.upload')
            ->rawColumns(['upload'])
            ->addColumn('action', 'tam.ceklab.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('tam.ceklab.index');
    }

    public function create()
    {   
        $login = Auth::user();
        $pemohons = User::orderBy('name', 'ASC')->where([['active','=','4'],['dept_id','=','5'],['cabang_id','=',$login->cabang_id]])->get();
        $rumah_sakit  = RS::where(['status' => 1, 'cabang_id' => $login->cabang_id])->orderBy('nama_rs', 'ASC')->get();
        return view('tam.ceklab.create', compact('rumah_sakit','pemohons'));
    }

    public function store(Request $request)
    {
        $login = Auth::user();
        $baterakhir = Ceklab::orderBy('id', 'DESC')->first(); 
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        $ba = new Ceklab;

        if($baterakhir == null){
            $hasil = "1";
        }else{
            $nomor = $baterakhir->nomor;
            $pisah = explode('/', $nomor);

            if ((int)$pisah[0] > 0 && $pisah[3] != date('Y')) {
               $hasil = "1";
            }else{
                $hasil = (int)$pisah[0]+1;    
            }
        }

        $datano = sprintf("%04s", $hasil);
        $nomor=$datano."/TAM/".$bulanRomawi[date('n')]."/".date('Y');
        $ba->nomor = $nomor;
        $ba->pemohon_id = $request->pemohon_id;
        $ba->rs_id = $request->rs_id;
        $ba->type = $request->type;
        $ba->alamat = $request->alamat;
        $ba->pemeriksaan = $request->pemeriksaan;
        $ba->pihak_ketiga = $request->pihak_ketiga;
        $ba->lainnya = $request->lainnya;
        $ba->cabang_id = $login->cabang_id;
        $ba->created_by = $login->id;
        
        $ba->save();     
        
        return redirect()->route('ceklab.index')->withSuccess('02.'.$ba->nomor.' Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $ba = Ceklab::findOrFail($id);
        $login = Auth::user();
        $pemohons = User::orderBy('name', 'ASC')->where([['active','=','4'],['dept_id','=','5'],['cabang_id','=',$login->cabang_id]])->get();
        $rumah_sakit  = RS::where(['status' => 1, 'cabang_id' => $login->cabang_id])->orderBy('nama_rs', 'ASC')->get();
                     
        
        return view('tam.ceklab.edit')->with([
            'pemohons' => $pemohons,
            'rumah_sakit' =>$rumah_sakit,
            'ba' => $ba
            
        ]);            
    }

    public function update(Request $request, $id)
    {
        $login = Auth::user();

        $ba = Ceklab::findOrFail($id);
        $ba->pemohon_id = $request->pemohon_id;
        $ba->rs_id = $request->rs_id;
        $ba->type = $request->type;
        $ba->alamat = $request->alamat;
        $ba->pemeriksaan = $request->pemeriksaan;
        $ba->pihak_ketiga = $request->pihak_ketiga;
        $ba->lainnya = $request->lainnya;
        $ba->updated_by = $login->id;      
        $ba->save();
              
        return redirect()->route('ceklab.index')->withSuccess($ba->nomor.' Berhasil diupdate');       
    }

    public function destroy($id)
    {
        
        $ba = Ceklab::findOrFail($id);
        if($ba->upload_file != null){
            Storage::delete("public/TAM/ceklab/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
        } 
        
        $ba->delete();
        return redirect()->route('ceklab.index')->withSuccess($ba->nomor.' Berhasil dihapus');
       
    }

    public function upload(Request $request, $id)
    {
        $ba = Ceklab::findOrFail($id);
        //upload file
            $waktu = time();       //
            if($ba->upload_file != null){
                Storage::delete("public/TAM/ceklab/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
            } 
            $path = Storage::putFileAs(
                'public/TAM/ceklab/'.date('Y').'/', //direktori
                $request->file('upload_file'), //file
                $waktu.'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = $waktu.'_'.$request->file('upload_file')->getClientOriginalName();
            $ba->upload_file = $nama_file;
            $ba->save();
        
        return redirect()->route('ceklab.index')->withSuccess($ba->nomor." Berhasil di upload ");
        
    }
    public function download($id)
    {
        $ba = Ceklab::findOrFail($id);       
        return Storage::download("public/TAM/ceklab/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
    }

    public function show($id)
    {   
        $ba = Ceklab::findOrFail($id);       
        return Storage::response("public/TAM/ceklab/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);       

    }


    public function print($id)
    {   
        $ba = DB::table('tam_ceklab')
            ->leftJoin('users as pemohon', 'tam_ceklab.pemohon_id', '=', 'pemohon.id')
            ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ceklab.rs_id', '=', 'rumah_sakit.id')
                    ->select([
                        'tam_ceklab.*','pemohon.name as pemohon','pemohon.jabatan as jabatan', 
                        'rumah_sakit.nama_rs as nama_rs'
                    ]) 
            ->where('tam_ceklab.id',$id)       
            ->first();
              
        $pdf = PDF::loadView('tam.ceklab.print', compact('ba'));       
        
        return $pdf->stream($ba->nomor.'.pdf');
    }
}
