<?php

namespace App\Http\Controllers\Permintaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permintaan\Jenis_Permintaan;
use App\Models\Permintaan\Perbaikan;
use App\Models\Permintaan\Pengadaan;
use App\Models\Permintaan\Program;
use App\User;
use DB; use DataTables; use Auth;
use Barryvdh\DomPDF\Facade as PDF;


class ProgramController extends Controller
{   
    public function json()
    {
        $login = Auth::user();
        if($login->dept_id == 1){
            $program = DB::table('program')
                    ->leftJoin('users as pemohon', 'program.pemohon_id', '=', 'pemohon.id')
                    ->leftJoin('users as officer', 'program.officer_id', '=', 'officer.id')
                    ->leftJoin('m_departemen as dept','pemohon.dept_id','=','dept.id')
                    ->leftJoin('m_cabang as cabang','pemohon.cabang_id','=','cabang.id')
                    ->leftJoin('users as kadept', 'program.kadept_id', '=', 'kadept.id')
                    ->leftJoin('users as pembuat', 'program.created_by', '=', 'pembuat.id')
                    ->leftJoin('users as updater', 'program.updated_by', '=', 'updater.id')
                    ->select([
                        'program.*',
                        
                         'pemohon.name as pemohon', 'pemohon.nik as nik', 'pemohon.jabatan',
                         'dept.nama_departemen as dept','cabang.nama_cabang as cabang',
                         'officer.name as officer',
                         'pembuat.name as pembuat','updater.name as updater',
                         'kadept.name as kadept'
                    ]);
        }
        else
        {
            $program = DB::table('program')
            
            ->leftJoin('users as pemohon', 'program.pemohon_id', '=', 'pemohon.id')
            ->leftJoin('users as officer', 'program.officer_id', '=', 'officer.id')
            ->leftJoin('m_departemen as dept','pemohon.dept_id','=','dept.id')
            ->leftJoin('m_cabang as cabang','pemohon.cabang_id','=','cabang.id')
            ->leftJoin('users as kadept', 'program.kadept_id', '=', 'kadept.id')
            ->leftJoin('users as pembuat', 'program.created_by', '=', 'pembuat.id')
            ->leftJoin('users as updater', 'program.updated_by', '=', 'updater.id')
            ->select([
                        'program.*',
                         'pemohon.name as pemohon', 'pemohon.nik as nik', 'pemohon.jabatan',
                         'dept.nama_departemen as dept','cabang.nama_cabang as cabang',
                         'officer.name as officer',
                         'pembuat.name as pembuat','updater.name as updater',
                         'kadept.name as kadept'
            ])->where('program.pemohon_id','=',$login->id)
            ->orwhere('program.created_by','=',$login->id)
            ->orwhere('pembuat.atasan_id','=',$login->id);
        
        }
        return DataTables::of($program)
            ->addIndexColumn()
            ->editColumn('created_at', function ($program){
                return date('d-m-Y', strtotime($program->created_at));
            })
            ->editColumn('jenis', function ($program){
                if($program->jenis == 1)
                    return 'Pengembangan Aplikasi';
                else
                    return 'Pembuatan Aplikasi Baru';
            })
            ->editColumn('approval', function ($program){
                $login = Auth::user();
                if($login->dept_id == 1){
                    if($program->approval == 1)                     
                        {return '<a data-target="#editstatus'.$program->id.
                        '" data-toggle="modal" href=#editstatus'.$program->id.
                        '" class="label label-warning">Approval user / atasan</a>';}
                    elseif($program->approval == 2) 
                        {return '<a data-target="#editstatus'.$program->id.
                        '" data-toggle="modal" href=#editstatus'.$program->id.
                        '" class="label label-primary">Analisa IT</a>';}
                    elseif($program->approval == 3)                         
                        {return '<a data-target="#editstatus'.$program->id.
                        '" data-toggle="modal" href=#editstatus'.$program->id.
                          '" class="label label-warning">Approval Kepala Divisi / BOM</a>';}
                    elseif($program->approval == 4)                     
                        {return '<a data-target="#editstatus'.$program->id.
                            '" data-toggle="modal" href=#editstatus'.$program->id.
                                '" class="label label-primary">Analisa ITS Pusat</a>';}
                    elseif($program->approval == 5)                     
                    {return '<a data-target="#editstatus'.$program->id.
                        '" data-toggle="modal" href=#editstatus'.$program->id.
                        '" class="label label-warning">Approval Pimpinan</a>';}
                    elseif($program->approval == 6)                     
                    {return '<a data-target="#editstatus'.$program->id.
                        '" data-toggle="modal" href=#editstatus'.$program->id.
                        '" class="label label-success">Disetujui</a>';}
                    elseif($program->approval == 7) 
                        {return '<a data-target="#editstatus'.$program->id.
                        '" data-toggle="modal" href=#editstatus'.$program->id.
                        '" class="label label-primary">Proses Pengembangan oleh IT</a>';}
                    else
                        {return '<a data-target="#editstatus'.$program->id.
                        '" data-toggle="modal" href=#editstatus'.$program->id.
                        '" class="label label-success">Selesai</a>';}

                }
                else{
                    if($program->approval == 1) 
                    {return '<label for="" class="label label-warning">Approval user & atasan</label>';}
                    elseif($program->approval == 2) 
                        {return '<label for="" class="label label-primary">Verifikasi IT</label>';}
                    elseif($program->approval == 3) 
                        {return '<label for="" class="label label-warning">Verifikasi Operational Improvement/label>';}
                    elseif($program->approval == 4) 
                        {return '<label for="" class="label label-primary">Approval Operational Manager</label>';}
                    elseif($program->approval == 5) 
                        {return '<label for="" class="label label-warning">Approval Branch Office Manager / BOM</label>';}
                    elseif($program->approval == 6) 
                        {return '<label for="" class="label label-success">Disetujui</label>';}
                    elseif($program->approval == 7) 
                        {return '<label for="" class="label label-primary">Proses Pengmbangan oleh IT</label>';}
                    else
                        {return '<label for="" class="label label-success">Selesai</label>';}

                }
            })
            ->addColumn('action', 'permintaan.actionprogram') //mengambil dari blade view
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);

        
    }

    public function index()
    {
        return view('permintaan.program');
    }

    public function create()
    {
        $pemohons = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4']])->get();
        return view('permintaan.createprogram',compact('pemohons'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'pemohon_id' => 'required|int',
            'program' => 'required|string',
            'alasan' => 'required|string',
            
        ]);
        $login = Auth::user();
        $nomorterakhir = Program::Orderby('created_at','DESC')->first();
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $program = new Program;

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
        $nomordocument = "PROG-SBY/".date('Y')."/".$bulanRomawi[date('n')]."/".$datano;

        $program->no_document = $nomordocument;
        $program->pemohon_id = $request->pemohon_id;
        $program->kadept_id = $request->kadept_id;
        $program->jenis    = $request->jenis;
        $program->program = $request->program;
        $program->alasan  = $request->alasan;
        $program->created_by = $login->id;
        $program->hasil = 0;
        $program->approval = 1 ;
        $program->save();
        
        return redirect(route('program.index'))->with(['success' => 'Data Pengajuan Program ' . $program->no_document . ' berhasil ditambahkan']);
    

    }

    public function updatestatus(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $program->approval = $request->status;
        
        $program->save();

        return redirect()->back()->with('success', 'Status Program'.$program->no_document.' berhasil diupdate');
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
        $program = Program::findOrFail($id);
        $pengadaan = DB::table('pengadaan')
                ->leftJoin('jenis_permintaan as jenis', 'pengadaan.jenis_id', '=', 'jenis.id')
                ->select([
                    'pengadaan.id','jenis.kode', 'pengadaan.pemohon_id',
                    'pengadaan.jenis_id','pengadaan.deskripsi','pengadaan.akibat'
                ])
                
                ->where('pengadaan.id',$id)->first();
        
        // $jenis = Jenis_Permintaan::orderBy('kode','ASC')->where('status','=','1')->get();
        $pemohons = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4']])->get();
        return view('permintaan.editprogram', compact('program','pemohons'));
    }

    public function update(Request $request,$id)
    {

        $this->validate($request, [
            'pemohon_id' => 'required|int',
            'program' => 'required|string',
            'alasan' => 'required|string',
            
        ]);
        $login = Auth::user();
        $program = Program::findOrFail($id);
        $program->pemohon_id = $request->pemohon_id;
        $program->kadept_id = $request->kadept_id;
        $program->jenis    = $request->jenis;
        $program->program = $request->program;
        $program->alasan  = $request->alasan;
        $program->created_by = $login->id;
        $program->save();
        
        
        return redirect(route('program.index'))
        ->with(['success' => 'Data Pengajuan Program ' . $program->no_document . ' berhasil diupdate']);
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();
        return redirect()->back()->withSuccess($program->no_document.' Berhasil dihapus');
    }

    public function cetakProgram($id)
    {
        $program = Program::find($id);
        $pemohons = User::orderBy('created_at', 'DESC')->where(['id' => $program->pemohon_id ])->get();
        $kadepts = User::orderBy('created_at', 'DESC')->where(['id' => $program->kadept_id ])->get();
        $officers = User::orderBy('created_at', 'DESC')->where(['id' => $program->officer_id ])->get();
        $improvements = User::orderBy('created_at', 'DESC')->where(['id' => $program->improvement_id ])->get();
        $oms = User::orderBy('created_at', 'DESC')->where(['id' => 37 ])->get();
        $boms = User::orderBy('created_at', 'DESC')->where(['id' => 52 ])->get();
        $pdf = PDF::loadView('permintaan.cetakprogram', 
        compact('program', 'pemohons' , 'kadepts','officers','improvements','oms','boms'));

        return $pdf->stream($program->no_document.'.pdf');
    }


}
