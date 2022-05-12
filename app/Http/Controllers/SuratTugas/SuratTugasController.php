<?php

namespace App\Http\Controllers\SuratTugas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Surattugas\Tujuan_St;
use App\Models\Surattugas\Surat_Tujuan;
use App\Models\Surattugas\Surat_Pegawai;
use App\Models\Surattugas\Surat_Tugas;
use App\Models\Surattugas\Surat_Tugas_Tanggal;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use DB; use DataTables; use Validator; use Auth;

class SuratTugasController extends Controller
{
    public function json(){
        $user = Auth::user();

        if($user->hasPermissionTo('surat-tugas-all')){
            $surat = DB::table('surat_tugas')
            ->select([
            '*'
            ]);
            
            return DataTables::of($surat)
                ->addIndexColumn()
                ->editColumn('nomor_surat', function ($surat){
                    return '07.'.$surat->nomor_surat;
                })
                ->editColumn('created_at', function ($surat){
                    return date('d-m-Y', strtotime($surat->created_at) );
                })
                ->addColumn('kol-karyawan', 'surat_tugas.kol-karyawan')
                ->addColumn('kol-tujuan', 'surat_tugas.kol-tujuan')
                ->addColumn('kol-tanggal', 'surat_tugas.kol-tanggal')
                ->addColumn('kol-approval', 'surat_tugas.kol-approval')
                ->addColumn('action', 'surat_tugas.action')
                ->rawColumns(['action','kol-pegawai','kol-tujuan','kol-tanggal','kol-approval'])
                ->escapeColumns([]) //untuk mengaplikasikan html syntax
            ->make(true);
        }else{
            $surat = DB::table('surat_tugas')
            ->select([
            '*'
            ])->where(['created_by' => $user->id]);
            
            return DataTables::of($surat)
                ->addIndexColumn()
                ->editColumn('nomor_surat', function ($surat){
                    return '07.'.$surat->nomor_surat;
                })
                ->editColumn('created_at', function ($surat){
                    return date('d-m-Y', strtotime($surat->created_at) );
                })
                ->addColumn('kol-karyawan', 'surat_tugas.kol-karyawan')
                ->addColumn('kol-tujuan', 'surat_tugas.kol-tujuan')
                ->addColumn('kol-tanggal', 'surat_tugas.kol-tanggal')
                ->addColumn('kol-approval', 'surat_tugas.kol-approval')
                ->addColumn('action', 'surat_tugas.action')
                ->rawColumns(['action','kol-pegawai','kol-tujuan','kol-tanggal','kol-approval'])
                ->escapeColumns([]) //untuk mengaplikasikan html syntax
            ->make(true);
        }
    }

    public function index()
    {
        return view('surat_tugas.index');
    }

    public function create()
    {   
        $pegawais = User::where([['active', '=', 4],['name','!=','Admin']])->orderBy('name', 'ASC')->get();
        $tujuans  = Tujuan_St::where(['status' => 1])->orderBy('nama_tujuan', 'ASC')->get();
        
        return view('surat_tugas.create', compact('pegawais','tujuans'));
    }

    public function store(Request $request)
    {   
        $user = Auth::user();
        $suratterakhir = Surat_Tugas::orderBy('id', 'DESC')->first(); 
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        $surat = new Surat_Tugas;

        if($suratterakhir == null){
            $hasil = "1";
        }else{
            $nomor = $suratterakhir->nomor_surat;
            $pisah = explode('/', $nomor);

            if ((int)$pisah[0] > 0 && $pisah[3] != date('Y')) {
               $hasil = "1";
            }else{
                $hasil = (int)$pisah[0]+1;    
            }
        }

        $datano = sprintf("%04s", $hasil);
        $nomor_surat=$datano."/SRU.ST/".$bulanRomawi[date('n')]."/".date('Y');
        
        $surat->nomor_surat = $nomor_surat;
        $surat->jabatan     = $request->jabatan;
        $surat->nomor_polisi= $request->nomor_polisi;
        $surat->kegiatan    = $request->kegiatan;
        $surat->opsi_tanggal= $request->opsi_tanggal;
        $surat->status_ttd  = $request->status_ttd;
        $surat->created_by  = $user->id;
        $surat->save();

        if($surat->opsi_tanggal == 1){
            $surat->tanggal_awal = $request->tanggal_awal;
            $surat->tanggal_akhir= $request->tanggal_akhir;
            $surat->save();
        }else{
            $i = 0;
            foreach($request->tanggal as $row){
                $date = new Surat_Tugas_Tanggal;
                $date->surat_tugas_id = $surat->id;
                $date->tanggal = $request->tanggal[$i];
                $date->save();
                $i++;
            }
        }

        $i = 0;
        foreach($request->pegawai_id as $row){
            $peg = new Surat_Pegawai;
            $peg->surat_tugas_id = $surat->id;
            $peg->pegawai_id = $request->pegawai_id[$i];
            $peg->save();
            $i++;
        }

        $i = 0;
        foreach($request->tujuan_id as $row){
            $tujuan = new Surat_Tujuan;
            $tujuan->surat_tugas_id = $surat->id;
            $tujuan->tujuan_id = $request->tujuan_id[$i];
            $tujuan->save();
            $i++;
        }

        return redirect()->route('surattugas.index')->withSuccess($surat->nomor_surat.' Berhasil ditambahkan');
    }

    public function edit($id)
    {   
        $surat = Surat_Tugas::findOrFail($id);
        $pegawais = User::where([['active', '=', 4],['name','!=','Admin']])->orderBy('name', 'ASC')->get();
        $tujuans  = Tujuan_St::where(['status' => 1])->orderBy('nama_tujuan', 'ASC')->get();
        
        $this_pegawais = Surat_Pegawai::where(['surat_tugas_id' => $id])->get();
        $this_tujuans = Surat_Tujuan::where(['surat_tugas_id' => $id])->get();
        if($surat->opsi_tanggal == 2){
            $this_tanggal = Surat_Tugas_Tanggal::where(['surat_tugas_id' => $id])->get();
        }
        
        return view('surat_tugas.edit')->with([
            'pegawais' => $pegawais,
            'tujuans' => $tujuans,
            'surat' => $surat,
            'this_tanggal' => !empty($this_tanggal)?$this_tanggal:'',
            'this_pegawais' => $this_pegawais,
            'this_tujuans' => $this_tujuans
        ]); 
    }

    public function update(Request $request, $id)
    {
        $surat = Surat_Tugas::findOrFail($id);

        $surat->jabatan     = $request->jabatan;
        $surat->nomor_polisi= $request->nomor_polisi;
        $surat->kegiatan    = $request->kegiatan;
        $surat->opsi_tanggal= $request->opsi_tanggal;
        $surat->status_ttd  = $request->status_ttd;
        $surat->save();

        //cek collection tanggal yg exist
        $tanggal = Surat_Tugas_Tanggal::where(['surat_tugas_id' => $id])->get();
        //hapus agar tidak ada redundant
        if($tanggal){
            $tanggal->each->delete();
        }
        //simpan tanggal baru
        if($surat->opsi_tanggal == 1){
            $surat->tanggal_awal = $request->tanggal_awal;
            $surat->tanggal_akhir= $request->tanggal_akhir;
            $surat->save();
        }else{
            $i = 0;
            foreach($request->tanggal as $row){
                $date = new Surat_Tugas_Tanggal;
                $date->surat_tugas_id = $surat->id;
                $date->tanggal = $request->tanggal[$i];
                $date->save();
                $i++;
            }
        }

        $pegawai = Surat_Pegawai::where(['surat_tugas_id' => $id])->get();
        if($pegawai){
            $pegawai->each->delete();
        }
        $i = 0;
        foreach($request->pegawai_id as $row){
            $peg = new Surat_Pegawai;
            $peg->surat_tugas_id = $surat->id;
            $peg->pegawai_id = $request->pegawai_id[$i];
            $peg->save();
            $i++;
        }

        $tujuan = Surat_Tujuan::where(['surat_tugas_id' => $id])->get();
        if($tujuan){
            $tujuan->each->delete();
        }
        $i = 0;
        foreach($request->tujuan_id as $row){
            $tujuan = new Surat_Tujuan;
            $tujuan->surat_tugas_id = $surat->id;
            $tujuan->tujuan_id = $request->tujuan_id[$i];
            $tujuan->save();
            $i++;
        }  

        return redirect()->route('surattugas.index')->withSuccess($surat->nomor_surat.' Berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat = Surat_Tugas::findOrFail($id);
        $tujuan = Surat_Tujuan::where(['surat_tugas_id' => $id])->get();
        if($tujuan){
            $tujuan->each->delete();
        }
        $pegawai = Surat_Pegawai::where(['surat_tugas_id' => $id])->get();
        if($pegawai){
            $pegawai->each->delete();
        }
        $tanggal = Surat_Tugas_Tanggal::where(['surat_tugas_id' => $id])->get();
        if($tanggal){
            $tanggal->each->delete();
        }
        $surat->delete();
        return redirect()->route('surattugas.index')->withSuccess($surat->nomor_surat.' Berhasil dihapus');
    }

    public function print($id)
    {
        $surattugas = Surat_Tugas::findOrFail($id);
        $pegawai = Surat_Pegawai::where(['surat_tugas_id' => $surattugas->id])->get();
        $jumpegawai = count($pegawai);
        $tujuan = Surat_Tujuan::where(['surat_tugas_id' => $surattugas->id])->get();
        $jumtujuan = count($tujuan);
        
        if($jumtujuan == 1 && $surattugas->status_ttd == 1 && $jumpegawai <= 6){
            $pdf = PDF::loadView('surat_tugas.print.pdf1', compact('surattugas', $surattugas));
        }elseif ($jumtujuan == 2 && $surattugas->status_ttd == 1 && $jumpegawai <= 6) {
            $pdf = PDF::loadView('surat_tugas.print.pdf2', compact('surattugas', $surattugas));
        }elseif ($jumtujuan == 3 && $surattugas->status_ttd == 1 && $jumpegawai <= 6) {
            $pdf = PDF::loadView('surat_tugas.print.pdf3', compact('surattugas', $surattugas));
        }else{
            $pdf = PDF::loadView('surat_tugas.print.pdf', compact('surattugas', $surattugas));
        }
        
        return $pdf->stream($surattugas->nomor_surat.'.pdf');
    }
}
