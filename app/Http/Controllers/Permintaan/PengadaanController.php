<?php

namespace App\Http\Controllers\Permintaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permintaan\Jenis_Permintaan;
use App\Models\Permintaan\Perbaikan;
use App\Models\Permintaan\Pengadaan;
use App\User;
use DB; use DataTables; use Auth;
use Barryvdh\DomPDF\Facade as PDF;


class PengadaanController extends Controller
{   
    public function json()
    {
        $login = Auth::user();
        if($login->hasPermissionTo('pengadaan-all')){
            $pengadaan = DB::table('pengadaan')
                    ->leftJoin('jenis_permintaan as jenis', 'pengadaan.jenis_id', '=', 'jenis.id')
                    ->leftJoin('users as pemohon', 'pengadaan.pemohon_id', '=', 'pemohon.id')
                    ->leftJoin('users as officer', 'pengadaan.officer_id', '=', 'officer.id')
                    ->leftJoin('m_departemen as dept','pemohon.dept_id','=','dept.id')
                    ->leftJoin('m_cabang as cabang','pemohon.cabang_id','=','cabang.id')
                    // ->leftJoin('pengadaan', 'pengadaan.pengadaan_id', '=', 'pengadaan.id')
                    ->leftJoin('users as pembuat', 'pengadaan.created_by', '=', 'pembuat.id')
                    ->leftJoin('users as updater', 'pengadaan.updated_by', '=', 'updater.id')
                    ->select([
                        'pengadaan.id','pengadaan.no_document',
                        'pengadaan.created_at', 'pengadaan.no_document as pengadaan',
                        'pengadaan.deskripsi','pengadaan.akibat', 'pengadaan.status', 'pengadaan.keterangan',
                        'pengadaan.updated_at',
                        'jenis.kode as jenis','jenis.spesifikasi as spesifikasi',
                         'pemohon.name as pemohon', 'pemohon.nik as nik', 'pemohon.jabatan',
                         'dept.nama_departemen as dept','cabang.nama_cabang as cabang',
                         'officer.name as officer',
                         'pembuat.name as pembuat','updater.name as updater'
                    ])->get();
        }
        else
        {
            $pengadaan = DB::table('pengadaan')
            ->leftJoin('jenis_permintaan as jenis', 'pengadaan.jenis_id', '=', 'jenis.id')
            ->leftJoin('users as pemohon', 'pengadaan.pemohon_id', '=', 'pemohon.id')
            ->leftJoin('users as officer', 'pengadaan.officer_id', '=', 'officer.id')
            ->leftJoin('m_departemen as dept','pemohon.dept_id','=','dept.id')
            ->leftJoin('m_cabang as cabang','pemohon.cabang_id','=','cabang.id')
            // ->leftJoin('pengadaan', 'pengadaan.pengadaan_id', '=', 'pengadaan.id')
            ->leftJoin('users as pembuat', 'pengadaan.created_by', '=', 'pembuat.id')
            ->leftJoin('users as updater', 'pengadaan.updated_by', '=', 'updater.id')
            ->select([
                        'pengadaan.id','pengadaan.no_document',
                        'pengadaan.created_at', 'pengadaan.no_document as pengadaan',
                        'pengadaan.deskripsi','pengadaan.akibat', 'pengadaan.status', 'pengadaan.keterangan',
                        'pengadaan.updated_at',
                        'jenis.kode as jenis','jenis.spesifikasi as spesifikasi',
                         'pemohon.name as pemohon', 'pemohon.nik as nik', 'pemohon.jabatan',
                         'dept.nama_departemen as dept','cabang.nama_cabang as cabang',
                         'officer.name as officer',
                         'pembuat.name as pembuat','updater.name as updater'
            ])->where('pengadaan.pemohon_id','=',$login->id)
            ->orwhere('pengadaan.created_by','=',$login->id)->get();
        
        }
        return DataTables::of($pengadaan)
            ->addIndexColumn()
            ->editColumn('created_at', function ($pengadaan){
                return date('d-m-Y', strtotime($pengadaan->created_at));
            })
            ->editColumn('status', function ($pengadaan){
                $login = Auth::user();
                if($login->dept_id == 1){
                    if($pengadaan->status == 1)                     
                        {return '<a data-target="#editstatus'.$pengadaan->id.
                        '" data-toggle="modal" href=#editstatus'.$pengadaan->id.
                        '" class="label label-warning">Approval user / atasan</a>';}
                    elseif($pengadaan->status == 2) 
                        {return '<a data-target="#editstatus'.$pengadaan->id.
                        '" data-toggle="modal" href=#editstatus'.$pengadaan->id.
                        '" class="label label-primary">Analisa IT</a>';}
                    elseif($pengadaan->status == 3)                         
                        {return '<a data-target="#editstatus'.$pengadaan->id.
                        '" data-toggle="modal" href=#editstatus'.$pengadaan->id.
                          '" class="label label-warning">Approval Kepala Divisi / BOM</a>';}
                    elseif($pengadaan->status == 4)                     
                        {return '<a data-target="#editstatus'.$pengadaan->id.
                            '" data-toggle="modal" href=#editstatus'.$pengadaan->id.
                                '" class="label label-primary">Analisa ITS Pusat</a>';}
                    elseif($pengadaan->status == 5)                     
                    {return '<a data-target="#editstatus'.$pengadaan->id.
                        '" data-toggle="modal" href=#editstatus'.$pengadaan->id.
                        '" class="label label-warning">Approval Pimpinan</a>';}
                    else
                    {return '<a data-target="#editstatus'.$pengadaan->id.
                        '" data-toggle="modal" href=#editstatus'.$pengadaan->id.
                        '" class="label label-success">Disetujui</a>';}

                }
                else{
                    if($pengadaan->status == 1) 
                    {return '<label for="" class="label label-warning">Approval user & atasan</label>';}
                    elseif($pengadaan->status == 2) 
                        {return '<label for="" class="label label-primary">Analisa IT</label>';}
                    elseif($pengadaan->status == 3) 
                        {return '<label for="" class="label label-warning">Approval Kepala Divisi / BOM</label>';}
                    elseif($pengadaan->status == 4) 
                        {return '<label for="" class="label label-primary">Analisa ITS Pusat</label>';}
                    elseif($pengadaan->status == 5) 
                        {return '<label for="" class="label label-warning">Approval Pimpinan</label>';}
                    else
                        {return '<label for="" class="label label-success">Disetujui</label>';}

                }
            })
            ->addColumn('action', 'permintaan.actionpengadaan') //mengambil dari blade view
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('permintaan.pengadaan');
    }

    public function create()
    {
        $jenis = Jenis_Permintaan::orderBy('kode','ASC')->get();
        $pemohons = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4']])->get();
        return view('permintaan.createpengadaan',compact('jenis','pemohons'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'pemohon_id' => 'required|int',
            'jenis_id' =>'required|int',
            'deskripsi' => 'required|string',
            'akibat' => 'required|string',
            
        ]);
        $login = Auth::user();
        $nomorterakhir = Pengadaan::Orderby('created_at','DESC')->first();
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $pengadaan = new Pengadaan;

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
        $nomordocument = "PENG-SBY/".date('Y')."/".$bulanRomawi[date('n')]."/".$datano;

        $pengadaan->no_document = $nomordocument;
        $pengadaan->pemohon_id = $request->pemohon_id;
        $pengadaan->jenis_id    = $request->jenis_id;
        $pengadaan->deskripsi = $request->deskripsi;
        $pengadaan->akibat  = $request->akibat;
        $pengadaan->created_by = $login->id;
        $pengadaan->save();
        
        return redirect(route('pengadaan.index'))->with(['success' => 'Data Pengadaan ' . $pengadaan->no_document . ' berhasil ditambahkan']);
    

    }

    public function updatestatus(Request $request, $id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        
        $pengadaan->status = $request->status;
        
        $pengadaan->save();

        return redirect()->back()->with('success', 'Status Pengadaan'.$pengadaan->no_document.' berhasil diupdate');
    }

    public function selectjenis(Request $request)
    {

        if($request->ajax()){
    		
            $jenis = Jenis_Permintaan::select('spesifikasi','id')->where('kode',$request
            ->jenis)->take(100)->get();
    		
    		return response()->json($jenis);
    	}
        
    }
    public function selectpemohon(Request $request)
    {
        

        if($request->ajax()){

            $pemohon = DB::table('users')
                ->leftJoin('m_departemen as dept', 'users.dept_id', '=', 'dept.id')
                ->leftJoin('m_cabang as cabang', 'users.cabang_id', '=', 'cabang.id')
                ->select([
                    'users.nik','users.jabatan', 'users.email',
                    'dept.nama_departemen','cabang.nama_cabang'
                ])->where('users.id',$request->pemohon)->first();
    		
            // $pemohon = User::select('spesifikasi','id')->where('kode',$request
            // ->jenis)->take(100)->get();
    		
    		return response()->json($pemohon);
    	}
        
    }
    

    public function edit($id)
    {   
        $pengadaan = DB::table('pengadaan')
                ->leftJoin('jenis_permintaan as jenis', 'pengadaan.jenis_id', '=', 'jenis.id')
                ->select([
                    'pengadaan.id','jenis.kode', 'pengadaan.pemohon_id',
                    'pengadaan.jenis_id','pengadaan.deskripsi','pengadaan.akibat'
                ])
                
                ->where('pengadaan.id',$id)->first();
        
        $jenis = Jenis_Permintaan::orderBy('kode','ASC')->where([['status','=','1'],['kode','=',$pengadaan->kode]])->get();
        
        // $jenis = Jenis_Permintaan::orderBy('kode','ASC')->where('status','=','1')->get();
        $pemohons = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4']])->get();
        return view('permintaan.editpengadaan', compact('pengadaan','pemohons','jenis'));
    }

    public function update(Request $request,$id)
    {

        $this->validate($request, [
            'pemohon_id' => 'required|int',
            'jenis_id' =>'required|int',
            'deskripsi' => 'required|string',
            'akibat' => 'required|string',
            
        ]);
        $login = Auth::user();
        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->pemohon_id = $request->pemohon_id;
        $pengadaan->jenis_id    = $request->jenis_id;
        $pengadaan->deskripsi = $request->deskripsi;
        $pengadaan->akibat  = $request->akibat;
        $pengadaan->updated_by = $login->id;        
        $pengadaan->save();
        
        return redirect(route('pengadaan.index'))
        ->with(['success' => 'Data Pengadaan ' . $pengadaan->no_document . ' berhasil diupdate']);
    }

    public function destroy($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->delete();
        return redirect()->back()->withSuccess($pengadaan->no_document.' Berhasil dihapus');
    }

    public function cetakPengadaan($id)
    {
        $pengadaan = Pengadaan::find($id);
        $jenis = Jenis_Permintaan::orderBy('kode', 'ASC')->where(['id' => $pengadaan->jenis_id ])->get();
        $users = User::orderBy('created_at', 'DESC')->where(['id' => $pengadaan->pemohon_id ])->get();
        $pembuats = User::orderBy('created_at', 'DESC')->where(['id' => $pengadaan->created_by ])->get();
        $pdf = PDF::loadView('permintaan.cetakpengadaan', compact('pengadaan', 'users' , 'jenis','pembuats'));

        return $pdf->stream($pengadaan->no_document.'.pdf');
    }


}
