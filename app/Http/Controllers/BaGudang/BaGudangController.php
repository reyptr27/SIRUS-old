<?php

namespace App\Http\Controllers\BaGudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Beritaacara\Ba_Gudang;
use App\Models\Beritaacara\Ba_Gudang_Barang;
use App\Models\Beritaacara\Ba_Gudang_Alamat;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use DB; use DataTables; use Validator; use File;use Auth;
use Storage;


class BaGudangController extends Controller
{
   
    public function json(){
        $login = Auth::user();
        // if($login->hasPermissionTo('scm-ba-kedinding')){
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //             'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //             'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])              
        //     ->where('ba_gudang.alamat_id','=',2)->get();
        // }elseif($login->hasPermissionTo('scm-ba-gdkecil')){
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //                 'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //                 'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])              
        //     ->where('ba_gudang.alamat_id','=',4)->get();
        // }elseif($login->hasPermissionTo('scm-ba-maspion1')){
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //                 'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //                 'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])              
        //     ->where('ba_gudang.alamat_id','=',5)->get();
        // }elseif($login->hasPermissionTo('scm-ba-maspion2')){
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //                 'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //                 'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])              
        //     ->where('ba_gudang.alamat_id','=',6)->get();

        // }elseif($login->hasPermissionTo('scm-ba-maspion3')){
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //                 'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //                 'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])              
        //     ->where('ba_gudang.alamat_id','=',7)->get();

        // }elseif($login->hasPermissionTo('scm-ba-depo')){
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //                 'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //                 'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])              
        //     ->where('ba_gudang.alamat_id','=',8)->get();
    
        // }elseif($login->hasPermissionTo('scm-ba-sparepart')){
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //                 'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //                 'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])              
        //     ->where('ba_gudang.alamat_id','=',9)->get();
    
        // }elseif($login->hasPermissionTo('scm-ba-all')){
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //                 'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //                 'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])              
        //     ->get();
        // }else{
        //     $bagudang = DB::table('ba_gudang')
        //     ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        //     ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        //             ->select([
        //                 'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
        //                 'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
        //                 'alamat_penerima.status as status_gudang'
        //             ])   
        //     ->where('ba_gudang.alamat_id','=',1)->get();
        // }

        $bagudang = DB::table('ba_gudang')
        // $login = Auth::user();
            ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
            ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
                    ->select([
                        'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
                        'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
                        'alamat_penerima.status as status_gudang'
                    ])        
            ->get();
                
        return DataTables::of($bagudang)
            ->addIndexColumn()
            ->editColumn('no_document', function ($bagudang){
                return $bagudang->no_document;
            })
            ->editColumn('created_at', function ($bagudang){
                return date('d-M-Y', strtotime($bagudang->created_at) );
            })
            ->editColumn('nama_penerima', function ($bagudang){
                return $bagudang->penerima;
            })
            ->editColumn('nama_pengirim', function ($bagudang){
                return $bagudang->nama_pengirim;
            })
            ->editColumn('cno_resi', function ($bagudang){
                return $bagudang->no_resi;
            })
            ->addColumn('upload', 'ba_gudang.upload')
            ->rawColumns(['upload'])
            ->addColumn('action', 'ba_gudang.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('ba_gudang.index');
    }

    public function create()
    {   
        // $penerimas = User::where([['active', '=', 4],['name','!=','Admin']])->orderBy('name', 'ASC')->get();
        $penerimas     = User::whereHas('roles', function($q){ 
            $q->where('name', 'SCM'); 
        })->where('active',4)->orderBy('name', 'ASC')->get();
        $alamats  = Ba_Gudang_Alamat::where(['status' => 1])->orderBy('nama_gudang', 'ASC')->get();
        
        // return view('ba_gudang.create');
        return view('ba_gudang.create', compact('penerimas','alamats'));
    }

    public function store(Request $request)
    {
        $baterakhir = Ba_Gudang::orderBy('id', 'DESC')->first(); 
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        $ba = new Ba_Gudang;

        if($baterakhir == null){
            $hasil = "1";
        }else{
            $nomor = $baterakhir->no_document;
            $pisah = explode('/', $nomor);

            if ((int)$pisah[0] > 0 && $pisah[3] != date('Y')) {
               $hasil = "1";
            }else{
                $hasil = (int)$pisah[0]+1;    
            }
        }

        $datano = sprintf("%04s", $hasil);
        $no_document=$datano."/BAST/".$bulanRomawi[date('n')]."/".date('Y');
        $ba->no_document = $no_document;
        $ba->penerima_id = $request->penerima_id;
        $ba->alamat_id= $request->alamat_id;
        $ba->nama_pengirim= $request->nama_pengirim;
        $ba->perusahaan_pengirim= $request->perusahaan_pengirim;
        $ba->alamat_pengirim= $request->alamat_pengirim;
        $ba->jenis_barang= $request->jenis_barang;
        $ba->no_resi= $request->no_resi;
        $ba->no_container= $request->no_container;
        $ba->no_seal= $request->no_seal;
        $ba->no_surat_jalan= $request->no_surat_jalan;
        $ba->sesuai= $request->sesuai;

        if($request->sesuai == 0){
            $ba->selisih= $request->selisih;
            $ba->cacat= $request->cacat;
        }else{
        }
        $ba->save();
   

         $i = 0;
         
            foreach($request->nama_barang as $row){
                $barang = new Ba_Gudang_Barang;
                $barang->ba_gudang_id = $ba->id;
                $barang->nama_barang = $request->nama_barang[$i];
                $barang->kuantitas = $request->kuantitas[$i];
                $barang->satuan = $request->satuan[$i];
                $barang->kondisi = $request->kondisi[$i];
                $barang->keterangan = $request->keterangan[$i];
                $barang->save();
                $i++;
            }       
        
        return redirect()->route('bagudang.index')->withSuccess($ba->no_document.' Berhasil ditambahkan');
        // return response()->json($request);
    }

    public function edit($id)
    {
        $ba = Ba_Gudang::findOrFail($id);
        $penerimas = User::where([['active', '=', 4],['name','!=','Admin']])->orderBy('name', 'ASC')->get();
        $alamats  = Ba_Gudang_Alamat::where(['status' => 1])->orderBy('nama_gudang', 'ASC')->get();
        $barangs  = Ba_Gudang_Barang::where(['ba_gudang_id' => $id])->orderBy('id', 'ASC')->get();              
        
        return view('ba_gudang.edit')->with([
            'penerimas' => $penerimas,
            'barangs' => $barangs,
            'alamats' =>$alamats,
            'ba' => $ba
            
        ]);    
        // return response()->json($alamats);
        
    }

    public function update(Request $request, $id)
    {
        $ba = Ba_Gudang::findOrFail($id);
        $ba->penerima_id = $request->penerima_id;
        $ba->alamat_id= $request->alamat_id;
        $ba->nama_pengirim= $request->nama_pengirim;
        $ba->perusahaan_pengirim= $request->perusahaan_pengirim;
        $ba->alamat_pengirim= $request->alamat_pengirim;
        $ba->jenis_barang= $request->jenis_barang;
        $ba->no_resi= $request->no_resi;
        $ba->no_container= $request->no_container;
        $ba->no_seal= $request->no_seal;
        $ba->no_surat_jalan= $request->no_surat_jalan;
        $ba->sesuai= $request->sesuai;

        if($request->sesuai == 0){
            $ba->selisih= $request->selisih;
            $ba->cacat= $request->cacat;
        }else{
            $ba->selisih=null;
            $ba->cacat=null;
        }
        $ba->save();

        //cek collection barang yg exist
        $barang = Ba_Gudang_Barang::where(['ba_gudang_id' => $id])->get();
        //hapus agar tidak ada redundant
        if($barang){
            $barang->each->delete();
        }
   

         $i = 0;
         foreach($request->nama_barang as $row){
            $barang = new Ba_Gudang_Barang;
            $barang->ba_gudang_id = $ba->id;
            $barang->nama_barang = $request->nama_barang[$i];
            $barang->kuantitas = $request->kuantitas[$i];
            $barang->satuan = $request->satuan[$i];
            $barang->kondisi = $request->kondisi[$i];
            $barang->keterangan = $request->keterangan[$i];
            $barang->save();
            $i++;
        }
        
        return redirect()->route('bagudang.index')->withSuccess($ba->no_document.' Berhasil diupdate');       
    }

    public function destroy($id)
    {
        
        $ba = Ba_Gudang::findOrFail($id);
        $barang = Ba_Gudang_Barang::where(['ba_gudang_id' => $id])->get();
        if($barang){
            $barang->each->delete();
        }
        
        $ba->delete();
        return redirect()->route('bagudang.index')->withSuccess($ba->no_document.' Berhasil dihapus');
       
    }

    public function upload(Request $request, $id)
    {
        $ba = Ba_Gudang::findOrFail($id);
        //upload file
            $waktu = time();       //
            if($ba->upload_file != null){
                Storage::delete("public/BeritaAcara/baranggudang/".$ba->upload_file);
                // File::delete('storage/app/Berita_Acara/barang_gudang/'.$ba->upload_file);
            } 
            $path = Storage::putFileAs(
                'public/BeritaAcara/baranggudang/', //direktori
                $request->file('upload_file'), //file
                $waktu.'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = $waktu.'_'.$request->file('upload_file')->getClientOriginalName();
            $ba->upload_file = $nama_file;
            $ba->save();
        
        return redirect()->route('bagudang.index')->withSuccess($ba->no_document." Berhasil di upload ");
        // return response()->json($request);
        
    }
    public function download($id)
    {
        $ba = Ba_Gudang::findOrFail($id);       
        return Storage::download("public/BeritaAcara/baranggudang/".$ba->upload_file);
    }

    public function show($id)
    {   
        $ba = Ba_Gudang::findOrFail($id);       
        return Storage::response("public/BeritaAcara/baranggudang/".$ba->upload_file);       

    }



    public function print($id)
    {   
        $ba = DB::table('ba_gudang')
        ->leftJoin('users as penerima', 'ba_gudang.penerima_id', '=', 'penerima.id')
        ->leftJoin('ba_gudang_alamat as alamat_penerima', 'ba_gudang.alamat_id', '=', 'alamat_penerima.id')
        ->select([
           'ba_gudang.*','penerima.name as penerima','penerima.jabatan as jabatan', 
           'alamat_penerima.nama_gudang as nama_gudang' , 'alamat_penerima.alamat as alamat_penerima',
            'alamat_penerima.status as status_gudang'
        ])
                ->where('ba_gudang.id',$id)
                ->first();
        // $ba = Ba_Gudang::findOrFail($id);
        $barang = Ba_Gudang_Barang::where(['ba_gudang_id' => $ba->id])->get();
        $jmlbarang = count($barang);
       
        $pdf = PDF::loadView('ba_gudang.print', compact('ba', 'barang','jmlbarang'));
       
        
        return $pdf->stream($ba->no_document.'.pdf');
    }
}
