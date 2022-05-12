<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use DataTables; use DB;

class CustomerController extends Controller
{
    public function json()
    {
        $customer = DB::table('m_customer as cus')
                ->leftJoin('users', 'cus.created_by', '=', 'users.id')
                ->leftJoin('users as updater', 'cus.updated_by', '=', 'updater.id')
                ->select([
                    'cus.nama_customer', 'cus.alamat', 'cus.kota', 'cus.up','cus.va', 'cus.status',
                    'cus.created_at', 'users.name as created_by', 'cus.updated_at', 'cus.id',
                    'updater.name as updated_by'
                ]);
        
        return DataTables::of($customer)
            ->addIndexColumn()
            ->editColumn('created_at', function ($customer){
                return date('d-m-Y', strtotime($customer->created_at) );
            })
            ->editColumn('updated_at', function ($customer){
                return date('d-m-Y', strtotime($customer->updated_at) );
            })
            ->editColumn('status', function ($customer){
                if($customer->status == 1){
                    return '<label class="label label-success">Aktif</label>';
                }else{
                    return '<label class="label label-danger">Non-Aktif</label>';
                }
            })
            ->addColumn('action', 'master.customer.action') //mengambil dari blade view
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {   
        return view('master.customer.index');
    }
}
