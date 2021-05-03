<?php

namespace App\Http\Controllers\Nomorsurat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nomorsurat\Surat_eksternal;
use App\Models\Nomorsurat\No_eksternal;
use App\Models\Nomorsurat\Tujuan_eksternal;
use App\Models\Departemen;
use App\Models\Cabang;
use DataTables;
use DB; use Auth;

class SuratEksternalController extends Controller
{
    public function indexTujuan(){
        $tujuans = Tujuan_eksternal::orderBy('nama_tujuan', 'ASC')->get();
        
        return view('nomorsurat.tujuaneksternal', compact('tujuans'));
    }

    public function storeTujuan(Request $request){
        $tujuan = new Tujuan_eksternal;
        $tujuan->nama_tujuan = $request->nama_tujuan;
        $tujuan->status = $request->status;
        $tujuan->save();

        return redirect()->route('tujuan.eksternal.index')->with('success', 'Tujuan '.$tujuan->nama_tujuan.' berhasil ditambahkan');
    }

    public function updateTujuan(Request $request, $id){
        $tujuan = Tujuan_eksternal::find($id);
        $tujuan->nama_tujuan = $request->nama_tujuan;
        $tujuan->status = $request->status;
        $tujuan->save();

        return redirect()->route('tujuan.eksternal.index')->with('success', 'Tujuan '.$tujuan->nama_tujuan.' berhasil diupdate');
    }

    public function destroyTujuan($id){
        $tujuan = Tujuan_eksternal::find($id);
        $tujuan->delete();

        return redirect()->route('tujuan.eksternal.index')->with('success', 'Tujuan '.$tujuan->nama_tujuan.' berhasil dihapus');
    }

    public function json(){
        $user = Auth::user();

        if($user->hasPermissionTo('nomorsurat-eksternal-all')){
            $surat = DB::table('surat_eksternal')
            ->leftJoin('m_cabang', 'surat_eksternal.cabang_id', '=', 'm_cabang.id')
            ->leftJoin('m_departemen', 'surat_eksternal.dept_id', '=', 'm_departemen.id')
            ->leftJoin('tujuan_eksternal', 'surat_eksternal.tujuan_id', '=', 'tujuan_eksternal.id')
            ->leftJoin('users', 'surat_eksternal.created_by', '=', 'users.id')
            ->select([
                'surat_eksternal.id','surat_eksternal.no_surat','surat_eksternal.created_at',
                'surat_eksternal.dept_id','surat_eksternal.keterangan','tujuan_eksternal.nama_tujuan',
                'users.name','m_departemen.nama_departemen','m_departemen.kode_departemen'
            ])
            ->get();
    
        }else{
            $surat = DB::table('surat_eksternal')
            ->leftJoin('m_cabang', 'surat_eksternal.cabang_id', '=', 'm_cabang.id')
            ->leftJoin('m_departemen', 'surat_eksternal.dept_id', '=', 'm_departemen.id')
            ->leftJoin('tujuan_eksternal', 'surat_eksternal.tujuan_id', '=', 'tujuan_eksternal.id')
            ->leftJoin('users', 'surat_eksternal.created_by', '=', 'users.id')
            ->select([
                'surat_eksternal.id','surat_eksternal.no_surat','surat_eksternal.created_at',
                'surat_eksternal.dept_id','surat_eksternal.keterangan','tujuan_eksternal.nama_tujuan',
                'users.name','m_departemen.nama_departemen','m_departemen.kode_departemen'
            ])
            ->where([ 'surat_eksternal.dept_id' => $user->dept_id ])
            ->get();
    
        }

        return DataTables::of($surat)
            ->addIndexColumn()
            ->editColumn('created_at', function ($surat){
                return date('d-m-Y', strtotime($surat->created_at) );
            })
            ->editColumn('keterangan', function ($surat){
                if(!empty($surat->keterangan)){
                    return $surat->keterangan;
                }else{
                    return '<i>(kosong)</i>';
                }
            })
            ->addColumn('action', 'nomorsurat.eksternalaction') //mengambil dari blade view
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index(){
        return view('nomorsurat.surateksternal');
    }

    public function create(){
        $departemens    = Departemen::orderBy('nama_departemen', 'ASC')->where('status','=','1')->get();
        $cabangs        = Cabang::orderBy('nama_cabang', 'ASC')->where('status','=','1')->get();
        $tujuans        = Tujuan_eksternal::orderBy('nama_tujuan', 'ASC')->where('status','=','1')->get();
        return view('nomorsurat.eksternalcreate', compact('departemens','cabangs','tujuans'));
    }


    public function store(Request $request){
        
        $this->validate($request, [
            'tujuan_id'=> 'required',
            'cabang_id'=> 'required',
            'dept_id'=> 'required',
        ]);
        
        $surat = new Surat_eksternal;
        
        $surat->tujuan_id = $request->tujuan_id;
        $surat->cabang_id = $request->cabang_id;
        $surat->dept_id   = $request->dept_id;
        $surat->keterangan= $request->keterangan;
        $surat->created_by= $request->created_by;

        $cur_dept           = Departemen::where(['id' => $request->dept_id])->first();
        $cur_cabang         = Cabang::where(['id' => $request->cabang_id])->first();

        $now = date('Y-m');
        $ceknosurat = No_eksternal::where(
            ['dept_id' => $cur_dept->id,'cabang_id'=>$cur_cabang->id,'tgl'=>$now])
            ->orderBy('id','DESC')
            ->first();
        if ($ceknosurat == null) {
            $serial= '1';
        }else{
            $serial = substr($ceknosurat->no_surat,-4);
            $tahun_surat  = substr($ceknosurat->tgl,0,4);

            if($tahun_surat != substr($now,0,4)){
                $serial = '1';
            }else{
                $ser    = (int)$serial;
                $noser  = $ser + 1;
                $serial = $noser;
            }
        }
        $serial = sprintf("%04s", $serial);
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $surat->no_surat = $cur_dept->kode_departemen.'-'.$cur_cabang->kode_cabang.'/SRU/'.substr($now,0,4).'/'.$bulanRomawi[date('n')].'/'.$serial;
        $surat->save();
        
        $modelno           = new No_eksternal;
        $modelno->no_surat = $surat->no_surat;
        $modelno->dept_id  = $cur_dept->id;
        $modelno->cabang_id= $cur_cabang->id;
        $modelno->tgl      = $now;
        $modelno->save();
        // return dd($surat);
        return redirect()->route('surat.eksternal.index')->withSuccess('Surat eksternal ' .$surat->no_surat. ' berhasil ditambahkan');
    }

    public function edit($id){
        $surat = Surat_eksternal::findOrFail($id);
        $departemens    = Departemen::orderBy('nama_departemen', 'ASC')->where('status','=','1')->get();
        $cabangs        = Cabang::orderBy('nama_cabang', 'ASC')->where('status','=','1')->get();
        $tujuans        = Tujuan_eksternal::orderBy('nama_tujuan', 'ASC')->where('status','=','1')->get();
        return view('nomorsurat.eksternaledit', compact('surat','departemens','cabangs','tujuans'));
    }

    public function update(Request $request, $id){
        $surat = Surat_eksternal::findOrFail($id);

        $this->validate($request, [
            'tujuan_id'=> 'required',
        ]);

        $surat->tujuan_id = $request->tujuan_id;
        $surat->keterangan= $request->keterangan;
        $surat->save();
        return redirect()->route('surat.eksternal.index')->withSuccess('Surat eksternal ' .$surat->no_surat. ' berhasil diupdate');
    }

    public function destroy($id){
        $surat = Surat_eksternal::findOrFail($id);
        $surat->delete();
        
        return redirect()->route('surat.eksternal.index')->withSuccess('Surat eksternal ' .$surat->no_surat. ' berhasil dihapus');
    }
}
