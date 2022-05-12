<?php

namespace App\Http\Controllers\Permintaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permintaan\Jenis_Permintaan;
use App\Models\Permintaan\Perbaikan;
use App\Models\Permintaan\Pengadaan;
use App\User;
use DB; use DataTables; use Auth; use PDF;
// use Barryvdh\DomPDF\Facade as PDF;


class PerbaikanController extends Controller
{   
    public function json()
    {   
        $login = Auth::user();
        if($login->hasPermissionTo('perbaikan-all')){
            $perbaikan = DB::table('perbaikan')
                    ->leftJoin('jenis_permintaan as jenis', 'perbaikan.jenis_id', '=', 'jenis.id')
                    ->leftJoin('users as pemohon', 'perbaikan.pemohon_id', '=', 'pemohon.id')
                    ->leftJoin('users as officer', 'perbaikan.officer_id', '=', 'officer.id')
                    ->leftJoin('m_departemen as dept','pemohon.dept_id','=','dept.id')
                    ->leftJoin('m_cabang as cabang','pemohon.cabang_id','=','cabang.id')
                    // ->leftJoin('pengadaan', 'pengadaan.pengadaan_id', '=', 'pengadaan.id')
                    ->leftJoin('users as pembuat', 'perbaikan.created_by', '=', 'pembuat.id')
                    ->leftJoin('users as updater', 'perbaikan.updated_by', '=', 'updater.id')
                    ->select([
                        'perbaikan.id','perbaikan.no_document',
                        'perbaikan.created_at', 'perbaikan.no_document as perbaikan',
                        'perbaikan.deskripsi','perbaikan.akibat', 'perbaikan.status', 'perbaikan.keterangan',
                        'perbaikan.updated_at',
                        'jenis.kode as jenis','jenis.spesifikasi as spesifikasi',
                         'pemohon.name as pemohon', 'pemohon.nik as nik', 'pemohon.jabatan',
                         'dept.nama_departemen as dept','cabang.nama_cabang as cabang',
                         'officer.name as officer',
                         'pembuat.name as pembuat' ,'updater.name as updater'
                    ]);
        }
        else
        {
            $perbaikan = DB::table('perbaikan')
            ->leftJoin('jenis_permintaan as jenis', 'perbaikan.jenis_id', '=', 'jenis.id')
            ->leftJoin('users as pemohon', 'perbaikan.pemohon_id', '=', 'pemohon.id')
            ->leftJoin('users as officer', 'perbaikan.officer_id', '=', 'officer.id')
            ->leftJoin('m_departemen as dept','pemohon.dept_id','=','dept.id')
            ->leftJoin('m_cabang as cabang','pemohon.cabang_id','=','cabang.id')
            // ->leftJoin('pengadaan', 'pengadaan.pengadaan_id', '=', 'pengadaan.id')
            ->leftJoin('users as pembuat', 'perbaikan.created_by', '=', 'pembuat.id')
            ->leftJoin('users as updater', 'perbaikan.updated_by', '=', 'updater.id')
            ->select([
                        'perbaikan.id','perbaikan.no_document',
                        'perbaikan.created_at', 'perbaikan.no_document as perbaikan',
                        'perbaikan.deskripsi','perbaikan.akibat', 'perbaikan.status', 'perbaikan.keterangan',
                        'perbaikan.updated_at',
                        'jenis.kode as jenis','jenis.spesifikasi as spesifikasi',
                         'pemohon.name as pemohon', 'pemohon.nik as nik', 'pemohon.jabatan',
                         'dept.nama_departemen as dept','cabang.nama_cabang as cabang',
                         'officer.name as officer',
                         'pembuat.name as pembuat','updater.name as updater'
            ])->where('perbaikan.pemohon_id','=',$login->id)
            ->orwhere('perbaikan.created_by','=',$login->id);
        
        }
                
        
        return DataTables::of($perbaikan)
            ->addIndexColumn()
            ->editColumn('created_at', function ($perbaikan){
                return date('d-m-Y', strtotime($perbaikan->created_at));
            })
            ->editColumn('status', function ($perbaikan){
                $login = Auth::user();
                if($login->dept_id == 1){
                    if($perbaikan->status == 1)                     
                        {return '<a data-target="#editstatus'.$perbaikan->id.
                        '" data-toggle="modal" href=#editstatus'.$perbaikan->id.
                        '" class="label label-warning">Approval user / atasan</a>';}
                    elseif($perbaikan->status == 2) 
                        {return '<a data-target="#editstatus'.$perbaikan->id.
                        '" data-toggle="modal" href=#editstatus'.$perbaikan->id.
                        '" class="label label-primary">Analisa IT</a>';}
                    elseif($perbaikan->status == 3)                         
                        {return '<a data-target="#editstatus'.$perbaikan->id.
                        '" data-toggle="modal" href=#editstatus'.$perbaikan->id.
                          '" class="label label-warning">Approval Kepala Divisi / BOM</a>';}
                    elseif($perbaikan->status == 4)                     
                        {return '<a data-target="#editstatus'.$perbaikan->id.
                            '" data-toggle="modal" href=#editstatus'.$perbaikan->id.
                                '" class="label label-primary">Analisa ITS Pusat</a>';}
                    elseif($perbaikan->status == 5)                     
                    {return '<a data-target="#editstatus'.$perbaikan->id.
                        '" data-toggle="modal" href=#editstatus'.$perbaikan->id.
                        '" class="label label-warning">Approval Pimpinan</a>';}
                    else
                    {return '<a data-target="#editstatus'.$perbaikan->id.
                        '" data-toggle="modal" href=#editstatus'.$perbaikan->id.
                        '" class="label label-success">Disetujui</a>';}                     

                }
                else{
                    return '<a data-target="#lihatstatus'.$perbaikan->id.
                        '" data-toggle="modal" href=#lihatstatus'.$perbaikan->id.
                        '" class="label label-default">Lihat Status</a>';
                }
            })
            ->addColumn('action', 'permintaan.actionperbaikan') //mengambil dari blade view
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('permintaan.perbaikan');
    }

    public function create()
    {
        $jenis = Jenis_Permintaan::orderBy('kode','ASC')->get();
        $pemohons = User::orderBy('name', 'ASC')->where([['name','!=','Admin'],['active','=','4']])->get();
        return view('permintaan.createperbaikan',compact('jenis','pemohons'));
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

        $nomorterakhir = Perbaikan::Orderby('created_at','DESC')->first();
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $perbaikan = new Perbaikan;

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
        $nomordocument = "PERB-SBY/".date('Y')."/".$bulanRomawi[date('n')]."/".$datano;

        $perbaikan->no_document = $nomordocument;
        $perbaikan->pemohon_id = $request->pemohon_id;
        $perbaikan->jenis_id    = $request->jenis_id;
        $perbaikan->deskripsi = $request->deskripsi;
        $perbaikan->akibat  = $request->akibat;
        $perbaikan->created_by = $login->id;
                
        

        // untuk menyimpan pengadaan
        $nomorterakhir1 = Pengadaan::Orderby('created_at','DESC')->first();
        $pengadaan = new Pengadaan;

        if($nomorterakhir1 == null){
            $hasil1 = "1";

        }else{
            $nomor1 = $nomorterakhir1->no_document;
            $pisah1 = explode('/',$nomor1);

            if((int)$pisah1[3] > 0 && $pisah1[1] != date('Y')){
                $hasil1='1';
            }else{
                $hasil1=(int)$pisah1[3]+1;

            }
        }
        $datano1 = sprintf("%04s" , $hasil);
        $nomordocument1 = "PENG-SBY/".date('Y')."/".$bulanRomawi[date('n')]."/".$datano1;

        $jenispengajuan = Jenis_Permintaan::find($request->jenis_id);
        $pemohon = User::find($request->pemohon_id);

        $pengadaan->no_document = $nomordocument1;
        $pengadaan->pemohon_id = $request->pemohon_id;
        $pengadaan->jenis_id    = $request->jenis_id;
        $pengadaan->deskripsi = $request->deskripsi;
        $pengadaan->akibat  = $request->akibat;
        $pengadaan->created_by = $login->id;
        
        
        $pengadaan->save();

        $idterakhir = Pengadaan::Orderby('created_at','DESC')->first();
        $perbaikan->pengadaan_id = $idterakhir->id;
        $perbaikan->save();
        
        return redirect(route('perbaikan.index'))->with(['success' => 'Data Perbaikan ' . $perbaikan->no_document . ' berhasil ditambahkan']);
    

    }
    


       
    public function edit($id)
    {
        $perbaikan = DB::table('perbaikan')
                ->leftJoin('jenis_permintaan as jenis', 
                'perbaikan.jenis_id', '=', 'jenis.id')
                ->select([
                    'perbaikan.id','jenis.kode', 'perbaikan.pemohon_id',
                    'perbaikan.jenis_id','perbaikan.deskripsi','perbaikan.akibat'
                ])
                
                ->where('perbaikan.id',$id)->first();
        // $perbaikan = Perbaikan::find($id);
        $jenis = Jenis_Permintaan::orderBy('kode','ASC')
        ->where('status','=','1')->orwhere('kode','=',$perbaikan->kode)->get();
        $pemohons = User::orderBy('name', 'ASC')
        ->where([['name','!=','Admin'],['active','=','4']])->get();
        return view('permintaan.editperbaikan', compact('perbaikan','pemohons','jenis'));
    }

    public function updatestatus(Request $request, $id)
    {
        $perbaikan = Perbaikan::findOrFail($id);
        
        $perbaikan->status = $request->status;
        if($perbaikan->pengadaan_id != null){
            $pengadaan = Pengadaan::findOrFail($perbaikan->pengadaan_id);
            $pengadaan->status = $request->status;
            $pengadaan->save();
        }
        $perbaikan->save();

        return redirect()->back()->with('success', 'Status Perbaikan'.$perbaikan->no_document.' berhasil diupdate');
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
        $perbaikan = Perbaikan::findOrFail($id);
        $perbaikan->pemohon_id = $request->pemohon_id;
        $perbaikan->jenis_id    = $request->jenis_id;
        $perbaikan->deskripsi = $request->deskripsi;
        $perbaikan->akibat  = $request->akibat;
        $perbaikan->updated_by = $login->id;

        if($perbaikan->pengadaan_id != null){
            $jenispengajuan = Jenis_Permintaan::find($request->jenis_id);
            $pemohon = User::find($request->pemohon_id);

            $pengadaan = Pengadaan::findOrFail($perbaikan->pengadaan_id);
            $pengadaan->pemohon_id = $request->pemohon_id;
            $pengadaan->jenis_id    = $request->jenis_id;
            $pengadaan->deskripsi = $request->deskripsi;
            $pengadaan->akibat  = $request->akibat;
            $pengadaan->updated_by = $login->id;        
            $pengadaan->save();
        }
                
        $perbaikan->save();
        
        return redirect(route('perbaikan.index'))
        ->with(['success' => 'Data Perbaikan ' . $perbaikan->no_document . ' berhasil diupdate']);
    }

    public function destroy($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);
        if($perbaikan->pengadaan_id != null){
        $pengadaan = Pengadaan::findOrFail($perbaikan->pengadaan_id);
        $pengadaan->delete();
        }
        $perbaikan->delete();
        
        return redirect()->back()->withSuccess($perbaikan->no_document.' Berhasil dihapus');
    }

   
    public function cetakPerbaikan($id)
    {
        $perbaikan = Perbaikan::find($id);
        $pengadaan = Pengadaan::find($perbaikan->pengadaan_id);
        $jenis = Jenis_Permintaan::orderBy('kode', 'ASC')
        ->where(['id' => $perbaikan->jenis_id ])->get();
        $users = User::orderBy('created_at', 'DESC')->where(['id' => $perbaikan->pemohon_id ])->get();
        $pembuats = User::orderBy('created_at', 'DESC')->where(['id' => $perbaikan->created_by ])->get();
        $pdf = PDF::loadView('permintaan.cetakperbaikan', compact('perbaikan','pengadaan', 'users' , 'jenis','pembuats'));

        return $pdf->stream($perbaikan->no_document.'.pdf');
    }


}
