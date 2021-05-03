<?php

namespace App\Http\Controllers\Monitoring_Mesin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Monitoring_Mesin\Penerimaan_Header;
use App\Models\Monitoring_Mesin\Penerimaan_Detail;
use App\Models\Monitoring_Mesin\Stock_Mesin;
use App\Models\Monitoring_Mesin\Jenis_Mesin;
use App\Models\Monitoring_Mesin\Tipe_Mesin;
use App\Models\Beritaacara\Ba_Gudang_Alamat;
use App\Models\TAM\BA\RS;
use App\Jobs\Telegram\SendTelegramNotificationJob;
use App\User; use DB; use DataTables; use Auth; 


class PenerimaanMesinController extends Controller
{
    public function json()
    {
        $model = DB::table('hd_penerimaan_header as header')
            ->leftJoin('ba_gudang_alamat as gudang', 'gudang.id', '=', 'header.gudang_id')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->leftJoin('users as creator', 'creator.id', '=', 'header.created_by')
            ->leftJoin('users as updater', 'updater.id', '=', 'header.updated_by')
            ->select([
               'header.*','gudang.nama_gudang as gudang','customer.nama_rs as customer','creator.name as creator','updater.name as updater'        
            ])
        ->get();

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('tgl_terima', function ($model){
                return date('d-m-Y', strtotime($model->tgl_terima) );
            })
            ->editColumn('created_at', function ($model){
                return date('d-m-Y', strtotime($model->created_at) );
            })
            ->addColumn('action', 'monitoring_mesin.penerimaan.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $customer = RS::where('status',1)->get();
        $gudang = BA_Gudang_Alamat::where('status',1)->get();
        return view('monitoring_mesin.penerimaan.index', compact('customer', 'gudang'));
    }

    public function create()
    {
        $customer = RS::orderBy('nama_rs','ASC')->get();
        $gudang = Ba_Gudang_Alamat::orderBy('nama_gudang','ASC')->get();
        $jenis = Jenis_Mesin::all();
        $tipe = Tipe_Mesin::all();
        return view('monitoring_mesin.penerimaan.create', compact('customer','gudang','jenis','tipe'));
    }

    public function getTipe(Request $request)
    {
        if($request->ajax()){
            
            $tipe = Tipe_Mesin::select('id','tipe')->where('jenis_id',$request->jenis_id)->get();
            return response()->json($tipe);
        }
    }

    public function store(Request $request)
    {
        $user   = Auth::user();

        $last = Penerimaan_Header::orderBy('id','DESC')->first();
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

        $header = new Penerimaan_Header;
        
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
        $nomorstring        = "REC-HD/".date('Y')."/".$bulanRomawi[date('n')]."/".$datano;
        $header->nomor      = $nomorstring;

        $header->tgl_terima = $request->tgl_terima;
        $header->surat_jalan= $request->surat_jalan;
        $header->customer_id= $request->customer_id;
        $this_customer = RS::select('nama_rs')->where(['id' => $header->customer_id])->first(); //notification
        $header->gudang_id  = $request->gudang_id;
        $this_gudang = Ba_Gudang_Alamat::select('nama_gudang')->where(['id' => $header->gudang_id])->first(); //notification
        $header->created_by = $user->id;
        $header->updated_by = $user->id;
        $header->save();

        $arr_jenis = []; 
        $arr_tipe = []; 
        $arr_nomor = [];
        $arr_kondisi = [];
        
        $i = 0;
        foreach($request->jenis_id as $row){
            $detail            = new Penerimaan_Detail;
            $detail->header_id = $header->id;
            $detail->jenis_id   = $request->jenis_id[$i];
            $detail->tipe_id   = $request->tipe_id[$i];
            
            $this_tipe         = Tipe_Mesin::select('tipe')->where(['id' => $detail->tipe_id])->first(); //notification
            $this_jenis        = Jenis_Mesin::select('jenis')->where(['id' => $detail->jenis_id])->first(); //notification
            $arr_jenis[$i]     = $this_jenis->jenis; //notification
            $arr_tipe[$i]      = $this_tipe->tipe; //notification
            
            $detail->nomor     = $request->nomor_seri[$i];
            $arr_nomor[$i]     = $request->nomor_seri[$i]; //notification

            $detail->kondisi   = $request->kondisi[$i];
            
            if($request->kondisi[$i] == 1){ //notification
                $arr_kondisi[$i]   = "Baru"; 
            }elseif($request->kondisi[$i] == 2){
                $arr_kondisi[$i]   = "Bekas"; 
            }elseif($request->kondisi[$i] == 3){
                $arr_kondisi[$i]   = "Rekondisi";
            }
            
            $detail->save();
            $i++;
        }

        $i = 0;
        foreach($request->jenis_id as $row){
            $stock              = new Stock_Mesin;
            $stock->tgl_terima  = $request->tgl_terima;
            $stock->customer_id = $request->customer_id;
            $stock->gudang_id   = $request->gudang_id;
            $stock->jenis_id     = $request->jenis_id[$i];
            $stock->tipe_id     = $request->tipe_id[$i];
            $stock->nomor       = $request->nomor_seri[$i];
            $stock->kondisi     = $request->kondisi[$i];
            $stock->save();
            $i++;
        }

        //NOTIFICATION
        $strmesin = "";
        for($i=0;$i < count($arr_jenis); $i++){
            $strmesin = $strmesin."\n -".$arr_jenis[$i]." | ".$arr_tipe[$i]." | ".$arr_nomor[$i]." | ".$arr_kondisi[$i];
        }
        $tgl_trm = date('d-m-Y', strtotime($header->tgl_terima));
            
        $text = "<b>Penerimaan Mesin</b>\n\n"
                ."<b>Nomor :</b> ".$header->nomor."\n"
                ."<b>Tanggal :</b> ".$tgl_trm."\n"
                ."<b>Gudang :</b> ".$this_gudang->nama_gudang."\n"
                ."<b>Customer :</b> ".$this_customer->nama_rs."\n"
                ."<b>Surat Jalan :</b> ".$header->surat_jalan."\n\n"
                ."<b>Detail Mesin</b>"
                .$strmesin."\n\n"
                ."<i>Dibuat oleh <b>".$user->name."</b></i>\n"
        ;
        dispatch(new SendTelegramNotificationJob($text, $header->nomor)); //memanggil jobs queue
        //END NOTIFICATION

        return redirect()->route('monitoringmesin.penerimaan.index')
        ->withSuccess('Penerimaan mesin '.$header->nomor.' berhasil ditambahkan dan data mesin telah masuk ke dalam stock');
    }

    public function destroy($id)
    {
        $header = Penerimaan_Header::findOrFail($id);
        $header->delete();
        return redirect()->route('monitoringmesin.penerimaan.index')
        ->withSuccess('Penerimaan mesin '.$header->nomor.' berhasil dihapus');
    }

}
