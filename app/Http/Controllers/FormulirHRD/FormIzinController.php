<?php

namespace App\Http\Controllers\FormulirHRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormulirHRD\Form_Izin;
use App\User; use DB; use DataTables; use Auth; use PDF;use Storage;

class FormIzinController extends Controller
{
    public function json()
    {
        $user = Auth::user();

        if($user->hasPermissionTo('hrd-formulir-all')){
            $form = DB::table('hrd_izin')
            ->leftJoin('users', 'users.id', '=', 'hrd_izin.karyawan_id')
            ->leftJoin('users as creator', 'creator.id', '=', 'hrd_izin.created_by')
            ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
            ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
            ->select([
                'hrd_izin.id',
                'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan',
                'm_cabang.nama_cabang', 'hrd_izin.tanggal','hrd_izin.keperluan','hrd_izin.jam_masuk',
                'hrd_izin.jam_keluar', 'hrd_izin.keterangan','hrd_izin.nama_tujuan','hrd_izin.up_tujuan',
                'hrd_izin.tujuan_kunjungan','hrd_izin.informasi_tambahan','creator.name as pembuat','hrd_izin.created_at','hrd_izin.upload_file'
            ]);
        }elseif($user->hasPermissionTo('hrd-formulir-pic'))
        {
            $form = DB::table('hrd_izin')
            ->leftJoin('users', 'users.id', '=', 'hrd_izin.karyawan_id')
            ->leftJoin('users as creator', 'creator.id', '=', 'hrd_izin.created_by')
            ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
            ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
            ->select([
                'hrd_izin.id',
                'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan', 'users.atasan_id',
                'm_cabang.nama_cabang', 'hrd_izin.tanggal','hrd_izin.keperluan','hrd_izin.jam_masuk',
                'hrd_izin.jam_keluar', 'hrd_izin.keterangan','hrd_izin.nama_tujuan','hrd_izin.up_tujuan',
                'hrd_izin.tujuan_kunjungan','hrd_izin.informasi_tambahan','creator.name as pembuat','hrd_izin.created_at','hrd_izin.upload_file'
            ])->where('hrd_izin.created_by', '=', $user->id)
            ->orwhere('hrd_izin.karyawan_id', '=', $user->id)
            ->orwhere('users.atasan_id', '=', $user->id);
        }else{
            $form = DB::table('hrd_izin')
            ->leftJoin('users', 'users.id', '=', 'hrd_izin.karyawan_id')
            ->leftJoin('users as creator', 'creator.id', '=', 'hrd_izin.created_by')
            ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
            ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
            ->select([
                'hrd_izin.id',
                'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan',
                'm_cabang.nama_cabang', 'hrd_izin.tanggal','hrd_izin.keperluan','hrd_izin.jam_masuk',
                'hrd_izin.jam_keluar', 'hrd_izin.keterangan','hrd_izin.nama_tujuan','hrd_izin.up_tujuan',
                'hrd_izin.tujuan_kunjungan','hrd_izin.informasi_tambahan','creator.name as pembuat','hrd_izin.created_at','hrd_izin.upload_file'
            ])->where('hrd_izin.created_by', '=', $user->id)
            ->orwhere('hrd_izin.karyawan_id', '=', $user->id);
        }

        
        return DataTables::of($form)
            ->addIndexColumn()
            ->editColumn('keperluan', function ($form){
                if($form->keperluan == 1){
                    return 'Keluar kantor urusan pekerjaan';
                }elseif($form->keperluan == 2){
                    return 'Keluar kantor urusan pribadi';
                }elseif($form->keperluan == 3){
                    return 'Lambat datang';
                }elseif($form->keperluan == 4){
                    return 'Pulang awal';
                }
            })
            ->editColumn('tanggal', function ($form){
                return date('d-m-Y', strtotime($form->tanggal) );
            })
            ->editColumn('jam_masuk', function ($form){
                if($form->jam_masuk){
                    return '<center>'.date('H:i',strtotime($form->jam_masuk)).'</center>';
                }else{
                    return '<center>-</center>';
                }
            })
            ->editColumn('jam_keluar', function ($form){
                if($form->jam_keluar){
                    return '<center>'.date('H:i',strtotime($form->jam_keluar)).'</center>';
                }else{
                    return '<center>-</center>';
                }
            })
            ->addColumn('upload', 'formulirHRD.izin.upload')
            ->rawColumns(['upload'])
            ->addColumn('action', 'formulirHRD.izin.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('formulirHRD.izin.index');
    }

    public function create()
    {   
        $karyawans = User::where([['active','=','4'],['name','!=','Admin']])->orderBy('name','ASC')->get();
        return view('formulirHRD.izin.create', compact('karyawans'));
    }

    public function getKaryawan(Request $request)
    {
        if($request->ajax()){
            $karyawan = DB::table('users')
                ->leftJoin('m_departemen as dept', 'users.dept_id', '=', 'dept.id')
                ->leftJoin('m_cabang as cabang', 'users.cabang_id', '=', 'cabang.id')
                ->select([
                    'users.nik','users.jabatan', 'users.email',
                    'dept.nama_departemen','cabang.nama_cabang'
                ])->where('users.id',$request->karyawan)->first();
    		return response()->json($karyawan);
    	}
    }

    public function store(Request $request)
    {
        $form = new Form_Izin;
        $form->tanggal      = $request->tanggal;
        $form->karyawan_id  = $request->karyawan_id;
        $form->keperluan    = $request->keperluan;
        $form->keterangan   = $request->keterangan;
        $form->nama_tujuan  = $request->nama_tujuan;
        $form->up_tujuan    = $request->up_tujuan;
        $form->tujuan_kunjungan   = $request->tujuan_kunjungan;
        $form->informasi_tambahan = $request->informasi_tambahan;
        
        if($form->keperluan == 3){
            $form->jam_masuk  = $request->jam_masuk;
        }elseif($form->keperluan == 4){
            $form->jam_keluar = $request->jam_keluar;
        }else{
            $form->jam_keluar = $request->jam_keluar;
            $form->jam_masuk  = $request->jam_masuk;
        }
        $user = Auth::user();
        $form->created_by   = $user->id;
        $form->save();
        // return response()->json(['request' => $request->all(), 'model' => $form]);
        return redirect()->route('hrd.izin.index')->withSuccess('Formulir Izin Berhasil ditambahkan');
    }

    public function edit($id)
    {   
        $form = Form_Izin::findOrFail($id);
        $karyawans = User::where([['active','=','4'],['name','!=','Admin']])->orderBy('name','ASC')->get();
        return view('formulirHRD.izin.edit', compact('karyawans','form'));
    }

    public function update(Request $request, $id)
    {   
        $form = Form_Izin::findOrFail($id);
        $form->tanggal      = $request->tanggal;
        $form->karyawan_id  = $request->karyawan_id;
        $form->keperluan    = $request->keperluan;
        
        if($form->keperluan == 1){
            $form->keterangan   = null;
            $form->nama_tujuan  = $request->nama_tujuan;
            $form->up_tujuan    = $request->up_tujuan;
            $form->tujuan_kunjungan   = $request->tujuan_kunjungan;
            $form->informasi_tambahan = $request->informasi_tambahan;
            $form->jam_keluar = $request->jam_keluar;
            $form->jam_masuk  = $request->jam_masuk;
        }else{
            $form->keterangan   = $request->keterangan;
            $form->nama_tujuan  = null;
            $form->up_tujuan    = null;
            $form->tujuan_kunjungan   = null;
            $form->informasi_tambahan = null;
            if($form->keperluan == 3){
                $form->jam_keluar = null;
                $form->jam_masuk  = $request->jam_masuk;
            }elseif($form->keperluan == 4){
                $form->jam_keluar = $request->jam_keluar;
                $form->jam_masuk  = null;
            }else{
                $form->jam_keluar = $request->jam_keluar;
                $form->jam_masuk  = $request->jam_masuk;
            }
        }
  
        $form->save();
        return redirect()->route('hrd.izin.index')->withSuccess('Formulir Izin Berhasil diupdate');
    }

    public function upload(Request $request, $id)
    {
        $form = Form_Izin::findOrFail($id);
        //upload file
        
            if($form->upload_file != null){
                Storage::delete("public/FormIzin/".$form->upload_file);
                // File::delete('storage/app/Berita_Acara/barang_gudang/'.$ba->upload_file);
            } 
            $path = Storage::putFileAs(
                'public/FormIzin/', //direktori
                $request->file('upload_file'), //file
                time().'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = time().'_'.$request->file('upload_file')->getClientOriginalName();
            $form->upload_file = $nama_file;
            $form->save();
        
        return redirect()->route('hrd.izin.index')->withSuccess("Form Izin Berhasil di upload ");
        // return response()->json($request);
        
    }
    public function download($id)
    {
        $form = Form_Izin::findOrFail($id);       
        return Storage::download("public/FormIzin/".$form->upload_file);
    }

    public function show($id)
    {   
        $form = Form_Izin::findOrFail($id);       
        return Storage::response("public/FormIzin/".$form->upload_file);       

    }

    public function destroy($id)
    {
        $form = Form_Izin::findOrFail($id);
        $form->delete();
        return redirect()->route('hrd.izin.index')->withSuccess('Formulir Izin Berhasil dihapus');
    }

    public function print($id)
    {
        $form = Form_Izin::findOrFail($id);
        $pdf = PDF::loadView('formulirHRD.izin.print', compact('form'));

        return $pdf->stream('Form_Izin_'.$form->id.'.pdf');
    }
}
