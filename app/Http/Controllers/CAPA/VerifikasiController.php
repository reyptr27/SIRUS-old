<?php

namespace App\Http\Controllers\CAPA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CAPA\CAPA;
use App\Models\CAPA\Lokasi;
use App\Models\Departemen;
use Storage; use Auth; 
use DB; use DataTables; 

class VerifikasiController extends Controller
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
            ->groupBy('capa.id');
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
                ->where('capa.verifikator_id', $user->id)
            ->groupBy('capa.id');
        }

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('created_at', function ($model){
                return date('d-m-Y', strtotime($model->created_at) );
            })
            ->editColumn('status', function ($model){
                if($model->status == 1){
                    return '<label class="label label-primary">Process</label>';
                }elseif($model->status == 2){
                    return '<label class="label label-success">Done</label>';
                }elseif($model->status == 3){
                    return '<label class="label label-danger">Rejected</label>';
                }
            })
            ->editColumn('tgl_terjadi', function ($model){
                return date('d-m-Y', strtotime($model->tgl_terjadi) );
            })
            ->addColumn('upload', 'capa.upload')
            ->addColumn('approval', 'capa.verifikasi.approval')
            ->addColumn('action', 'capa.verifikasi.action')
            ->rawColumns(['action','upload','approval'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $dept = Departemen::where('status',1)->orderBy('nama_departemen','ASC')->get();
        $lokasi = Lokasi::where('status',1)->orderBy('lokasi','ASC')->get();

        return view('capa.verifikasi.index',compact('dept','lokasi'));
    }

    public function edit($id)
    {
        $model  = CAPA::findOrFail($id);

        return view('capa.verifikasi.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $model  = CAPA::findOrFail($id);
        $model->hasil_tindakan = $request->hasil_tindakan;
        $model->tgl_verifikasi = $request->tgl_verifikasi;
        $model->catatan        = $request->catatan;
        $model->status         = 2;
        $model->save();

        return redirect()->route('capa.verifikasi.index')->withSuccess('Verifikasi untuk '.$model->nomor." berhasil diupdate");
    }

    public function reject(Request $request, $id)
    {
        $model = CAPA::findOrFail($id);
        $model->status = 3;
        $model->feedback = $request->feedback;
        $model->save();

        return redirect()->route('capa.verifikasi.index')->withSuccess($model->nomor." berhasil direject / ditolak");
    }
}
