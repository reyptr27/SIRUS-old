<?php

namespace App\Http\Controllers\TAM\BA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TAM\BA\RS;
use App\Models\TAM\BA\Flushing;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use DB; use DataTables; 
use Auth;
use Storage;


class FlushingController extends Controller
{
   
    public function json(){
        $login = Auth::user();
        if($login->hasPermissionTo('tam-ba-all')){
            $baflushing = DB::table('tam_ba_flushing')            
                ->leftJoin('users as teknisi', 'tam_ba_flushing.teknisi_id', '=', 'teknisi.id')
                ->leftJoin('users as katek', 'tam_ba_flushing.katek_id', '=', 'katek.id')
                ->leftJoin('users as katam', 'tam_ba_flushing.katam_id', '=', 'katam.id')
                ->leftJoin('users as pembuat', 'tam_ba_flushing.created_by', '=', 'pembuat.id')
            ->leftJoin('users as updater', 'tam_ba_flushing.updated_by', '=', 'updater.id')
                ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_flushing.rs_id', '=', 'rumah_sakit.id')
                        ->select([
                            'tam_ba_flushing.*','teknisi.name as teknisi','teknisi.jabatan as jabatan', 
                            'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam',
                            'pembuat.name as pembuat','updater.name as updater'
                        ]);
        }else{
            $baflushing = DB::table('tam_ba_flushing')            
                ->leftJoin('users as teknisi', 'tam_ba_flushing.teknisi_id', '=', 'teknisi.id')
                ->leftJoin('users as katek', 'tam_ba_flushing.katek_id', '=', 'katek.id')
                ->leftJoin('users as katam', 'tam_ba_flushing.katam_id', '=', 'katam.id')
                ->leftJoin('users as pembuat', 'tam_ba_flushing.created_by', '=', 'pembuat.id')
                ->leftJoin('users as updater', 'tam_ba_flushing.updated_by', '=', 'updater.id')
                ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_flushing.rs_id', '=', 'rumah_sakit.id')
                        ->select([
                            'tam_ba_flushing.*','teknisi.name as teknisi','teknisi.jabatan as jabatan', 
                            'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam',
                            'pembuat.name as pembuat','updater.name as updater'
                        ])
                ->where('tam_ba_flushing.cabang_id','=',$login->cabang_id);
        }
                
        return DataTables::of($baflushing)
            ->addIndexColumn()
            ->editColumn('tanggal', function ($baflushing){
                return date('d-M-Y', strtotime($baflushing->tanggal) );
            })
                        
            ->addColumn('upload', 'tam.ba.flushing_pipa.upload')
            ->rawColumns(['upload'])
            ->addColumn('action', 'tam.ba.flushing_pipa.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('tam.ba.flushing_pipa.index');
    }

    public function create()
    {   
        
        $login = Auth::user();
        $teknisis = DB::table('tam_teknisi')
            ->leftJoin('users as teknisi', 'tam_teknisi.teknisi_id', '=', 'teknisi.id')
                    ->select([
                        'teknisi.*','tam_teknisi.status','tam_teknisi.id as teknisi'
                    ])        
                    // ->where(['teknisi.active' => 4, 'teknisi.cabang_id' => $login->cabang_id])->orderBy('teknisi.name', 'ASC')->get();
                    ->where(['teknisi.active' => 4])->orderBy('teknisi.name', 'ASC')->get();

        $kateks     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-katek'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();

        $katams     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-kepala'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();
        $rumah_sakit  = RS::where(['status' => 1,'cabang_id' => $login->cabang_id])->orderBy('nama_rs', 'ASC')->get();
        
        return view('tam.ba.flushing_pipa.create', compact('kateks','katams','teknisis','rumah_sakit'));
    }

    public function store(Request $request)
    {
        $login = Auth::user();
        $baterakhir = Flushing::orderBy('id', 'DESC')->first(); 
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        $ba = new Flushing;

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
        $ba->jenis_pekerjaan = $request->jenis_pekerjaan;
        $ba->cabang_id = $login->cabang_id;
        $ba->created_by = $login->id;
        
        $ba->save();     
        
        return redirect()->route('flushing.index')->withSuccess($ba->nomor.' Berhasil ditambahkan');
        // return response()->json($request);
    }

    public function edit($id)
    {
        $login = Auth::user();
        $ba = Flushing::findOrFail($id);
        $teknisis = DB::table('tam_teknisi')
        // $login = Auth::user();
            ->leftJoin('users as teknisi', 'tam_teknisi.teknisi_id', '=', 'teknisi.id')
                    ->select([
                        'teknisi.*','tam_teknisi.status','tam_teknisi.id as teknisi'
                    ])        
                    // ->where(['teknisi.active' => 4, 'teknisi.cabang_id' => $login->cabang_id])->orderBy('teknisi.name', 'ASC')->get();
                    ->where(['teknisi.active' => 4])->orderBy('teknisi.name', 'ASC')->get();
        $kateks     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-katek'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();

        $katams     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-kepala'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();
        $rumah_sakit  = RS::where(['status' => 1,'cabang_id' => $login->cabang_id])->orderBy('nama_rs', 'ASC')->get();
                     
        
        return view('tam.ba.flushing_pipa.edit')->with([
            'teknisis' => $teknisis,
            'kateks' => $kateks,
            'katams' => $katams,
            'rumah_sakit' =>$rumah_sakit,
            'ba' => $ba
            
        ]);    
        // return response()->json($alamats);
        
    }

    public function update(Request $request, $id)
    {
        $login = Auth::user();
        $ba = Flushing::findOrFail($id);
        $ba->teknisi_id = $request->teknisi_id;
        $ba->katek_id = $request->katek_id;
        $ba->katam_id = $request->katam_id;
        $ba->rs_id = $request->rs_id;
        $ba->tanggal = $request->tanggal;
        $ba->jenis_pekerjaan = $request->jenis_pekerjaan;
        $ba->updated_by = $login->id;          
        $ba->save();
              
        return redirect()->route('flushing.index')->withSuccess($ba->nomor.' Berhasil diupdate');       
    }

    public function destroy($id)
    {
        
        $ba = Flushing::findOrFail($id);
        if($ba->upload_file != null){
            Storage::delete("public/TAM/BA/flushing_pipa/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
            // File::delete('storage/app/Berita_Acara/barang_gudang/'.$ba->upload_file);
        } 
        
        $ba->delete();
        return redirect()->route('flushing.index')->withSuccess($ba->nomor.' Berhasil dihapus');
       
    }

    public function upload(Request $request, $id)
    {
        $ba = Flushing::findOrFail($id);
        //upload file
            $waktu = time();       //
            if($ba->upload_file != null){
                Storage::delete("public/TAM/BA/flushing_pipa/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
                // File::delete('storage/app/Berita_Acara/barang_gudang/'.$ba->upload_file);
            } 
            $path = Storage::putFileAs(
                'public/TAM/BA/flushing_pipa/'.date('Y').'/', //direktori
                $request->file('upload_file'), //file
                $waktu.'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = $waktu.'_'.$request->file('upload_file')->getClientOriginalName();
            $ba->upload_file = $nama_file;
            $ba->save();
        
        return redirect()->route('flushing.index')->withSuccess($ba->nomor." Berhasil di upload ");
        // return response()->json($request);
        
    }
    public function download($id)
    {
        $ba = Flushing::findOrFail($id);       
        return Storage::download("public/TAM/BA/flushing_pipa/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
    }

    public function show($id)
    {   
        $ba = Flushing::findOrFail($id);       
        return Storage::response("public/TAM/BA/flushing_pipa/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);       

    }



    public function print($id)
    {   

        $ba = DB::table('tam_ba_flushing')
            ->leftJoin('users as teknisi', 'tam_ba_flushing.teknisi_id', '=', 'teknisi.id')
            ->leftJoin('users as katek', 'tam_ba_flushing.katek_id', '=', 'katek.id')
            ->leftJoin('users as katam', 'tam_ba_flushing.katam_id', '=', 'katam.id')
            ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_flushing.rs_id', '=', 'rumah_sakit.id')
                    ->select([
                        'tam_ba_flushing.*','teknisi.name as teknisi','teknisi.jabatan as jabatan', 
                        'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam'
                    ]) 
            ->where('tam_ba_flushing.id',$id)       
            ->first();
       
       
        $pdf = PDF::loadView('tam.ba.flushing_pipa.print', compact('ba'));
       
        
        return $pdf->stream($ba->nomor.'.pdf');
    }
}
