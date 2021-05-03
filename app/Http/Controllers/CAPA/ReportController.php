<?php

namespace App\Http\Controllers\CAPA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;
use App\Exports\CAPA\excelReport;
use App\Models\Departemen;
use App\Models\CAPA\CAPA;
use App\Models\CAPA\Lokasi;
use App\User;
use DB; use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $dept = Departemen::where('status',1)->orderBy('nama_departemen','ASC')->get();
        $lokasi = Lokasi::where('status',1)->orderBy('lokasi','ASC')->get();
        return view('capa.report.index', compact('dept','lokasi'));
    }

    //PIE CHART
    public function getPieCount($tgl_awal, $tgl_akhir, $lokasi_id, $dept_id, $status)
    {
        $model = DB::table('capa')
        ->leftJoin('m_departemen as kepada', 'kepada.id', '=', 'capa.kepada_id')
        ->leftJoin('m_departemen as dari', 'dari.id', '=', 'capa.dari_id')
        ->leftJoin('capa_lokasi as lokasi', 'lokasi.id', '=', 'capa.lokasi_id')
        ->leftJoin('users as pic', 'pic.id', '=', 'capa.pic_id')
        ->leftJoin('users as verifikator', 'verifikator.id', '=', 'capa.verifikator_id')
        ->leftJoin('users as creator', 'creator.id', '=', 'capa.created_by')
        ->leftJoin('users as updater', 'updater.id', '=', 'capa.updated_by')
        ->select([
            'capa.*','kepada.nama_departemen as kepada','kepada.kode_departemen as kode_kepada','dari.nama_departemen as dari','dari.kode_departemen as kode_dari',
            'lokasi.lokasi','pic.name as pic','verifikator.name as verifikator','creator.name as creator','updater.name as updater'
        ])->whereBetween('capa.created_at', [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:00"]);
        
        if($lokasi_id != null){
            $model = $model->where('capa.lokasi_id', $lokasi_id);
        }

        if($dept_id != null){
            $model = $model->where('capa.kepada_id', $dept_id);
        }

        $model->where('capa.status', $status);

        $pieCount  = $model->get()->count();
        return $pieCount;
    }
    //END PIE CHART

    //BAR CHART
    public function getMonth($tgl_awal, $tgl_akhir)
    {
        $month_Indo = array("", "Januari","Februari","Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober", "November","Desember");
        $month_array = array();
        $posts_dates = CAPA::select('created_at')->whereBetween('created_at', [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:00"])->orderBy('created_at','ASC')->get();
        if(!empty($posts_dates)){
            foreach($posts_dates as $unformatted_date){
                $date_no = date('my', strtotime($unformatted_date->created_at));
                $date_name = $month_Indo[date('n', strtotime($unformatted_date->created_at))]." ".date('Y', strtotime($unformatted_date->created_at));
                $month_array[$date_no] = $date_name;
            }
        }
        return $month_array;
    }

    public function getMonthlyCount($month, $lokasi_id, $dept_id)
    {    

        $model = DB::table('capa')
            ->select([
                'capa.*'
            ]);
            
            if($lokasi_id != null){
                $model = $model->where('capa.lokasi_id', $lokasi_id);
            }

            if($dept_id != null){
                $model = $model->where('capa.kepada_id', $dept_id);
            }

        $monthly_post_count = $model->whereMonth('capa.created_at', $month)->get()->count();

        return $monthly_post_count;
    }

    
    public function getMonthlyData($tgl_awal, $tgl_akhir, $lokasi_id, $dept_id)
    {
        $monthly_post_count_array = array();
        $month_array = $this->getMonth($tgl_awal, $tgl_akhir);
        if(!empty($month_array)){
            foreach ($month_array as $month_no => $month_name) {
                $monthly_post_count = $this->getMonthlyCount(substr($month_no,0,2), $lokasi_id, $dept_id);
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

    public function getData(Request $request)
    {
        switch ($request->input('action')) {
            case 'filter':
                //Search
                $stgl_awal  = $request->tgl_awal;
                $stgl_akhir = $request->tgl_akhir;
                $slokasi_id    = $request->lokasi_id;
                $sdept_id    = $request->dept_id;
                

                $dept = Departemen::where('status',1)->orderBy('nama_departemen','ASC')->get();
                $lokasi = Lokasi::where('status',1)->orderBy('lokasi','ASC')->get();
                
                //Data Filter
                $model = DB::table('capa')
                ->leftJoin('m_departemen as kepada', 'kepada.id', '=', 'capa.kepada_id')
                ->leftJoin('m_departemen as dari', 'dari.id', '=', 'capa.dari_id')
                ->leftJoin('capa_lokasi as lokasi', 'lokasi.id', '=', 'capa.lokasi_id')
                ->leftJoin('users as pic', 'pic.id', '=', 'capa.pic_id')
                ->leftJoin('users as verifikator', 'verifikator.id', '=', 'capa.verifikator_id')
                ->leftJoin('users as creator', 'creator.id', '=', 'capa.created_by')
                ->leftJoin('users as updater', 'updater.id', '=', 'capa.updated_by')
                ->select([
                    'capa.*','kepada.nama_departemen as kepada','kepada.kode_departemen as kode_kepada','dari.nama_departemen as dari','dari.kode_departemen as kode_dari',
                    'lokasi.lokasi','pic.name as pic','verifikator.name as verifikator','creator.name as creator','updater.name as updater'
                ])->whereBetween('capa.created_at', [$request->tgl_awal." 00:00:00", $request->tgl_akhir." 23:59:00"]);
                
                if($request->lokasi_id != null){
                    $model = $model->where('capa.lokasi_id', $request->lokasi_id);
                }

                if($request->dept_id != null){
                    $model = $model->where('capa.kepada_id', $request->dept_id);
                }

                $model = $model->get();

                //PIE
                $pieProcess = $this->getPieCount($request->tgl_awal,$request->tgl_akhir,$request->lokasi_id,$request->dept_id,1);
                $pieVerif   = $this->getPieCount($request->tgl_awal,$request->tgl_akhir,$request->lokasi_id,$request->dept_id,2);
                $pieReject  = $this->getPieCount($request->tgl_awal,$request->tgl_akhir,$request->lokasi_id,$request->dept_id,3);
                // END PIE 

                $month_data = $this->getMonthData($request->tgl_awal, $request->tgl_akhir);
                $barCAPA = $this->getMonthlyData($request->tgl_awal, $request->tgl_akhir, $request->lokasi_id, $request->dept_id);
                
                return view('capa.report.filter', compact(
                    'model', 'stgl_awal','stgl_akhir','slokasi_id','sdept_id',
                    'lokasi','dept', 'pieProcess','pieVerif','pieReject','month_data',
                    'barCAPA'
                ));
            break;

            case 'excel':
                return (new excelReport($request->tgl_awal, $request->tgl_akhir, $request->lokasi_id ?? '', $request->dept_id ?? ''))
                ->download('CAPA '.$request->tgl_awal.' - '.$request->tgl_akhir.'.xls');   
            break;

            case 'pdf':
                $model  = CAPA::whereBetween('created_at', [$request->tgl_awal." 00:00:00", $request->tgl_akhir." 23:59:00"])->where('status',2);
               
                if($request->lokasi_id != null){
                    $model = $model->where('lokasi_id', $request->lokasi_id);
                }

                if($request->dept_id != null){
                    $model = $model->where('kepada_id', $request->dept_id);
                }

                $model = $model->get();

                $pdf = PDF::loadView('capa.report.pdf', compact('model'))->setPaper('a4', 'landscape');
                return $pdf->stream('CAPA '.$request->tgl_awal.' - '.$request->tgl_akhir.'.pdf');
            break;
        }
    }

    public function detail($id)
    {
        $model = CAPA::findOrFail($id);
        $dari  = Departemen::where('id',$model->dari_id)->first();
        $kepada= Departemen::where('id',$model->kepada_id)->first();
        $lokasi= Lokasi::where('id',$model->lokasi_id)->first();
        $pic   = User::where('id',$model->pic_id)->first();
        $verifikator= User::where('id',$model->verifikator_id)->first();
        $creator= User::where('id',$model->created_by)->first();
        $updater= User::where('id',$model->updated_by)->first();

        return view('capa.report.detail', compact('model','dari','kepada','lokasi','pic','verifikator','creator','updater'));
    }
}
