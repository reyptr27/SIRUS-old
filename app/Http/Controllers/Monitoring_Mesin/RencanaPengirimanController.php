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

class RencanaPengirimanController extends Controller
{
    public function json()
    {
        $model = DB::table('hd_pengiriman_header as header')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->leftJoin('users as creator', 'creator.id', '=', 'header.created_by')
            ->leftJoin('users as updater', 'updater.id', '=', 'header.updated_by')
            ->select([
               'header.*','customer.nama_rs as customer','creator.name as creator','updater.name as updater'        
            ])->where(['header.delete_status' => 1])
        ->get();

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('tgl_approval', function ($model){
                return date('d-m-Y', strtotime($model->tgl_approval) );
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
            ->addColumn('action', 'monitoring_mesin.rencana.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $customer = RS::where('status',1)->get();
        return view('monitoring_mesin.rencana.index',compact('customer'));
    }

    public function edit($id)
    {
        $user   = Auth::user();
        $header = Pengiriman_Header::findOrFail($id);

        return view('monitoring_mesin.rencana.edit', compact('header'));
    }

    public function update($id, Request $request)
    {
        $user   = Auth::user();
        $header = Pengiriman_Header::findOrFail($id);

        $header->tgl_plan_kirim = $request->tgl_plan_kirim;
        $header->tgl_plan_instalasi = $request->tgl_plan_instalasi;
        $header->status = 2;
        $header->updated_by = $user->id;
        $header->save();

        $detail = Pengiriman_Detail::where(['header_id' => $id])->get();

        $arr_jenis = []; 
        $arr_tipe = []; 
        $arr_nomor = [];
        $arr_kondisi = [];
        $arr_gudang = [];

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
            $i++;
        }

        $header_customer = RS::select('nama_rs')->where(['id' => $header->customer_id])->first(); 
        
        //NOTIFICATION
        $strmesin = "";
        for($i=0;$i < count($arr_jenis); $i++){
            $strmesin = $strmesin."\n -".$arr_jenis[$i]." | ".$arr_tipe[$i]." | ".$arr_nomor[$i]." | ".$arr_kondisi[$i]." | ".$arr_gudang[$i];
        }
        if($header->kategori == 1){
            $strkategori = "Penambahan";
        }else if($header->kategori == 2){
            $strkategori = "Penggantian";
        }else if($header->kategori == 3){
            $strkategori = "Peminjaman";
        }
   
        $text = "<b>Rencana Pengiriman dan Instalasi</b>\n\n"
                ."<b>Nomor :</b> ".$header->nomor."\n"
                ."<b>Kategori :</b> ".$strkategori."\n"
                ."<b>Customer :</b> ".$header_customer->nama_rs."\n\n"

                ."<b>Detail Mesin</b>"
                .$strmesin."\n\n"

                ."<b>Rencana Pengiriman :</b> ".date('d-m-Y', strtotime($header->tgl_plan_kirim))."\n"
                ."<b>Rencana Instalasi :</b> ".date('d-m-Y', strtotime($header->tgl_plan_instalasi))."\n\n"
                
                ."<i>Diupdate oleh <b>".$user->name."</b></i>\n"
        ;
        dispatch(new SendTelegramNotificationJob($text, $header->nomor)); //memanggil jobs queue
        //END NOTIFICATION


        return redirect()->route('monitoringmesin.rencanapengiriman.index')
        ->withSuccess('Rencana pengiriman dan instalasi '.$header->nomor.' berhasil diupdate');
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

        return redirect()->route('monitoringmesin.rencanapengiriman.index')
        ->withSuccess('Rekomendasi pengiriman mesin '.$header->nomor.' berhasil dihapus');
    }
}
