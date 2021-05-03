<?php

namespace App\Http\Controllers\Monitoring_Mesin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Monitoring_Mesin\Jenis_Mesin;
use App\Models\Monitoring_Mesin\Tipe_Mesin;
use App\User; use DB; use DataTables;

class TipeMesinController extends Controller
{
    public function json()
    {
        $model = DB::table('hd_tipe_mesin as tipe')
            ->leftJoin('hd_jenis_mesin as jenis', 'jenis.id', '=', 'tipe.jenis_id')
            ->select([
               'tipe.*','jenis.jenis'
            ])
        ->get();

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('created_at', function ($model){
                return date('d-m-Y', strtotime($model->created_at) );
            })
            ->addColumn('action', 'monitoring_mesin.tipe.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('monitoring_mesin.tipe.index');
    }

    public function create()
    {
        $jenis = Jenis_Mesin::all();
        return view('monitoring_mesin.tipe.create', compact('jenis'));
    }

    public function store(Request $request)
    {   
        $model = new Tipe_Mesin;
        $model->jenis_id= $request->jenis_id;
        $model->tipe    = $request->tipe;
        $model->save();
        return redirect()->route('monitoringmesin.tipe.index')->withSuccess('Tipe Mesin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenis = Jenis_Mesin::all();
        $model = Tipe_Mesin::findOrFail($id);
        return view('monitoring_mesin.tipe.edit', compact('model','jenis'));
    }

    public function update(Request $request, $id)
    {   
        $model = Tipe_Mesin::findOrFail($id);
        $model->jenis_id= $request->jenis_id;
        $model->tipe    = $request->tipe;
        $model->save();
        return redirect()->route('monitoringmesin.tipe.index')->withSuccess('Tipe Mesin berhasil diupdate');
    }

    public function destroy($id)
    {
        $model = Tipe_Mesin::findOrFail($id);
        $model->delete();
        return redirect()->route('monitoringmesin.tipe.index')->withSuccess('Tipe Mesin berhasil dihapus');
    }
}
