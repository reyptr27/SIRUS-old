<?php

namespace App\Http\Controllers\Monitoring_Mesin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TAM\BA\RS;
use App\User; use DB; use DataTables; use Auth; 

class BatalKirimController extends Controller
{
    public function json()
    {
        $model = DB::table('hd_pengiriman_header as header')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->leftJoin('users as creator', 'creator.id', '=', 'header.created_by')
            ->leftJoin('users as updater', 'updater.id', '=', 'header.updated_by')
            ->leftJoin('users as eraser', 'eraser.id', '=', 'header.deleted_by')
            ->select([
               'header.*','customer.nama_rs as customer','creator.name as creator','updater.name as updater','eraser.name as eraser'       
            ])->where(['header.delete_status' => 2])
        ->get();

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('tgl_approval', function ($model){
                return date('d-m-Y', strtotime($model->tgl_approval) );
            })
            ->editColumn('deleted_at', function ($model){
                return date('d-m-Y', strtotime($model->deleted_at) );
            })
            ->editColumn('status', function ($model){
                return '<label class="label label-danger">Dibatalkan</label>';
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
            ->addColumn('action', 'monitoring_mesin.batal.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $customer = RS::where('status',1)->get();
        return view('monitoring_mesin.batal.index',compact('customer'));
    }
}
