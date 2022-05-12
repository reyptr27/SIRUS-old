<?php

namespace App\Http\Controllers\Nomorsurat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nomorsurat\SuratMasuk;
use App\Models\Departemen;
use Auth; use DataTables; use Storage;

class ConfirmationController extends Controller
{
    public function json(){
        $auth = Auth::user();

        // if($auth->hasPermissionTo('nomorsurat-masuk-all')){
        //     $model = SuratMasuk::query()->with(['creator', 'up', 'departemen']);
        // }else{
            $model = SuratMasuk::query()->with(['creator', 'up', 'departemen'])
            ->where('up_id', $auth->id);
        // }

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('tgl_terima', function ($model){
                return date('d-m-Y', strtotime($model->tgl_terima) );
            })
            ->editColumn('tgl_eksternal', function ($model){
                return date('d-m-Y', strtotime($model->tgl_eksternal) );
            })
            ->editColumn('up_id', function ($model){
                return $model->up->name;
            })
            ->editColumn('dept_id', function ($model){
                return $model->departemen->nama_departemen;
            })
            ->editColumn('tindakan', function ($model){
                if($model->tindakan == 1){
                    return '<label class="label label-warning" style="font-size:11px;"><i class="fa fa-download"></i> diterima sekretariat</label>';
                }else if($model->tindakan == 2){
                    return '<label class="label label-primary" style="font-size:11px;"><i class="fa fa-check-square-o"></i> diterima oleh up</label>';
                }else if($model->tindakan == 3){
                    return '<label class="label label-success" style="font-size:11px;"><i class="fa fa-reply"></i> dibalas oleh up</label>';
                }
            })
            ->editColumn('keterangan', function ($model){
                if(!empty($model->keterangan)){
                    return $model->keterangan;
                }else{
                    return '<i>(kosong)</i>';
                }
            })
            ->addColumn('upload', 'nomorsurat.konfirmasi.upload')
            ->addColumn('konfirmasi', 'nomorsurat.konfirmasi.konfirmasi')
            ->addColumn('action', 'nomorsurat.konfirmasi.action') //mengambil dari blade view
            ->rawColumns(['action','upload','konfirmasi'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('nomorsurat.konfirmasi.index');
    }

    public function statusUpdate(Request $request, $id)
    {
        $model = SuratMasuk::findOrFail($id);

        $model->tindakan = $request->tindakan;
        $model->balasan  = $request->balasan;
        $model->save();

        return redirect()->route('confirmation.index')->withSuccess('Konfirmasi surat masuk ' .$model->nomor. ' berhasil diupdate');
    }

    //Upload File
    public function upload(Request $request, $id)
    {
        $model = SuratMasuk::findOrFail($id);
        //upload file
        
            if($model->upload_file != null){
                Storage::delete("public/SuratMasuk/".$model->upload_file);
            } 

            $path = Storage::putFileAs(
                'public/SuratMasuk/', //direktori
                $request->file('upload_file'), //file
                time().'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = time().'_'.$request->file('upload_file')->getClientOriginalName();
            $model->upload_file = $nama_file;
            $model->save();
        
        return redirect()->route('confirmation.index')->withSuccess("Surat Berhasil diupload");
    }

    public function download($id)
    {
        $model = SuratMasuk::findOrFail($id);       
        return Storage::download("public/SuratMasuk/".$model->upload_file);
    }

    public function show($id)
    {   
        $model = SuratMasuk::findOrFail($id);       
        return Storage::response("public/SuratMasuk/".$model->upload_file);       
    }
}
