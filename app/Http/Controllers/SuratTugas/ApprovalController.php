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
use DB; use DataTables; use Validator;

class ApprovalController extends Controller
{
    public function json(){
        $surat = DB::table('surat_tugas')
        ->select([
            '*'
        ])->where(['approval' => 1]);
        
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
            ->addColumn('action', 'surat_tugas.approval.action')
            ->rawColumns(['action','kol-pegawai','kol-tujuan','kol-tanggal'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('surat_tugas.approval.index');
    }

    public function approve($id){
        $surat = Surat_Tugas::findOrFail($id);
        $surat->approval = 2;
        $surat->save();
        return redirect()->back()->withSuccess('Surat Tugas '.$surat->nomor_surat.' berhasil diapprove');
    }

    public function reject(Request $request, $id){
        $surat           = Surat_Tugas::findOrFail($id);
        $surat->feedback = $request->feedback;
        $surat->approval = 3;
        $surat->save();
        return redirect()->back()->withSuccess('Surat Tugas '.$surat->nomor_surat.' berhasil direject');
    }

    public function resend($id){
        $surat = Surat_Tugas::findOrFail($id);
        $surat->approval = 1;
        $surat->feedback = null;
        $surat->save();
        return redirect()->back()->withSuccess('Surat Tugas '.$surat->nomor_surat.' berhasil diajukan approval ulang');
    }
}
