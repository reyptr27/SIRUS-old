<?php

namespace App\Http\Controllers\TAM\BA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TAM\BA\RS;
use App\Models\TAM\BA\Chemical;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use DB; use DataTables;
use Auth;
use Storage;


class ChemicalController extends Controller
{
   
    public function json(){
        $login = Auth::user();        
        if($login->hasPermissionTo('tam-ba-all')){
            $bachemical = DB::table('tam_ba_chemical')
                ->leftJoin('users as teknisi', 'tam_ba_chemical.teknisi_id', '=', 'teknisi.id')
                ->leftJoin('users as katek', 'tam_ba_chemical.katek_id', '=', 'katek.id')
                ->leftJoin('users as katam', 'tam_ba_chemical.katam_id', '=', 'katam.id')
                ->leftJoin('users as pembuat', 'tam_ba_chemical.created_by', '=', 'pembuat.id')
                ->leftJoin('users as updater', 'tam_ba_chemical.updated_by', '=', 'updater.id')
                ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_chemical.rs_id', '=', 'rumah_sakit.id')
                        ->select([
                            'tam_ba_chemical.*','teknisi.name as teknisi','teknisi.jabatan as jabatan', 
                            'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam',
                            'pembuat.name as pembuat','updater.name as updater'
                        ]);
        }
        else{
            $bachemical = DB::table('tam_ba_chemical')
                ->leftJoin('users as teknisi', 'tam_ba_chemical.teknisi_id', '=', 'teknisi.id')
                ->leftJoin('users as katek', 'tam_ba_chemical.katek_id', '=', 'katek.id')
                ->leftJoin('users as katam', 'tam_ba_chemical.katam_id', '=', 'katam.id')
                ->leftJoin('users as pembuat', 'tam_ba_chemical.created_by', '=', 'pembuat.id')
                ->leftJoin('users as updater', 'tam_ba_chemical.updated_by', '=', 'updater.id')
                ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_chemical.rs_id', '=', 'rumah_sakit.id')
                        ->select([
                            'tam_ba_chemical.*','teknisi.name as teknisi','teknisi.jabatan as jabatan', 
                            'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam',
                            'pembuat.name as pembuat','updater.name as updater'
                        ])    
                        ->where('tam_ba_chemical.cabang_id','=',$login->cabang_id);
        }
                
        return DataTables::of($bachemical)
            ->addIndexColumn()
            ->editColumn('tanggal', function ($bachemical){
                return date('d-M-Y', strtotime($bachemical->tanggal) );
            })
            ->addColumn('upload', 'tam.ba.chemical_ro.upload')
            ->rawColumns(['upload'])
            ->addColumn('action', 'tam.ba.chemical_ro.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('tam.ba.chemical_ro.index');
    }

    public function create()
    {   
        $login = Auth::user();
        $teknisis = DB::table('tam_teknisi')
            ->leftJoin('users as teknisi', 'tam_teknisi.teknisi_id', '=', 'teknisi.id')
                ->select([
                    'teknisi.*','tam_teknisi.status','tam_teknisi.id as teknisi'
                ])        
                // ->where(['teknisi.active' => 4,'teknisi.cabang_id' => $login->cabang_id])->orderBy('teknisi.name', 'ASC')->get();
                ->where(['teknisi.active' => 4])->orderBy('teknisi.name', 'ASC')->get();

        $kateks     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-katek'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();

        $katams     = User::whereHas('permissions', function($q){ 
            $q->where('name', 'tam-kepala'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();
        $rumah_sakit  = RS::where(['status' => 1,'cabang_id' => $login->cabang_id])->orderBy('nama_rs', 'ASC')->get();
        return view('tam.ba.chemical_ro.create', compact('kateks','katams','teknisis','rumah_sakit'));
    }

    public function store(Request $request)
    {
        $login = Auth::user();
        $baterakhir = Chemical::orderBy('id', 'DESC')->first(); 
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        $ba = new Chemical;

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
        $ba->cabang_id = $login->cabang_id;
        $ba->rs_id = $request->rs_id;
        $ba->tanggal = $request->tanggal;
        $ba->jenis_pekerjaan = $request->jenis_pekerjaan;
        $ba->created_by = $login->id;
        
        $ba->save();     
        
        return redirect()->route('chemical_ro.index')->withSuccess($ba->nomor.' Berhasil ditambahkan');
    }

    public function edit($id)
    {   
        $login = Auth::user();
        $ba = Chemical::findOrFail($id);
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
                     
        
        return view('tam.ba.chemical_ro.edit')->with([
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
        $ba = Chemical::findOrFail($id);
        $ba->teknisi_id = $request->teknisi_id;
        $ba->katek_id = $request->katek_id;
        $ba->katam_id = $request->katam_id;
        $ba->rs_id = $request->rs_id;
        $ba->tanggal = $request->tanggal;
        $ba->jenis_pekerjaan = $request->jenis_pekerjaan;
        $ba->updated_by = $login->id;        
        $ba->save();
              
        return redirect()->route('chemical_ro.index')->withSuccess($ba->nomor.' Berhasil diupdate');       
    }

    public function destroy($id)
    {
        $ba = Chemical::findOrFail($id);

        if(!empty($ba->upload_file)){
            Storage::delete('public/TAM/BA/chemical_ro/'.date('Y', strtotime($ba->created_at)).'/'.$ba->upload_file);
        }
        
        $ba->delete();
        return redirect()->route('chemical_ro.index')->withSuccess($ba->nomor.' Berhasil dihapus');
       
    }

    public function upload(Request $request, $id)
    {
        $ba = Chemical::findOrFail($id);
        //upload file
            $waktu = time();       //
            if($ba->upload_file != null){
                Storage::delete("public/TAM/BA/chemical_ro/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
            } 
            $path = Storage::putFileAs(
                'public/TAM/BA/chemical_ro/'.date('Y',strtotime($ba->created_at)).'/', //direktori
                $request->file('upload_file'), //file
                $waktu.'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = $waktu.'_'.$request->file('upload_file')->getClientOriginalName();
            $ba->upload_file = $nama_file;
            $ba->save();
        
        return redirect()->route('chemical_ro.index')->withSuccess($ba->nomor." Berhasil di upload ");
        // return response()->json($request);
        
    }
    public function download($id)
    {
        $ba = Chemical::findOrFail($id);       
        return Storage::download("public/TAM/BA/chemical_ro/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);
    }

    public function show($id)
    {   
        $ba = Chemical::findOrFail($id);       
        return Storage::response("public/TAM/BA/chemical_ro/".date('Y',strtotime($ba->created_at))."/".$ba->upload_file);       

    }

    public function print($id)
    {   

        $ba = DB::table('tam_ba_chemical')
            ->leftJoin('users as teknisi', 'tam_ba_chemical.teknisi_id', '=', 'teknisi.id')
            ->leftJoin('users as katek', 'tam_ba_chemical.katek_id', '=', 'katek.id')
            ->leftJoin('users as katam', 'tam_ba_chemical.katam_id', '=', 'katam.id')
            ->leftJoin('users as pembuat', 'tam_ba_chemical.created_by', '=', 'pembuat.id')
            ->leftJoin('tam_ba_rs as rumah_sakit', 'tam_ba_chemical.rs_id', '=', 'rumah_sakit.id')
                    ->select([
                        'tam_ba_chemical.*','teknisi.name as teknisi','teknisi.jabatan as jabatan',
                        'pembuat.name as pembuat',  
                        'rumah_sakit.nama_rs as nama_rs', 'katek.name as katek','katam.name as katam'
                    ]) 
            ->where('tam_ba_chemical.id',$id)       
            ->first();

        // $ba = DB::table('')
        // ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        // ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        // ->select([
        //    'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //    'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //     'alamat_penerima.status as status_gudang'
        // ])
        //         ->where('ba_gudang.id',$id)
        //         ->first();
        // $ba = Ba_Gudang::findOrFail($id);
       
       
        $pdf = PDF::loadView('tam.ba.chemical_ro.print', compact('ba'));
       
        
        return $pdf->stream($ba->nomor.'.pdf');
    }
}
