<?php

namespace App\Http\Controllers\Monitoring_Mesin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;
use App\Exports\Monitoring_Mesin\excelReport;
use App\Exports\Monitoring_Mesin\excelDetail;
use App\Models\Monitoring_Mesin\Pengiriman_Header;
use App\Models\Monitoring_Mesin\Pengiriman_Detail;
use App\Models\TAM\BA\RS;
use DB; use DateTime;

class ReportController extends Controller
{
    public function index()
    {
        $customer = RS::where('status',1)->get();
        return view('monitoring_mesin.report.index', compact('customer'));
    }

    //PIE CHART
    public function getPieCount($status, $kategori, $customer_id, $tgl_awal, $tgl_akhir)
    {
        $query = DB::table('hd_pengiriman_header as header')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->select([
            'header.kategori','header.status','header.delete_status','header.customer_id','header.created_at','customer.id as customer_id'
            ])
        ->where('header.delete_status', 1)->where('header.status', $status);
        
        if($kategori != null){
            $query = $query->where('header.kategori', $kategori);
        }

        if($customer_id != null){
            $query = $query->where('customer_id', $customer_id);
        }

        $pieCount  = $query->whereBetween('header.created_at', [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:00"])->get()->count();
        return $pieCount;
    }
    //END PIE CHART

    //BAR CHART
    public function getMonth($tgl_awal, $tgl_akhir)
    {
        $month_Indo = array("", "Januari","Februari","Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober", "November","Desember");
        $month_array = array();
        $posts_dates = Pengiriman_Header::select('created_at')->whereBetween('created_at', [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:00"])->orderBy('created_at','ASC')->get();
        if(!empty($posts_dates)){
            foreach($posts_dates as $unformatted_date){
                $date_no = date('my', strtotime($unformatted_date->created_at));
                $date_name = $month_Indo[date('n', strtotime($unformatted_date->created_at))]." ".date('Y', strtotime($unformatted_date->created_at));
                $month_array[$date_no] = $date_name;
            }
        }
        return $month_array;
    }

    public function getMonthlyCount($label, $month, $kategori, $customer_id)
    {    
        if($label == 1){ //Label Rekomendasi
            $query = DB::table('hd_pengiriman_header as header')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->select([
            'header.status','header.delete_status','header.customer_id','header.created_at','customer.id as customer_id'
            ])
            ->where('header.delete_status', 1);
            
            if($kategori != null){
                $query = $query->where('header.kategori', $kategori);
            }

            if($customer_id != null){
                $query = $query->where('customer_id', $customer_id);
            }

            $monthly_post_count = $query->whereMonth('header.created_at', $month)->get()->count();
        }else if($label == 2){ //Label Pengiriman
            $query = DB::table('hd_pengiriman_header as header')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->select([
            'header.status','header.delete_status','header.customer_id','header.created_at','customer.id as customer_id'
            ])
            ->where('header.delete_status', 1);
            
            if($kategori != null){
                $query = $query->where('header.kategori', $kategori);
            }

            if($customer_id != null){
                $query = $query->where('customer_id', $customer_id);
            }

            $monthly_post_count = $query->whereMonth('header.tgl_kirim', $month)->get()->count();
        }else if($label == 3){ //Label Instalasi
            $query = DB::table('hd_pengiriman_header as header')
            ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
            ->select([
            'header.status','header.delete_status','header.customer_id','header.created_at','customer.id as customer_id'
            ])
            ->where('header.delete_status', 1);
            
            if($kategori != null){
                $query = $query->where('header.kategori', $kategori);
            }

            if($customer_id != null){
                $query = $query->where('customer_id', $customer_id);
            }

            $monthly_post_count = $query->whereMonth('header.tgl_instalasi', $month)->get()->count();
        }
        return $monthly_post_count;
    }

    public function getMonthlyData($label, $kategori, $customer_id, $tgl_awal, $tgl_akhir)
    {
        $monthly_post_count_array = array();
        $month_array = $this->getMonth($tgl_awal, $tgl_akhir);
        if(!empty($month_array)){
            foreach ($month_array as $month_no => $month_name) {
                $monthly_post_count = $this->getMonthlyCount($label, substr($month_no,0,2), $kategori, $customer_id);
                array_push($monthly_post_count_array, $monthly_post_count);
            }
        }
        return $monthly_post_count_array;
    }

    public function getMonthData($tgl_awal, $tgl_akhir)
    {
        $month_name_array = array();
        $month_array = $this->getMonth($tgl_awal, $tgl_akhir);
        if(!empty($month_array)){
            foreach ($month_array as $month_no => $month_name) {
                array_push($month_name_array, $month_name);
            }
        }
        return $month_name_array; 
    }
    //END BAR CHART

    //FILTER DATA
    public function getData(Request $request)
    {
        switch ($request->input('action')) {
            case 'filter':
                //Search
                $stgl_awal = $request->tgl_awal;
                $stgl_akhir = $request->tgl_akhir;
                $skategori = $request->kategori;
                $scustomer_id = $request->customer_id;
                $sstatus = $request->status;
                
                //List Customer
                $customer = RS::where('status',1)->get();
                //Data Filter
                $model = DB::table('hd_pengiriman_header as header')
                    ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
                    ->leftJoin('users as creator', 'creator.id', '=', 'header.created_by')
                    ->leftJoin('users as updater', 'updater.id', '=', 'header.updated_by')
                    ->select([
                    'header.*','customer.id as customer_id','customer.nama_rs as customer','creator.name as creator','updater.name as updater'        
                    ])
                ->where('header.delete_status', 1);
                
                if($request->kategori != null){
                    $model = $model->where('header.kategori', $request->kategori);
                }

                if($request->customer_id != null){
                    $model = $model->where('customer_id', $request->customer_id);
                }

                $model = $model->whereBetween('header.created_at', [$request->tgl_awal." 00:00:00", $request->tgl_akhir." 23:59:00"])->get();
                
                //PIE CHART
                $pieRekomendasi = $this->getPieCount(1,$request->kategori,$request->customer_id,$request->tgl_awal,$request->tgl_akhir);
                $pieRencana     = $this->getPieCount(2,$request->kategori,$request->customer_id,$request->tgl_awal,$request->tgl_akhir);
                $pieRealisasi   = $this->getPieCount(3,$request->kategori,$request->customer_id,$request->tgl_awal,$request->tgl_akhir);
                $pieSelesai     = $this->getPieCount(4,$request->kategori,$request->customer_id,$request->tgl_awal,$request->tgl_akhir);

                //BAR CHART
                $month_data = $this->getMonthData($request->tgl_awal, $request->tgl_akhir);
                $barRekomendasi = $this->getMonthlyData(1,$request->kategori,$request->customer_id,$request->tgl_awal, $request->tgl_akhir);
                $barPengiriman = $this->getMonthlyData(2,$request->kategori,$request->customer_id,$request->tgl_awal, $request->tgl_akhir);
                $barInstalasi = $this->getMonthlyData(3,$request->kategori,$request->customer_id,$request->tgl_awal, $request->tgl_akhir);
                
                return view('monitoring_mesin.report.filter', compact(
                    'model', 'customer','stgl_awal','stgl_akhir','skategori','scustomer_id','sstatus',
                    'pieRekomendasi','pieRencana','pieRealisasi','pieSelesai', 
                    'month_data','barRekomendasi','barPengiriman','barInstalasi'
                ));
            break;
            
            //EXPORT
            case 'export':
                return (new excelReport($request->kategori ?? '',$request->customer_id ?? '',$request->tgl_awal,$request->tgl_akhir))
                ->download('Report Monitoring Mesin '.$request->tgl_awal.' - '.$request->tgl_akhir.'.xls');   
            break;
        }
    }

    public function detail($id)
    {
        $model = Pengiriman_Header::findOrFail($id);
        $detail = Pengiriman_Detail::where('header_id',$id)->get();
        return view('monitoring_mesin.report.detail', compact('model','detail'));
    }

    public function detailexcel($id)
    {
        $model = Pengiriman_Header::findOrFail($id);
        return (new excelDetail($id))
        ->download('Detail Monitoring Mesin '.$model->id.'.xls'); 
    }
}
