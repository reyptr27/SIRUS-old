<?php

namespace App\Http\Controllers\FormulirHRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormulirHRD\Form_Cuti;
use App\Models\FormulirHRD\Form_Cuti_Detail;
use App\Models\FormulirHRD\Form_Cuti_Inventaris;
use App\User; use DB; use DataTables; use Auth; use PDF;use Storage;
class FormCutiController extends Controller
{
    public function json()
    {
        $user = Auth::user();
        if($user->hasPermissionTo('hrd-formulir-all')){
            $form = DB::table('hrd_cuti_header')
                ->leftJoin('users', 'users.id', '=', 'hrd_cuti_header.karyawan_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'hrd_cuti_header.created_by')
                ->leftJoin('users as pengganti', 'pengganti.id', '=', 'hrd_cuti_header.pengganti_id')
                ->leftJoin('users as controller', 'controller.id', '=', 'hrd_cuti_header.controller_id')
                ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
                ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
                ->select([
                    'hrd_cuti_header.id',
                   'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan',
                   'm_cabang.nama_cabang', 'hrd_cuti_header.tanggal_awal','hrd_cuti_header.tanggal_akhir',
                   'creator.name as pembuat','hrd_cuti_header.created_at','hrd_cuti_header.alasan','hrd_cuti_header.alamat',
                   'pengganti.name as nama_pengganti','controller.name as nama_controller', 'hrd_cuti_header.tanggal_bergabung','hrd_cuti_header.status_inventaris',
                    'hrd_cuti_header.no_telp','hrd_cuti_header.jenis_cuti','hrd_cuti_header.upload_file',
                ])
            ->orderBy('created_at', 'DESC');
        }elseif($user->hasPermissionTo('hrd-formulir-pic')){
            $form = DB::table('hrd_cuti_header')
                ->leftJoin('users', 'users.id', '=', 'hrd_cuti_header.karyawan_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'hrd_cuti_header.created_by')
                ->leftJoin('users as pengganti', 'pengganti.id', '=', 'hrd_cuti_header.pengganti_id')
                ->leftJoin('users as controller', 'controller.id', '=', 'hrd_cuti_header.controller_id')
                ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
                ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
                ->select([
                    'hrd_cuti_header.id',
                   'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan',
                   'm_cabang.nama_cabang', 'hrd_cuti_header.tanggal_awal','hrd_cuti_header.tanggal_akhir',
                   'creator.name as pembuat','hrd_cuti_header.created_at','hrd_cuti_header.alasan','hrd_cuti_header.alamat',
                   'pengganti.name as nama_pengganti','controller.name as nama_controller', 'hrd_cuti_header.tanggal_bergabung','hrd_cuti_header.status_inventaris',
                   'hrd_cuti_header.no_telp','hrd_cuti_header.jenis_cuti','hrd_cuti_header.upload_file',
                ])
                ->where(['hrd_cuti_header.created_by' => $user->id])
                ->orwhere(['hrd_cuti_header.karyawan_id' => $user->id])
                ->orwhere('users.atasan_id', '=', $user->id)
            ->orderBy('created_at', 'DESC');
        }
        else{
            $form = DB::table('hrd_cuti_header')
                ->leftJoin('users', 'users.id', '=', 'hrd_cuti_header.karyawan_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'hrd_cuti_header.created_by')
                ->leftJoin('users as pengganti', 'pengganti.id', '=', 'hrd_cuti_header.pengganti_id')
                ->leftJoin('users as controller', 'controller.id', '=', 'hrd_cuti_header.controller_id')
                ->leftJoin('m_departemen', 'm_departemen.id','=','users.dept_id')
                ->leftJoin('m_cabang', 'm_cabang.id','=','users.cabang_id')
                ->select([
                    'hrd_cuti_header.id',
                   'users.name', 'users.nik','m_departemen.nama_departemen', 'users.jabatan',
                   'm_cabang.nama_cabang', 'hrd_cuti_header.tanggal_awal','hrd_cuti_header.tanggal_akhir',
                   'creator.name as pembuat','hrd_cuti_header.created_at','hrd_cuti_header.alasan','hrd_cuti_header.alamat',
                   'pengganti.name as nama_pengganti','controller.name as nama_controller', 'hrd_cuti_header.tanggal_bergabung', 'hrd_cuti_header.status_inventaris',
                   'hrd_cuti_header.no_telp','hrd_cuti_header.jenis_cuti','hrd_cuti_header.upload_file',
                ])
                ->where(['hrd_cuti_header.created_by' => $user->id])
                ->orwhere(['hrd_cuti_header.karyawan_id' => $user->id])
            ->orderBy('created_at', 'DESC');
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
            ->editColumn('tanggal_bergabung', function ($form){
                return date('d-m-Y', strtotime($form->tanggal_bergabung) );
            })
            ->editColumn('created_at', function ($form){
                return date('d-m-Y', strtotime($form->created_at) );
            })
            ->addColumn('upload', 'formulirHRD.cuti.upload')
            ->rawColumns(['upload'])
            ->addColumn('kol_serah_terima', 'formulirHRD.cuti.kol_serah_terima')
            ->addColumn('action', 'formulirHRD.cuti.action')
            ->rawColumns(['action','kol_serah_terima'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('formulirHRD.cuti.index');
    }

    public function create()
    {
        $karyawans = User::where([['active','=','4'],['name','!=','Admin']])->orderBy('name','ASC')->get();
        return view('formulirHRD.cuti.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $form = new Form_Cuti;
        $user = Auth::user();
        $form->karyawan_id  = $request->karyawan_id;
        $form->tanggal_bergabung= $request->tanggal_bergabung;
        $form->tanggal_awal = $request->tanggal_awal;
        $form->tanggal_akhir= $request->tanggal_akhir;
        $form->alasan       = $request->alasan;
        $form->alamat       = $request->alamat;
        $form->status_inventaris= $request->status_inventaris;
        $form->no_telp      = $request->no_telp;
        $form->jenis_cuti   = $request->jenis_cuti;
        $form->pengganti_id = $request->pengganti_id;
        $form->controller_id= $request->controller_id;
        $form->created_by   = $user->id;
        $form->save();
        return redirect()->route('hrd.cuti.index')->withSuccess('Form Cuti berhasil ditambahkan');
    }

    public function edit($id)
    {   
        $form = Form_Cuti::findOrFail($id);
        $karyawans = User::where([['active','=','4'],['name','!=','Admin']])->orderBy('name','ASC')->get();
        return view('formulirHRD.cuti.edit', compact('karyawans','form'));
    }

    public function update(Request $request, $id)
    {
        $form = Form_Cuti::findOrFail($id);
        $form->karyawan_id  = $request->karyawan_id;
        $form->tanggal_bergabung= $request->tanggal_bergabung;
        $form->tanggal_awal = $request->tanggal_awal;
        $form->tanggal_akhir= $request->tanggal_akhir;
        $form->alasan       = $request->alasan;
        $form->alamat       = $request->alamat;
        $form->status_inventaris= $request->status_inventaris;
        $form->no_telp      = $request->no_telp;
        $form->jenis_cuti   = $request->jenis_cuti;
        $form->pengganti_id = $request->pengganti_id;
        $form->controller_id= $request->controller_id;
        $form->save();
        return redirect()->route('hrd.cuti.index')->withSuccess('Form Cuti berhasil diupdate');
    }

    public function showSerahterima($id)
    {
        $form = Form_Cuti::findOrFail($id);
        $karyawans = User::where([['active','=','4'],['name','!=','Admin']])->orderBy('name','ASC')->get();
        $cuti_detail = Form_Cuti_Detail::where(['cuti_id' => $form->id ])->get();

        return view('formulirHRD.cuti.serahterima')->with([
            'cuti_detail' => !empty($cuti_detail)?$cuti_detail:null,
            'karyawans' => $karyawans,
            'form' => $form
        ]);
    }

    public function storeSerahterima(Request $request, $id)
    {
        $form = Form_Cuti::findOrFail($id);
        $cuti_detail = Form_Cuti_Detail::where(['cuti_id' => $form->id ])->get();

        if($cuti_detail){
            $cuti_detail->each->delete();
        }
        $i = 0;
        foreach($request->deskripsi as $row){
            $det = new Form_Cuti_Detail;
            $det->cuti_id = $form->id;
            $det->deskripsi = $request->deskripsi[$i];
            $det->pengganti_id = $request->pengganti_id[$i];
            $det->controller_id = $request->controller_id[$i];
            $det->keterangan = $request->keterangan[$i];
            $det->save();
            $i++;
        }
        return redirect()->route('hrd.cuti.index')->withSuccess('Form Serah Terima Pekerjaan berhasil diupdate');
    }

    public function showInventaris($id)
    {
        $form = Form_Cuti::findOrFail($id);
        $inventaris = Form_Cuti_Inventaris::where(['cuti_id' => $form->id ])->first();

        return view('formulirHRD.cuti.inventaris')->with([
            'inventaris' => $inventaris,
            'form' => $form
        ]);
    }

    public function storeInventaris(Request $request, $id)
    {
        $form = Form_Cuti::findOrFail($id);
        $inventaris = Form_Cuti_Inventaris::where(['cuti_id' => $form->id ])->first();
        
        if(empty($inventaris)){
            $inventaris = new Form_Cuti_Inventaris;
        }

        $inventaris->cuti_id         = $id;
        $inventaris->jenis_kendaraan = $request->jenis_kendaraan;
        $inventaris->nomor_kendaraan = $request->nomor_kendaraan;
        $inventaris->kunci_stnk      = $request->kunci_stnk;
        $inventaris->tgl_serah       = $request->tgl_serah;
        $inventaris->tgl_kembali     = $request->tgl_kembali;
        $inventaris->lokasi_serah   = $request->lokasi_serah;
        $inventaris->save();

        return redirect()->route('hrd.cuti.index')->withSuccess('Form Serah Terima Inventaris berhasil diupdate');
    }


    public function upload(Request $request, $id)
    {
        $form = Form_Cuti::findOrFail($id);
        //upload file
        
            if($form->upload_file != null){
                Storage::delete("public/FormCuti/".$form->upload_file);
                // File::delete('storage/app/Berita_Acara/barang_gudang/'.$ba->upload_file);
            } 
            $path = Storage::putFileAs(
                'public/FormCuti/', //direktori
                $request->file('upload_file'), //file
                time().'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = time().'_'.$request->file('upload_file')->getClientOriginalName();
            $form->upload_file = $nama_file;
            $form->save();
        
        return redirect()->route('hrd.cuti.index')->withSuccess("Form Cuti Berhasil di upload ");
        // return response()->json($request);
        
    }
    public function download($id)
    {
        $form = Form_Cuti::findOrFail($id);       
        return Storage::download("public/FormCuti/".$form->upload_file);
    }

    public function show($id)
    {   
        $form = Form_Cuti::findOrFail($id);       
        return Storage::response("public/FormCuti/".$form->upload_file);       

    }
    public function destroy($id)
    {
        $form = Form_Cuti::findOrFail($id);
        $form->delete();
        return redirect()->route('hrd.cuti.index')->withSuccess('Form Cuti berhasil dihapus');
    }

    public function print($id)
    {
        $form = Form_Cuti::findOrFail($id);
        $cuti_detail = Form_Cuti_Detail::where(['cuti_id' => $form->id ])->get(); //*== null* tidak berfungsi untuk collection of object jadi harus menggunakan *@if(!$cuti_detail->isEmpty())*
        $inventaris = Form_Cuti_Inventaris::where(['cuti_id' => $form->id ])->first(); //dapat menggunakan *!= null* untuk 1 object

        $pdf = PDF::loadView('formulirHRD.cuti.print', compact('form', 'cuti_detail','inventaris'));
        return $pdf->stream('Form_Cuti_'.$form->id.'.pdf');
        // return $cuti_detail;
    }
}
