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

class RekomendasiPengirimanController extends Controller
{
    public function json()
    {
        $model = DB::table('hd_pengiriman_header as header')
        ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
        ->leftJoin('users as creator', 'creator.id', '=', 'header.created_by')
        ->leftJoin('users as updater', 'updater.id', '=', 'header.updated_by')
        ->select([
            'header.*','customer.nama_rs as customer','creator.name as creator','updater.name as updater'        
        ])->where(['header.delete_status' => 1]);

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('tgl_approval', function ($model){
                return date('d-m-Y', strtotime($model->tgl_approval) );
            })
            ->editColumn('created_at', function ($model){
                return date('d-m-Y', strtotime($model->created_at) );
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
            ->editColumn('status', function ($model){
                if($model->status == 1){
                    return '<label class="label label-primary">Rekomendasi</label>';
                }else if($model->status == 2){
                    return '<label class="label label-primary">Rencana Pengiriman</label>';
                }else if($model->status == 3){
                    return '<label class="label label-primary">Pengiriman dan Instalasi</label>';
                }else if($model->status == 4){
                    return '<label class="label label-success">Selesai</label>';
                }
            })
            ->addColumn('action', 'monitoring_mesin.rekomendasi.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $customer = RS::where('status',1)->get();
        return view('monitoring_mesin.rekomendasi.index', compact('customer'));
    }

    public function create()
    {
        $customer = RS::orderBy('nama_rs','ASC')->get();
        $jenis = Jenis_Mesin::all();
        return view('monitoring_mesin.rekomendasi.create', compact('customer','jenis'));
    }

    public function getStock(Request $request)
    { 
        if($request->ajax()){
            $stock =  DB::table('hd_stock_mesin as stock')
                ->leftJoin('hd_tipe_mesin as tipe', 'tipe.id', '=', 'stock.tipe_id')
                ->leftJoin('hd_jenis_mesin as jenis', 'jenis.id', '=', 'stock.jenis_id')
                ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'stock.customer_id')
                ->leftJoin('ba_gudang_alamat as gudang', 'gudang.id', '=', 'stock.gudang_id')
                ->select([
                    'stock.*','customer.nama_rs as customer','gudang.nama_gudang as gudang','tipe.tipe as tipe','jenis.jenis as jenis'
                ])->where(['stock.status' => 1,'stock.jenis_id' => $request->jenis_id])
            ->get();
            return response()->json($stock);
        }
    }

    public function store(Request $request)
    {   
        $user   = Auth::user();

        $last = Pengiriman_Header::orderBy('id','DESC')->first();
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        $header = new Pengiriman_Header;

        if($last == null){
            $hasil = "1";
        }else{
            $nomor = $last->nomor;
            $pisah = explode('/', $nomor);

            if ((int)$pisah[3] > 0 && $pisah[1] != date('Y')) {
               $hasil = "1";
            }else{
                $hasil = (int)$pisah[3]+1;    
            }
        }

        $datano             = sprintf("%03s", $hasil);
        $nomorstring        = "SHP-HD/".date('Y')."/".$bulanRomawi[date('n')]."/".$datano;
        $header->nomor      = $nomorstring;
        $header->customer_id = $request->customer_id;
        $header->kategori = $request->kategori;
        $header->tgl_approval= $request->tgl_approval;
        $header_customer = RS::select('nama_rs')->where(['id' => $header->customer_id])->first(); 
        $header->created_by = $user->id;
        $header->updated_by = $user->id;
        $header->save();

        $arr_jenis = []; 
        $arr_tipe = []; 
        $arr_nomor = [];
        $arr_kondisi = [];
        $arr_gudang = [];
        $arr_customer = [];

        $i = 0;
        foreach($request->stock_id as $row){
            $detail            = new Pengiriman_Detail;
            $stock = Stock_Mesin::where(['id' => $request->stock_id[$i]])->first();
            
            $detail->header_id  = $header->id;
            $detail->stock_id  = $stock->id;
            $detail->jenis_id  = $stock->jenis_id;
            $detail->tipe_id   = $stock->tipe_id;
            
            $this_tipe         = Tipe_Mesin::select('tipe')->where(['id' => $stock->tipe_id])->first(); //notification
            $this_jenis        = Jenis_Mesin::select('jenis')->where(['id' => $stock->jenis_id])->first(); //notification
            $this_gudang       = Ba_Gudang_Alamat::select('nama_gudang')->where(['id' => $stock->gudang_id])->first(); //notification

            $arr_jenis[$i]     = $this_jenis->jenis; //notification
            $arr_tipe[$i]      = $this_tipe->tipe; //notification
            
            $detail->nomor     = $stock->nomor;
            $arr_nomor[$i]     = $stock->nomor; //notification

            $detail->customer_id = $stock->customer_id;
            $detail->gudang_id = $stock->gudang_id;
            $arr_gudang[$i]    = $this_gudang->nama_gudang; //notification

            $detail->kondisi   = $stock->kondisi;
            if($stock->kondisi == 1){ //notification
                $arr_kondisi[$i]   = "Baru"; 
            }elseif($stock->kondisi == 2){
                $arr_kondisi[$i]   = "Bekas"; 
            }elseif($stock->kondisi == 3){
                $arr_kondisi[$i]   = "Rekondisi";
            }
            
            $detail->save();
            
            $stock->status = 2;
            $stock->save();
            $i++;
        }

        //NOTIFICATION
        $strmesin = "";
        for($i=0;$i < count($arr_jenis); $i++){
            $strmesin = $strmesin."\n -".$arr_jenis[$i]." | ".$arr_tipe[$i]." | ".$arr_nomor[$i]." | ".$arr_kondisi[$i]." | ".$arr_gudang[$i];
        }
        $tgl_app = date('d-m-Y', strtotime($header->tgl_approval));
        if($header->kategori == 1){
            $strkategori = "Penambahan";
        }else if($header->kategori == 2){
            $strkategori = "Penggantian";
        }else if($header->kategori == 3){
            $strkategori = "Peminjaman";
        }
        
        $text = "<b>Rekomendasi Pengiriman Mesin</b>\n\n"
                ."<b>Nomor :</b> ".$header->nomor."\n"
                ."<b>Approval :</b> ".$tgl_app."\n"
                ."<b>Kategori :</b> ".$strkategori."\n"
                ."<b>Customer :</b> ".$header_customer->nama_rs."\n\n"
                
                ."<b>Detail Mesin</b>"
                .$strmesin."\n\n"
                ."<i>Dibuat oleh <b>".$user->name."</b></i>"
        ;
        dispatch(new SendTelegramNotificationJob($text, $header->nomor)); //memanggil jobs queue
        //END NOTIFICATION

        return redirect()->route('monitoringmesin.rekomendasi.index')
        ->withSuccess('Rekomendasi pengiriman mesin '.$header->nomor.' berhasil ditambahkan');
    }

    public function hapus($id, Request $request)
    {
        $user   = Auth::user();
        $header = Pengiriman_Header::findOrFail($id);

        //mengubah status hapus
        $header->delete_status = 2;
        $header->delete_reason = $request->delete_reason;
        $header->deleted_by = $user->id;
        $header->deleted_at = date('Y-m-d H:i:s');
        $header->save();

        //get detail
        $detail = Pengiriman_Detail::where(['header_id' => $id])->get();

        $arr_jenis = []; 
        $arr_tipe = []; 
        $arr_nomor = [];
        $arr_kondisi = [];
        $arr_gudang = [];

        //mengembalikan stock dan input notifikasi
        $i = 0;
        foreach($detail as $row){
            $stock = Stock_Mesin::where(['id' => $row->stock_id])->first();
            
            //notif
            $this_tipe       = Tipe_Mesin::select('tipe')->where(['id' => $stock->tipe_id])->first(); 
            $this_jenis      = Jenis_Mesin::select('jenis')->where(['id' => $stock->jenis_id])->first(); 
            $this_gudang     = Ba_Gudang_Alamat::select('nama_gudang')->where(['id' => $stock->gudang_id])->first(); 
            $arr_jenis[$i]   = $this_jenis->jenis; 
            $arr_tipe[$i]    = $this_tipe->tipe;
            $arr_nomor[$i]   = $stock->nomor;
            $arr_gudang[$i]  = $this_gudang->nama_gudang;
            if($stock->kondisi == 1){ 
                $arr_kondisi[$i]   = "Baru"; 
            }elseif($stock->kondisi == 2){
                $arr_kondisi[$i]   = "Bekas"; 
            }elseif($stock->kondisi == 3){
                $arr_kondisi[$i]   = "Rekondisi";
            }
            //end notif

            $stock->status = 1;
            $stock->save();
            $i++;
        }

        $header_customer = RS::select('nama_rs')->where(['id' => $header->customer_id])->first(); 
        
        //NOTIFICATION
        $strmesin = "";
        for($i=0;$i < count($arr_jenis); $i++){
            $strmesin = $strmesin."\n -".$arr_jenis[$i]." | ".$arr_tipe[$i]." | ".$arr_nomor[$i]." | ".$arr_kondisi[$i]." | ".$arr_gudang[$i];
        }
        $tgl_app = date('d-m-Y', strtotime($header->tgl_approval));
        if($header->kategori == 1){
            $strkategori = "Penambahan";
        }else if($header->kategori == 2){
            $strkategori = "Penggantian";
        }else if($header->kategori == 3){
            $strkategori = "Peminjaman";
        }
            
        $text = "<b>Pembatalan Pengiriman Mesin</b>\n\n"
                ."<b>Nomor :</b> ".$header->nomor."\n"
                ."<b>Approval :</b> ".$tgl_app."\n"
                ."<b>Kategori :</b> ".$strkategori."\n"
                ."<b>Customer :</b> ".$header_customer->nama_rs."\n\n"
                
                ."<b>Detail Mesin</b>"
                .$strmesin."\n\n"

                ."<b>Alasan :</b> ".$header->delete_reason."\n\n"
                
                ."<i>Dibatalkan oleh <b>".$user->name."</b></i>\n"
                ."pada ".date('d-m-Y H:i', strtotime($header->deleted_at))
        ;
        dispatch(new SendTelegramNotificationJob($text, $header->nomor)); //memanggil jobs queue
        //END NOTIFICATION

        return redirect()->route('monitoringmesin.rekomendasi.index')
        ->withSuccess('Rekomendasi pengiriman mesin '.$header->nomor.' berhasil dihapus');
    }
}
