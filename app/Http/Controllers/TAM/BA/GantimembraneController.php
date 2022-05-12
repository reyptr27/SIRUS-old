<?php

namespace App\Http\Controllers\TAM\BA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TAM\BA\RS;
use App\Models\TAM\BA\Ganti_membrane;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use DB; use DataTables;
use Auth;
use Storage;


class GantimembraneController extends Controller
{
   
    public function json(){
        $login = Auth::user();
        if($login->hasPermissionTo('tam-ba-all')){
            $ba = DB::table('tam_ba_ganti_membrane')        
                ->leftJoin('users as teknisi', 'tam_ba_ganti_membrane.teknisi_id', '=', 'teknisi.id')
                ->leftJoin('users as katek', 'tam_ba_ganti_membrane.katek_id', '=', 'katek.id')
                ->leftJoin('users as katam', 'tam_ba_ganti_membrane.katam_id', '=', 'katam.id')
                ->leftJoin('users as pembuat', 'tam_ba_ganti_membrane.created_by', '=', 'pembuat.id')
                ->leftJoin('users as updater', 'tam_ba_ganti_membrane.updated_by', '=', 'updater.id')
                ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_ganti_membrane.rs_id', '=', 'rumah_sakit.id')
                        ->select([
                            'tam_ba_ganti_membrane.*','teknisi.name as teknisi','teknisi.jabatan as jabatan', 
                            'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam',
                            'pembuat.name as pembuat','updater.name as updater'
                        ]);
        }else{
            $ba = DB::table('tam_ba_ganti_membrane')
                ->leftJoin('users as teknisi', 'tam_ba_ganti_membrane.teknisi_id', '=', 'teknisi.id')
                ->leftJoin('users as katek', 'tam_ba_ganti_membrane.katek_id', '=', 'katek.id')
                ->leftJoin('users as katam', 'tam_ba_ganti_membrane.katam_id', '=', 'katam.id')
                ->leftJoin('users as pembuat', 'tam_ba_ganti_membrane.created_by', '=', 'pembuat.id')
                ->leftJoin('users as updater', 'tam_ba_ganti_membrane.updated_by', '=', 'updater.id')
                ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_ganti_membrane.rs_id', '=', 'rumah_sakit.id')
                        ->select([
                            'tam_ba_ganti_membrane.*','teknisi.name as teknisi','teknisi.jabatan as jabatan', 
                            'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam',
                            'pembuat.name as pembuat','updater.name as updater'
                        ])        
                        ->where('tam_ba_ganti_membrane.cabang_id','=',$login->cabang_id);
        }
                
        return DataTables::of($ba)
            ->addIndexColumn()
            ->editColumn('tanggal', function ($ba){
                return date('d-M-Y', strtotime($ba->tanggal) );
            })                        
            ->addColumn('upload', 'tam.ba.ganti_membrane.upload')
            ->rawColumns(['upload'])
            ->addColumn('action', 'tam.ba.ganti_membrane.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('tam.ba.ganti_membrane.index');
    }

    public function create()
    {   
        $login = Auth::user();
        $teknisis = DB::table('tam_teknisi')        
            ->leftJoin('users as teknisi', 'tam_teknisi.teknisi_id', '=', 'teknisi.id')
                ->select([
                       'teknisi.*','tam_teknisi.status','tam_teknisi.id as teknisi'
                   ])        
                // ->where(['teknisi.active' => 4, 'teknisi.cabang_id' => $login->cabang_id ])->orderBy('teknisi.name', 'ASC')->get();
                ->where(['teknisi.active' => 4])->orderBy('teknisi.name', 'ASC')->get();

        $kateks     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-katek'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();

        $katams     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-kepala'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();
        $rumah_sakit  = RS::where(['status' => 1 , 'cabang_id' => $login->cabang_id])->orderBy('nama_rs', 'ASC')->get();
        
        // return view('ba_gudang.create');
        return view('tam.ba.ganti_membrane.create', compact('kateks','katams','teknisis','rumah_sakit'));
    }

    public function store(Request $request)
    {
        $login = Auth::user();
        $baterakhir = Ganti_membrane::orderBy('id', 'DESC')->first(); 
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        $ba = new Ganti_membrane;

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
        $nomor=$datano."/SRU/".$bulanRomawi[date('n')]."/".date('Y');
        $ba->nomor = $nomor;
        $ba->teknisi_id = $request->teknisi_id;
        $ba->katek_id = $request->katek_id;
        $ba->katam_id = $request->katam_id;
        $ba->rs_id = $request->rs_id;
        $ba->tanggal = $request->tanggal;
        $ba->jumlah = $request->jumlah;
        $ba->keterangan = $request->keterangan;
        $ba->cabang_id = $login->cabang_id;
        $ba->created_by = $login->id;
        
        $ba->save();     
        
        return redirect()->route('gantimembrane.index')->withSuccess($ba->nomor.' Berhasil ditambahkan');
        // return response()->json($request);
    }

    public function edit($id)
    {
        $login = Auth::user();
        $ba = Ganti_membrane::findOrFail($id);
        $teknisis = DB::table('tam_teknisi')        
            ->leftJoin('users as teknisi', 'tam_teknisi.teknisi_id', '=', 'teknisi.id')
                ->select([
                       'teknisi.*','tam_teknisi.status','tam_teknisi.id as teknisi'
                   ])        
                // ->where(['teknisi.active' => 4, 'teknisi.cabang_id' => $login->cabang_id ])->orderBy('teknisi.name', 'ASC')->get();
                ->where(['teknisi.active' => 4])->orderBy('teknisi.name', 'ASC')->get();

        $kateks     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-katek'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();

        $katams     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-kepala'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();
        $rumah_sakit  = RS::where(['status' => 1, 'cabang_id' => $login->cabang_id])->orderBy('nama_rs', 'ASC')->get();
                     
        
        return view('tam.ba.ganti_membrane.edit')->with([
            'teknisis' => $teknisis,
            'kateks' => $kateks,
            'katams' => $katams,
            'rumah_sakit' =>$rumah_sakit,
            'ba' => $ba
            
        ]);    
        
    }

    public function update(Request $request, $id)
    {
        $login = Auth::user();

        $ba = Ganti_membrane::findOrFail($id);
        $ba->teknisi_id = $request->teknisi_id;
        $ba->katek_id = $request->katek_id;
        $ba->katam_id = $request->katam_id;
        $ba->rs_id = $request->rs_id;
        $ba->tanggal = $request->tanggal;
        $ba->jumlah = $request->jumlah;        
        $ba->keterangan = $request->keterangan;  
        $ba->updated_by = $login->id;      
        $ba->save();
              
        return redirect()->route('gantimembrane.index')->withSuccess($ba->nomor.' Berhasil diupdate');       
    }

    public function destroy($id)
    {
        
        $ba = Ganti_membrane::findOrFail($id);
        if($ba->upload_file != null){
            Storage::delete("public/TAM/BA/ganti_membrane/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
        } 
        
        $ba->delete();
        return redirect()->route('gantimembrane.index')->withSuccess($ba->nomor.' Berhasil dihapus');
       
    }

    public function upload(Request $request, $id)
    {
        $ba = Ganti_membrane::findOrFail($id);
        //upload file
            $waktu = time();       //
            if($ba->upload_file != null){
                Storage::delete("public/TAM/BA/ganti_membrane/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
            } 
            $path = Storage::putFileAs(
                'public/TAM/BA/ganti_membrane/'.date('Y').'/', //direktori
                $request->file('upload_file'), //file
                $waktu.'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = $waktu.'_'.$request->file('upload_file')->getClientOriginalName();
            $ba->upload_file = $nama_file;
            $ba->save();
        
        return redirect()->route('gantimembrane.index')->withSuccess($ba->nomor." Berhasil di upload ");
        // return response()->json($request);
        
    }
    public function download($id)
    {
        $ba = Ganti_membrane::findOrFail($id);       
        return Storage::download("public/TAM/BA/ganti_membrane/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
    }

    public function show($id)
    {   
        $ba = Ganti_membrane::findOrFail($id);       
        return Storage::response("public/TAM/BA/ganti_membrane/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);       

    }



    public function print($id)
    {   

        $ba = DB::table('tam_ba_ganti_membrane')
            ->leftJoin('users as teknisi', 'tam_ba_ganti_membrane.teknisi_id', '=', 'teknisi.id')
            ->leftJoin('users as katek', 'tam_ba_ganti_membrane.katek_id', '=', 'katek.id')
            ->leftJoin('users as katam', 'tam_ba_ganti_membrane.katam_id', '=', 'katam.id')
            ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_ganti_membrane.rs_id', '=', 'rumah_sakit.id')
                    ->select([
                        'tam_ba_ganti_membrane.*','teknisi.name as teknisi','teknisi.jabatan as jabatan', 
                        'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam'
                    ]) 
            ->where('tam_ba_ganti_membrane.id',$id)       
            ->first();
       
       
        $pdf = PDF::loadView('tam.ba.ganti_membrane.print', compact('ba'));
       
        
        return $pdf->stream($ba->nomor.'.pdf');
    }
}
