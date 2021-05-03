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

class ApprovalPenyelesaianController extends Controller
{
    public function json()
    {
        $model = DB::table('hd_pengiriman_header as header')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->leftJoin('users as creator', 'creator.id', '=', 'header.created_by')
            ->leftJoin('users as updater', 'updater.id', '=', 'header.updated_by')
            ->select([
               'header.*','customer.nama_rs as customer','creator.name as creator','updater.name as updater'        
            ])->where([['header.delete_status','=', 1],['header.status','>=',3]])
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
            ->addColumn('upload', 'monitoring_mesin.selesai.upload')
            ->addColumn('action', 'monitoring_mesin.selesai.action')
            ->rawColumns(['action','upload'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $customer = RS::where('status',1)->get();
        return view('monitoring_mesin.selesai.index', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $user   = Auth::user();
        $header = Pengiriman_Header::findOrFail($id);

        $header->tgl_bast = $request->tgl_bast;
        $header->updated_by = $user->id;
        $header->status = 4;
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
   
   
        $text = "<b>Realisasi Mesin Selesai</b>\n\n"
                ."<b>Nomor :</b> ".$header->nomor."\n"
                ."<b>Kategori :</b> ".$strkategori."\n"
                ."<b>Customer :</b> ".$header_customer->nama_rs."\n\n"

                ."<b>Detail Mesin</b>"
                .$strmesin."\n\n"

                ."<b>Tanggal Pengiriman :</b> ".date('d-m-Y', strtotime($header->tgl_kirim))."\n"
                ."<b>Tanggal Instalasi :</b> ".date('d-m-Y', strtotime($header->tgl_instalasi))."\n"
                ."<b>Tanggal BAST :</b> ".date('d-m-Y', strtotime($header->tgl_bast))."\n\n"
                
                ."<i>Diupdate oleh <b>".$user->name."</b></i>\n"
        ;
        dispatch(new SendTelegramNotificationJob($text, $header->nomor)); //memanggil jobs queue
        //END NOTIFICATION

        return redirect()->route('monitoringmesin.selesai.index')
        ->withSuccess('Data '.$header->nomor.' berhasil diupdate');
    }

    public function upload(Request $request, $id)
    {
        $header = Pengiriman_Header::findOrFail($id);
        //upload file
        
            if($header->upload_file != null){
                Storage::delete("public/MonitoringMesin/".$header->upload_file);
                // File::delete('storage/app/Berita_Acara/barang_gudang/'.$ba->upload_file);
            } 

            $nama_file = time().'_'.$request->file('upload_file')->getClientOriginalName();
            $path = Storage::putFileAs(
                'public/MonitoringMesin/', //direktori
                $request->file('upload_file'), //file
                $nama_file
            );
            
            $header->upload_file = $nama_file;
            $header->save();
        
        return redirect()->route('monitoringmesin.selesai.index')->withSuccess("File / Dokumen berhasil diupload");
        // return response()->json($request);
        
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
}
