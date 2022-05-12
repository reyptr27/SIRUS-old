<?php

namespace App\Http\Controllers\Monitoring_Mesin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Monitoring_Mesin\Stock_Mesin;
use App\Models\Monitoring_Mesin\Jenis_Mesin;
use App\Models\Monitoring_Mesin\Tipe_Mesin;
use App\Models\Monitoring_Mesin\Pengiriman_Header;
use App\Models\Monitoring_Mesin\Pengiriman_Detail;
use App\Models\Beritaacara\Ba_Gudang_Alamat;
use App\Models\TAM\BA\RS;
use App\Jobs\Telegram\SendTelegramNotificationJob;
use App\User; use DB; use DataTables; use Auth; 
use Storage;

class AkuisisiMesinController extends Controller
{
    public function json()
    {
        $model = DB::table('hd_pengiriman_header as header')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->leftJoin('users as creator', 'creator.id', '=', 'header.created_by')
            ->leftJoin('users as updater', 'updater.id', '=', 'header.updated_by')
        ->select([
            'header.*','customer.nama_rs as customer','creator.name as creator','updater.name as updater'        
        ])->where([['header.delete_status','=', 1],['header.status','=',4]]);

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('tgl_bast', function ($model){
                return date('d-m-Y', strtotime($model->tgl_bast) );
            })
            ->editColumn('created_at', function ($model){
                return date('d-m-Y', strtotime($model->created_at) );
            })
            ->editColumn('tgl_plan_kirim', function ($model){
                if($model->tgl_plan_kirim != null){
                    return date('d-m-Y', strtotime($model->tgl_plan_kirim) );
                }else{
                    return '<i>(belum diupdate)</i>';
                }
            })
            ->editColumn('tgl_plan_instalasi', function ($model){
                if($model->tgl_plan_instalasi != null){
                    return date('d-m-Y', strtotime($model->tgl_plan_instalasi) );
                }else{
                    return '<i>(belum diupdate)</i>';
                }
            })
            ->editColumn('tgl_kirim', function ($model){
                if($model->tgl_plan_kirim != null){
                    return date('d-m-Y', strtotime($model->tgl_kirim) );
                }else{
                    return '<i>(belum diupdate)</i>';
                }
            })
            ->editColumn('tgl_plan_instalasi', function ($model){
                if($model->tgl_instalasi != null){
                    return date('d-m-Y', strtotime($model->tgl_instalasi) );
                }else{
                    return '<i>(belum diupdate)</i>';
                }
            })
            ->editColumn('akuisisi', function ($model){
                if($model->akuisisi == 1){
                    return '<label class="label label-warning">Process</label>';
                }else{
                    return '<label class="label label-success">Done</label>';
                }
            })
            ->editColumn('kategori', function ($model){
                if($model->kategori == 1){
                    return 'Penambahan';
                }else if($model->kategori == 2){
                    return 'Penggantian';
                }else if($model->kategori == 3){
                    return 'Peminjaman';
                }
            })
            ->addColumn('upload', 'monitoring_mesin.akuisisi.upload')
            ->addColumn('action', 'monitoring_mesin.akuisisi.action')
            ->rawColumns(['action','upload'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $customer = RS::where('status',1)->get();
        return view('monitoring_mesin.akuisisi.index', compact('customer'));
    }

    public function download($id)
    {
        $header = Pengiriman_Header::findOrFail($id);       
        return Storage::download("public/MonitoringMesin/".$header->upload_file);
    }

    public function show($id)
    {   
        $header = Pengiriman_Header::findOrFail($id);       
        return Storage::response("public/MonitoringMesin/".$header->upload_file);       
    }

    public function edit($id)
    {
        $header = Pengiriman_Header::findOrFail($id);
        $detail = Pengiriman_Detail::where(['header_id' => $id])->get();
        return view('monitoring_mesin.akuisisi.edit', compact('header','detail'));
    }

    public function update(Request $request, $id)
    {
        $user   = Auth::user();
        $header = Pengiriman_Header::findOrFail($id);
        
        $i = 0;
        $detail = Pengiriman_Detail::where('header_id', '=', $id)->get();
        $temp = [];
        foreach($detail as $row) {
            $det = Pengiriman_Detail::find($row->id);
            $det->fa_number = $request->fa_number[$i];
            $det->akuisisi  = $request->akuisisi[$i];
            $temp[$i] = $request->akuisisi[$i];
            $det->save();
            $i++;
        }

        if (in_array(1, $temp)) {
            $header->akuisisi = 1;
        }else{
            $header->akuisisi = 2;
        }

        $header->updated_by = $user->id;
        $header->save();

        return redirect()->route('monitoringmesin.akuisisi.index')
        ->withSuccess('Data '.$header->nomor.' berhasil diupdate');
    }
}
