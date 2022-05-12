<?php

namespace App\Http\Controllers\Monitoring_Mesin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Monitoring_Mesin\Stock_Mesin;
use App\Models\Monitoring_Mesin\Jenis_Mesin;
use App\Models\Monitoring_Mesin\Tipe_Mesin;
use App\Models\Beritaacara\Ba_Gudang_Alamat;
use App\Models\TAM\BA\RS;
use DB; use DataTables; use Auth; 

class StockMesinController extends Controller
{
    public function json(Request $request)
    {
        $user = Auth::user();

        $model = DB::table('hd_stock_mesin as stock')
            ->leftJoin('ba_gudang_alamat as gudang', 'gudang.id', '=', 'stock.gudang_id')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'stock.customer_id')
            ->leftJoin('hd_tipe_mesin as tipe', 'tipe.id', '=', 'stock.tipe_id')
            ->leftJoin('hd_jenis_mesin as jenis', 'jenis.id', '=', 'tipe.jenis_id')
            ->select([
                'stock.id','stock.tgl_terima','jenis.jenis','tipe.tipe','stock.nomor','stock.kondisi',
                'gudang.nama_gudang as gudang','customer.nama_rs as customer','stock.created_at'
            ])
        ->where(['stock.status' => 1]);

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('created_at', function ($model){
                return date('d-m-Y', strtotime($model->created_at) );
            })
            ->editColumn('kondisi', function ($model){
                if($model->kondisi == 1){
                    return "Baru";
                }elseif($model->kondisi == 2){
                    return "Bekas";
                }elseif($model->kondisi == 3){
                    return "Rekondisi";
                }
            })
            // ->filter(function ($instance) use ($request) {
            //     //custom filter
            //     if (!empty($request->get('filter_jenis'))) {
            //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
            //             return Str::contains($row['jenis'], $request->get('filter_jenis')) ? true : false;
            //         });
            //     }
                
            //     //Search
            //     if (!empty($request->get('search'))) {
            //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
            //             if (Str::contains(Str::lower($row['tgl_terima']), Str::lower($request->get('search')))){
            //                 return true;
            //             }else if (Str::contains(Str::lower($row['jenis']), Str::lower($request->get('search')))) {
            //                 return true;
            //             }else if (Str::contains(Str::lower($row['tipe']), Str::lower($request->get('search')))) {
            //                 return true;
            //             }else if (Str::contains(Str::lower($row['nomor']), Str::lower($request->get('search')))) {
            //                 return true;
            //             }else if (Str::contains(Str::lower($row['kondisi']), Str::lower($request->get('search')))) {
            //                 return true;
            //             }else if (Str::contains(Str::lower($row['gudang']), Str::lower($request->get('search')))) {
            //                 return true;
            //             }else if (Str::contains(Str::lower($row['customer']), Str::lower($request->get('search')))) {
            //                 return true;
            //             }

            //             return false;
            //         });
            //     }
            // })
            ->addColumn('action', 'monitoring_mesin.stock.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $jenis = Jenis_Mesin::all();
        $gudang = Ba_Gudang_Alamat::where('status',1)->get();
        $customer = RS::where('status',1)->get();

        return view('monitoring_mesin.stock.index', compact('jenis','gudang','customer'));
    }

    public function getTipe(Request $request)
    {
        if($request->ajax()){
            
            $tipe = DB::table('hd_tipe_mesin as tipe')
            ->leftJoin('hd_jenis_mesin as jenis', 'jenis.id', '=', 'tipe.jenis_id')
            ->select('jenis.jenis','jenis.id','tipe','tipe.id')
            ->where('jenis.jenis',$request->jenis)->get();
            return response()->json($tipe);
        }
    }

    public function edit($id)
    {
        $stock = Stock_Mesin::findOrFail($id);
        $tipe = Tipe_Mesin::all();
        $jenis = Jenis_Mesin::all();
        $gudang = Ba_Gudang_Alamat::where('status', 1)->get();
        $customer = RS::where('status', 1)->get();

        return view('monitoring_mesin.stock.edit', compact('stock','tipe','jenis','gudang','customer'));
    }

    public function update(Request $request, $id)
    {
        $stock = Stock_Mesin::findOrFail($id);

        $stock->tgl_terima  = $request->tgl_terima;
        $stock->jenis_id    = $request->jenis_id;
        $stock->tipe_id     = $request->tipe_id;
        $stock->nomor       = $request->nomor_seri;
        $stock->kondisi     = $request->kondisi;
        $stock->gudang_id   = $request->gudang_id;
        $stock->customer_id = $request->customer_id;
        $stock->save();

        return redirect()->route('monitoringmesin.stock.index')
        ->withSuccess('Stock mesin '.$stock->nomor.' berhasil diupdate');

    }

    public function destroy($id)
    {
        $stock = Stock_Mesin::findOrFail($id);
        $stock->delete();
        return redirect()->route('monitoringmesin.stock.index')
        ->withSuccess('Stock mesin '.$stock->nomor.' berhasil dihapus');
    }
}
