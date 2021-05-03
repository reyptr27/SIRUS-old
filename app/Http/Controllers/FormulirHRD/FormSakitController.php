<?php

namespace App\Http\Controllers\FormulirHRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormulirHRD\Form_Sakit;
use App\User; use DB; use DataTables; use Auth; use PDF;use Storage;

class FormSakitController extends Controller
{
    public function json()
    {
        $user = Auth::user();

        if($user->hasPermissionTo('hrd-formulir-all')){
            $form = DB::table('hrd_sakit')
                ->leftJoin('users', 'users.id', '=', 'hrd_sakit.karyawan_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'hrd_sakit.created_by')
                ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
                ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
                ->select([
                    'hrd_sakit.id',
                   'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan',
                   'm_cabang.nama_cabang', 'hrd_sakit.tanggal_awal','hrd_sakit.tanggal_akhir','hrd_sakit.tanggal_masuk',
                   'creator.name as pembuat','hrd_sakit.created_at','hrd_sakit.upload_file'
                ])
                ->get();
        }elseif($user->hasPermissionTo('hrd-formulir-pic'))
        {
            $form = DB::table('hrd_sakit')
                ->leftJoin('users', 'users.id', '=', 'hrd_sakit.karyawan_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'hrd_sakit.created_by')
                ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
                ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
                ->select([
                    'hrd_sakit.id',
                   'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan',
                   'm_cabang.nama_cabang', 'hrd_sakit.tanggal_awal','hrd_sakit.tanggal_akhir','hrd_sakit.tanggal_masuk',
                   'creator.name as pembuat','hrd_sakit.created_at','hrd_sakit.upload_file'
                ])->where(['hrd_sakit.created_by' => $user->id])
                ->orwhere(['hrd_sakit.karyawan_id' => $user->id])
                ->orwhere('users.atasan_id', '=', $user->id)
                ->get();
        }
        else{
            $form = DB::table('hrd_sakit')
                ->leftJoin('users', 'users.id', '=', 'hrd_sakit.karyawan_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'hrd_sakit.created_by')
                ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
                ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
                ->select([
                    'hrd_sakit.id',
                   'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan',
                   'm_cabang.nama_cabang', 'hrd_sakit.tanggal_awal','hrd_sakit.tanggal_akhir','hrd_sakit.tanggal_masuk',
                   'creator.name as pembuat','hrd_sakit.created_at','hrd_sakit.upload_file'
                ])->where(['hrd_sakit.created_by' => $user->id])
                ->orwhere(['hrd_sakit.karyawan_id' => $user->id])
                ->get();
        }
        
        return DataTables::of($form)
            ->addIndexColumn()
            ->editColumn('tanggal_awal', function ($form){
                if($form->tanggal_awal == $form->tanggal_akhir){
                    return date('d-m-Y', strtotime($form->tanggal_awal) );
                }else{
                    return date('d-m-Y', strtotime($form->tanggal_awal)).' s/d <br>'.date('d-m-Y', strtotime($form->tanggal_akhir));
                }
                
            })
            ->editColumn('tanggal_masuk', function ($form){
                return date('d-m-Y', strtotime($form->tanggal_masuk) );
            })
            ->editColumn('created_at', function ($form){
                return date('d-m-Y', strtotime($form->created_at) );
            })
            ->addColumn('upload', 'formulirHRD.sakit.upload')
            ->rawColumns(['upload'])
            ->addColumn('action', 'formulirHRD.sakit.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('formulirHRD.sakit.index');
    }

    public function create()
    {
        $karyawans = User::where([['active','=','4'],['name','!=','Admin']])->orderBy('name','ASC')->get();
        return view('formulirHRD.sakit.create', compact('karyawans'));
    }

    public function store(Request $request)
    {   
        $form = new Form_Sakit;
        $user = Auth::user();
        $form->karyawan_id = $request->karyawan_id;
        $form->tanggal_awal = $request->tanggal_awal;
        $form->tanggal_akhir= $request->tanggal_akhir;
        $form->tanggal_masuk= $request->tanggal_masuk;
        $form->created_by   = $user->id; 
        $form->save();
        return redirect()->route('hrd.sakit.index')->withSuccess('Form Pemberitahuan Sakit berhasil ditambahkan');
    }

    public function edit($id)
    {
        $form = Form_Sakit::findOrFail($id);
        $karyawans = User::where([['active','=','4'],['name','!=','Admin']])->orderBy('name','ASC')->get();
        return view('formulirHRD.sakit.edit', compact('karyawans','form'));
    }

    public function update(Request $request, $id)
    {
        $form = Form_Sakit::findOrFail($id);
        $form->karyawan_id = $request->karyawan_id;
        $form->tanggal_awal = $request->tanggal_awal;
        $form->tanggal_akhir= $request->tanggal_akhir;
        $form->tanggal_masuk= $request->tanggal_masuk;
        $form->save();
        return redirect()->route('hrd.sakit.index')->withSuccess('Form Pemberitahuan Sakit berhasil diupdate');
    }

    public function upload(Request $request, $id)
    {
        $form = Form_Sakit::findOrFail($id);
        //upload file
        
            if($form->upload_file != null){
                Storage::delete("public/FormSakit/".$form->upload_file);
                // File::delete('storage/app/Berita_Acara/barang_gudang/'.$ba->upload_file);
            } 
            $path = Storage::putFileAs(
                'public/FormSakit/', //direktori
                $request->file('upload_file'), //file
                time().'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = time().'_'.$request->file('upload_file')->getClientOriginalName();
            $form->upload_file = $nama_file;
            $form->save();
        
        return redirect()->route('hrd.sakit.index')->withSuccess("Form Sakit Berhasil di upload ");
        // return response()->json($request);
        
    }
    public function download($id)
    {
        $form = Form_Sakit::findOrFail($id);       
        return Storage::download("public/FormSakit/".$form->upload_file);
    }

    public function show($id)
    {   
        $form = Form_Sakit::findOrFail($id);       
        return Storage::response("public/FormSakit/".$form->upload_file);       

    }

    public function destroy($id)
    {
        $form = Form_Sakit::findOrFail($id);
        $form->delete();
        return redirect()->route('hrd.sakit.index')->withSuccess('Form Pemberitahuan Sakit berhasil dihapus');
    }

    public function print($id)
    {
        $form = Form_Sakit::findOrFail($id);
        $pdf = PDF::loadView('formulirHRD.sakit.print', compact('form'));

        return $pdf->stream('Form_Sakit_'.$form->id.'.pdf');
    }
}
