<?php

namespace App\Http\Controllers\CAPA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CAPA\Lokasi;
use App\Models\CAPA\CAPA;
use App\Models\CAPA\CapaDept;
use App\Models\Departemen;
use App\User; use PDF;
use Storage; use Auth; 
use DB; use DataTables; 

class CapaController extends Controller
{
    public function json()
    {
        $user = Auth::user();
        if($user->hasPermissionTo('capa-all')){
            $model = DB::table('capa')
                ->leftJoin('m_departemen as kepada', 'kepada.id', '=', 'capa.kepada_id')
                ->leftJoin('m_departemen as dari', 'dari.id', '=', 'capa.dari_id')
                ->leftJoin('capa_lokasi as lokasi', 'lokasi.id', '=', 'capa.lokasi_id')
                ->leftJoin('users as pic', 'pic.id', '=', 'capa.pic_id')
                ->leftJoin('users as verifikator', 'verifikator.id', '=', 'capa.verifikator_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'capa.created_by')
                ->leftJoin('users as updater', 'updater.id', '=', 'capa.updated_by')
                ->leftJoin('capa_dept', 'capa_dept.capa_id','=','capa.id')
                ->select([
                    'capa.*','kepada.nama_departemen as kepada','kepada.kode_departemen as kode_kepada','dari.nama_departemen as dari','dari.kode_departemen as kode_dari',
                    'lokasi.lokasi','pic.name as pic','verifikator.name as verifikator','creator.name as creator','updater.name as updater','capa_dept.dept_id'
                ])
                ->groupBy('capa.id')
            ->get();
        }else{
            $model = DB::table('capa')
                ->leftJoin('m_departemen as kepada', 'kepada.id', '=', 'capa.kepada_id')
                ->leftJoin('m_departemen as dari', 'dari.id', '=', 'capa.dari_id')
                ->leftJoin('capa_lokasi as lokasi', 'lokasi.id', '=', 'capa.lokasi_id')
                ->leftJoin('users as pic', 'pic.id', '=', 'capa.pic_id')
                ->leftJoin('users as verifikator', 'verifikator.id', '=', 'capa.verifikator_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'capa.created_by')
                ->leftJoin('users as updater', 'updater.id', '=', 'capa.updated_by')
                ->leftJoin('capa_dept', 'capa_dept.capa_id','=','capa.id')
                ->select([
                    'capa.*','kepada.nama_departemen as kepada','kepada.kode_departemen as kode_kepada','dari.nama_departemen as dari','dari.kode_departemen as kode_dari',
                    'lokasi.lokasi','pic.name as pic','verifikator.name as verifikator','creator.name as creator','updater.name as updater', 'capa_dept.dept_id'
                ])
                ->where('capa_dept.dept_id', $user->dept_id)
                ->orWhere('capa.all_dept', 1)
                ->orWhere('capa.dari_id', $user->dept_id)
                ->orWhere('capa.kepada_id', $user->dept_id)
                ->groupBy('capa.id')
            ->get();
        }

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('created_at', function ($model){
                return date('d-m-Y', strtotime($model->created_at) );
            })
            ->editColumn('tgl_terjadi', function ($model){
                return date('d-m-Y', strtotime($model->tgl_terjadi) );
            })
            ->addColumn('kol-status', 'capa.kol-status')
            ->addColumn('upload', 'capa.upload')
            ->addColumn('action', 'capa.action')
            ->rawColumns(['action','upload'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $dept = Departemen::where('status',1)->orderBy('nama_departemen','ASC')->get();
        $lokasi = Lokasi::where('status',1)->orderBy('lokasi','ASC')->get();
        return view('capa.index',compact('dept','lokasi'));
    }

    public function create()
    {
        $departemens = Departemen::where('status',1)->orderBy('nama_departemen', 'ASC')->get();
        $karyawans = User::where('active',4)->orderBy('name','ASC')->get();
        $lokasis = Lokasi::where('status',1)->orderBy('lokasi','ASC')->get();
        return view('capa.create', compact('departemens','karyawans','lokasis'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $model = new CAPA;
        $capaterakhir = CAPA::orderBy('id', 'DESC')->first(); 

        if($capaterakhir == null){
            $hasil = "1";
        }else{
            $nomorterakhir = $capaterakhir->nomor;
            $pisah = explode('/', $nomorterakhir);

            if ((int)$pisah[3] > 0 && $pisah[2] != date('m')) {
               $hasil = "1";
            }else{
                $hasil = (int)$pisah[3]+1;    
            }
        }

        $nomor_fix = sprintf("%03s", $hasil);
        
        $nomorsurat= "CAPA/".date('y')."/".date('m')."/".$nomor_fix;
        $model->nomor  = $nomorsurat;

        $model->kepada_id        = $request->kepada_id;
        $model->dari_id          = $request->dari_id;
        $model->lokasi_id        = $request->lokasi_id;
        $model->tgl_terjadi      = $request->tgl_terjadi;
        $model->inti_masalah     = $request->inti_masalah;
        $model->rincian_masalah  = $request->rincian_masalah;
        $model->penyebab_masalah = $request->penyebab_masalah;
        $model->koreksi          = $request->koreksi;
        $model->pencegahan       = $request->pencegahan;
        $model->tgl_target       = $request->tgl_target;
        $model->pic_id           = $request->pic_id;
        $model->verifikator_id   = $request->verifikator_id;
        $model->tembusan_1       = $request->tembusan_1;
        $model->tembusan_2       = $request->tembusan_2;
        $model->created_by       = $user->id;
        $model->updated_by       = $user->id;

        //2 = centang
        if($request->kategori_1 == null){
            $model->kategori_1 = 1;
        }else{
            $model->kategori_1 = 2;
        }

        if($request->kategori_2 == null){
            $model->kategori_2 = 1;
        }else{
            $model->kategori_2 = 2;
        }
        
        if($request->kategori_3 == null){
            $model->kategori_3 = 1;
        }else{
            $model->kategori_3 = 2;
        }

        $model->save();
        //Dept terkait
        if($request->dept_id[0] == "ALL"){
            $model->all_dept = 1;
            $model->save();
        }else{
            $model->all_dept = 0;
            $model->save();
            $i = 0;
            foreach($request->dept_id as $row){
                $dept = new CapaDept;
                $dept->capa_id = $model->id;
                $dept->dept_id = $request->dept_id[$i];
                $dept->save();
                $i++;
            }
        }
        // return $request->all();
        return redirect()->route('capa.index')->withSuccess($model->nomor." berhasil ditambahkan");
    }

    public function edit($id)
    {
        $model = CAPA::findOrFail($id);
        $model_dept = CapaDept::where('capa_id',$model->id)->get();
        $departemens = Departemen::where('status',1)->orderBy('nama_departemen', 'ASC')->get();
        $karyawans = User::where('active',4)->orderBy('name','ASC')->get();
        $lokasis = Lokasi::where('status',1)->orderBy('lokasi','ASC')->get();
        
        return view('capa.edit', compact('model','model_dept','departemens','karyawans','lokasis'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $model = CAPA::findOrFail($id);

        $model->kepada_id        = $request->kepada_id;
        $model->dari_id          = $request->dari_id;
        $model->lokasi_id        = $request->lokasi_id;
        $model->tgl_terjadi      = $request->tgl_terjadi;
        $model->inti_masalah     = $request->inti_masalah;
        $model->rincian_masalah  = $request->rincian_masalah;
        $model->penyebab_masalah = $request->penyebab_masalah;
        $model->koreksi          = $request->koreksi;
        $model->pencegahan       = $request->pencegahan;
        $model->tgl_target       = $request->tgl_target;
        $model->pic_id           = $request->pic_id;
        $model->verifikator_id   = $request->verifikator_id;
        $model->tembusan_1       = $request->tembusan_1;
        $model->tembusan_2       = $request->tembusan_2;
        $model->updated_by       = $user->id;

        //2 = centang
        if($request->kategori_1 == null){
            $model->kategori_1 = 1;
        }else{
            $model->kategori_1 = 2;
        }

        if($request->kategori_2 == null){
            $model->kategori_2 = 1;
        }else{
            $model->kategori_2 = 2;
        }
        
        if($request->kategori_3 == null){
            $model->kategori_3 = 1;
        }else{
            $model->kategori_3 = 2;
        }

        $model_dept = CapaDept::where('capa_id',$model->id)->get();
        if($model_dept){
            $model_dept->each->delete();
        }

        //Dept terkait
        if($request->dept_id[0] == "ALL"){
            $model->all_dept = 1;
        }else{
            $model->all_dept = 0;
            $i = 0;
            foreach($request->dept_id as $row){
                $dept = new CapaDept;
                $dept->capa_id = $model->id;
                $dept->dept_id = $request->dept_id[$i];
                $dept->save();
                $i++;
            }
        }

        $model->save();

        return redirect()->route('capa.index')->withSuccess($model->nomor." berhasil diupdate");
    }

    public function destroy($id)
    {
        $model = CAPA::findOrFail($id);
        $model_dept = CapaDept::where('capa_id',$model->id)->get();
        
        if($model_dept){
            $model_dept->each->delete();
        }

        if($model->upload_file != null){
            Storage::delete("public/CAPA/".$model->upload_file);
        }

        $model->delete();
        return redirect()->route('capa.index')->withSuccess($model->nomor." berhasil dihapus");
    }

    public function print($id)
    {
        $model  = CAPA::findOrFail($id);
        $kepada = Departemen::where('id', $model->kepada_id)->first();
        $dari   = Departemen::where('id', $model->dari_id)->first();
        $pic    = User::where('id', $model->pic_id)->first();
        $verifikator = User::where('id', $model->verifikator_id)->first();

        $pdf = PDF::loadView('capa.print', compact('model','kepada','dari','pic','verifikator'));
        return $pdf->stream($model->nomor.'.pdf');
    }

    public function upload(Request $request, $id)
    {
        $model = CAPA::findOrFail($id);
        //upload file
        
            if($model->upload_file != null){
                Storage::delete("public/CAPA/".$model->upload_file);
            } 

            $nama_file = time().'_'.$request->file('upload_file')->getClientOriginalName();
            $path = Storage::putFileAs(
                'public/CAPA/', //direktori
                $request->file('upload_file'), //file
                $nama_file
            );
            
            $model->upload_file = $nama_file;
            $model->save();
        
        return redirect()->route('capa.index')->withSuccess($nama_file." berhasil diupload");
        // return response()->json($request);
        
    }
    
    public function download($id)
    {
        $model = CAPA::findOrFail($id);       
        return Storage::download("public/CAPA/".$model->upload_file);
    }

    public function show($id)
    {   
        $model = CAPA::findOrFail($id);       
        return Storage::response("public/CAPA/".$model->upload_file);       
    }

    public function resend($id)
    {
        $model = CAPA::findOrFail($id);
        $model->status = 1;
        $model->save();

        return redirect()->route('capa.index')->withSuccess($model->nomor." berhasil diajukan untuk verifikasi ulang");
    }
}
