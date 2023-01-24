<?php

namespace App\Http\Controllers;

use Storage;
use App\User;
use Carbon\Carbon;
use App\Models\CAPA\CAPA;
use App\Models\Departemen;
use App\Models\Arsip\Arsip;
use App\Models\Event\Event;
use Illuminate\Http\Request;
use App\Models\Permintaan\Program;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\Permintaan\Pengadaan;
use App\Models\Permintaan\Perbaikan;
use App\Models\Nomorsurat\Surat_eksternal;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        $jumlah_arsip = count(Arsip::all());
        $jumlah_capa  = count(CAPA::all());
        $jumlah_surat_eksternal  = count(Surat_eksternal::all());
        $jumlah_event  = count(Event::all());
       
        //piechart
        $dept = Departemen::where([
            ['status',1],
            ['nama_departemen', '!=' , 'All Department']
        ])->pluck('kode_departemen');
        
        $user = User::orderBy('dept_id')->where([
                ['active', 4],
                ['dept_id', '!=' , 17]
            ])->pluck('dept_id')->toArray();
        $countuser = array_count_values($user);
        $usercount = array_flatten($countuser);
        
        $totaluser = User::where([
            ['active', 4],
            ['dept_id', '!=' , 17]
        ])->count();
        //end piechart

        //areachart
        $perbaikan_all = count(Perbaikan::all());
        $pengadaan_all = count(Pengadaan::all());
        $program_all = count(Program::all());

        $totalformits = $perbaikan_all + $pengadaan_all + $program_all;

        //dd($totalformits);

        $periode = Carbon::now();

        $perbaikan = Perbaikan::select(DB::raw('MONTH(created_at) month, count(*) as count'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('count', 'month')
            ->toArray();
            
        $dataperbaikan = array_map(function($month) use ($perbaikan){
            return Arr::get($perbaikan, $month, 0);
        }, range(1,12));
          
           
        $pengadaan = Pengadaan::select(DB::raw('MONTH(created_at) month, count(*) as count'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('count', 'month')
            ->toArray();

        $datapengadaan = array_map(function($month) use ($pengadaan){
            return Arr::get($pengadaan, $month, 0);
        }, range(1,12));

        $program = Program::select(DB::raw('MONTH(created_at) month, count(*) as count'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('count', 'month')
            ->toArray();

        $dataprogram= array_map(function($month) use ($program){
            return Arr::get($program, $month, 0);
        }, range(1,12));
        
        $totalperbaikan = array_sum($perbaikan);
        $totalpengadaan = array_sum($pengadaan);
        $totalprogram = array_sum($program);

        $totalpermintaanit = $totalperbaikan + $totalpengadaan + $totalprogram;

        //end areachart

        //dd($datapengadaan);
        return view('dashboard',compact(
            'jumlah_arsip','jumlah_capa',
            'jumlah_surat_eksternal',
            'jumlah_event',
            'dept',
            'usercount',
            'totaluser',
            'periode',
            'totalpermintaanit',
            'dataperbaikan',
            'datapengadaan',
            'dataprogram',
            'totalformits'
        ));
    }

    public function downloadpanduanregister()   {
            
        return Storage::download("public/TUTORIAL REGISTRASI USER.pdf");
    }

    public function downloadpanduanapprove()   {
            
        return Storage::download("public/TUTORIAL APPROVE USER.pdf");
    }
}
