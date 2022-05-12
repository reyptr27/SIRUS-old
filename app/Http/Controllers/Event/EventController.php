<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;
use App\Models\Event\Event;
use App\Models\Event\Event_Dept;
use App\Models\Event\Event_Absen;
use App\Models\Event\Notulen;
use App\Models\Event\Notulen_Detail;
use App\Models\Departemen;
use App\Exports\excelEvent;
use App\User; use DB; use DataTables; use Auth; use PDF; use Session;

class EventController extends Controller
{
    public function json()
    {
        $user = Auth::user();
        
        if($user->hasPermissionTo('event-all')){
            $event = DB::table('event')
                ->leftJoin('users', 'users.id', '=', 'event.created_by')
                ->leftJoin('event_dept', 'event_dept.event_id','=','event.id')
                ->select([
                    'event.id','event.tanggal','event.nama_event','event.keterangan','event.lokasi', 'event.jenis_event',
                    'users.name as created_by','event.created_at','event_dept.dept_id','event.all_dept'
                ])
            ->groupBy('event.id');
        }else{
            $event = DB::table('event')
                ->leftJoin('users', 'users.id', '=', 'event.created_by')
                ->leftJoin('event_dept', 'event_dept.event_id','=','event.id')
                ->select([
                    'event.id','event.tanggal','event.nama_event','event.keterangan','event.lokasi','event.jenis_event',
                    'users.name as created_by','event.created_at','event_dept.dept_id','event.all_dept'
                ])
                ->where(['event_dept.dept_id' => $user->dept_id])->orWhere(['event.all_dept' => 1])
            ->groupBy('event.id'); 
        }
        
        return DataTables::of($event)
            ->addIndexColumn()
            ->editColumn('tanggal', function ($event){
                return date('d-m-Y', strtotime($event->tanggal) );
            }) 
            ->editColumn('created_at', function ($event){
                return date('d-m-Y', strtotime($event->created_at) );
            })
            ->editColumn('keterangan', function ($event){
                if($event->keterangan != null){
                    return $event->keterangan;
                }else{
                    return '<i>(kosong)<i>';
                }
                
            })
            ->editColumn('jenis_event', function ($event){
                if($event->jenis_event == 1){
                    return 'Briefing';
                }elseif($event->jenis_event == 2){
                    return 'Meeting';
                }elseif($event->jenis_event == 3){
                    return 'Training';
                }elseif($event->jenis_event == 4){
                    return 'Lain-lain';
                }
                
            })
            ->addColumn('action', 'event.action')
            ->addColumn('kol-dept', 'event.kol-dept')
            ->addColumn('kol-absen', 'event.kol-absen')
            ->rawColumns(['action','kol-dept','kol-absen'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('event.index');
    }

    public function create()
    {   
        $departemens = Departemen::orderBy('nama_departemen', 'ASC')->get();
        return view('event.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $event = new Event;
        $event->tanggal     = $request->tanggal;
        $event->nama_event  = $request->nama_event;
        $event->jenis_event = $request->jenis_event;
        $event->keterangan  = $request->keterangan;
        $event->lokasi      = $request->lokasi;
        $event->created_by  = $user->id;
        $event->save();

        if($request->dept_id[0] == "ALL"){
            $event->all_dept = 1;
            $event->save();
        }else{
            $i = 0;
            foreach($request->dept_id as $row){
                $ed = new Event_Dept;
                $ed->event_id = $event->id;
                $ed->dept_id = $request->dept_id[$i];
                $ed->save();
                $i++;
            }
        }
        return redirect()->route('event.index')->withSuccess($event->nama_event.' Berhasil ditambahkan');
    }

    public function edit($id)
    {   
        $event = Event::findOrFail($id);
        $event_dept = Event_Dept::where(['event_id' => $event->id])->get();
        $departemens = Departemen::orderBy('nama_departemen', 'ASC')->get();
        return view('event.edit', compact('departemens','event', 'event_dept'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->tanggal     = $request->tanggal;
        $event->nama_event  = $request->nama_event;
        $event->jenis_event = $request->jenis_event;
        $event->keterangan  = $request->keterangan;
        $event->lokasi      = $request->lokasi;
        $event->save();

        $event_dept = Event_Dept::where(['event_id' => $event->id])->get();
        if($event_dept){
            $event_dept->each->delete();
        }

        if($request->dept_id[0] == "ALL"){
            $event->all_dept = 1;
            $event->save();
        }else{
            $event->all_dept = 0;
            $event->save();
            $i = 0;
            foreach($request->dept_id as $row){
                $ed = new Event_Dept;
                $ed->event_id = $event->id;
                $ed->dept_id = $request->dept_id[$i];
                $ed->save();
                $i++;
            }
        }
        return redirect()->route('event.index')->withSuccess($event->nama_event.' Berhasil diupdate');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if($event->all_dept == 0){
            $ed = Event_Dept::where(['event_id' => $event->id])->get();
            $ed->each->delete();
        }
        $event->delete();
        return redirect()->route('event.index')->withSuccess($event->nama_event.' Berhasil dihapus');
    }

    //Absensi
    public function viewAbsensi($id)
    {
        $event = Event::findOrFail($id);
        if($event->tanggal == date('Y-m-d')){
            return view('event.absensi', compact('event'));
        }else{
            return redirect()->route('event.index')->withWarning('Event telah berakhir');
        }
    }

    public function getKaryawan(Request $request,$id)
    {   
        if($request->ajax()){
            $user = User::where(['nik' => $request->nik])->first();
            $event_absen = Event_Absen::where(['event_id' => $id, 'karyawan_id' => $user->id])->first();
            $data = DB::table('users')
                ->leftJoin('m_departemen as dept', 'users.dept_id', '=', 'dept.id')
                ->select([
                    'users.id','users.name as nama','users.nik','dept.nama_departemen as dept',
                ])->where(['users.nik' => $request->nik])->first();
            return response()->json([
                'log' => $event_absen,
                'user' => $data,
            ]);
    	}
    }

    public function storeAbsensi(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $absen = new Event_Absen;
        $absen->event_id = $event->id;
        $absen->karyawan_id = $request->user_id;
        $absen->in = date('Y-m-d H:i:s');
        $absen->save();
        
        return redirect()->back()->withSuccess('Anda berhasil masuk / login event');
    }

    public function updateAbsensi(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $absen = Event_Absen::where(['id' => $request->log_id])->first();
        $absen->out = date('Y-m-d H:i:s');
        $waktu_awal  = strtotime($absen->in);
        $waktu_akhir = strtotime($absen->out);
        $diff        = $waktu_akhir - $waktu_awal;
        $menit       = floor($diff/60);
        $absen->time = $menit;
        $absen->save();
        return redirect()->back()->withSuccess('Anda berhasil keluar / logout event');
    }

    public function viewLog($id)
    {
        $event = Event::findOrFail($id);
        $pesertas = Event_Absen::where(['event_id' => $id])->get();
        return view('event.log', compact('event','pesertas'));
    }
    
    public function excelLog($id)
    {
        $event = Event::findOrFail($id);

        return (new excelEvent($id))
        ->download('log Absensi '.$event->nama_event.' - '.$event->id.'.xls');   
    }

    public function pdfLog($id)
    {
        $event = Event::findOrFail($id);
        $pesertas = Event_Absen::where(['event_id' => $id])->get();
        
        $pdf = PDF::loadView('event.export_log.pdf', compact('event', 'pesertas'));
        return $pdf->stream('log Absensi '.$event->nama_event.' - '.$event->id.'.pdf');
    }

    public function print(Request $request, $id)
    {
        if($request->print_option == 1){
            $event = Event::findOrFail($id);
            $pesertas = Event_Absen::where(['event_id' => $id])->get();
            
            $pdf = PDF::loadView('event.export_log.pdf', compact('event', 'pesertas'));
            return $pdf->stream('log Absensi '.$event->nama_event.' - '.$event->id.'.pdf');
        }else{
            $event = Event::findOrFail($id);
            $notulen = Notulen::where(['event_id' => $id])->first();
            $event_dept = Event_Dept::where(['event_id' => $event->id])->get();

            if($notulen != null){
                $notulen_detail = Notulen_Detail::where(['notulen_id' => $notulen->id])->get();
                $pdf = PDF::loadView('event.notulen.pdf', compact('event', 'notulen','notulen_detail','event_dept'));
                return $pdf->stream('Notulen '.$event->nama_event.' - '.$event->id.'.pdf');    
            }else{
                $pdf = PDF::loadView('event.notulen.pdf2', compact('event','event_dept'));
                return $pdf->stream('Notulen '.$event->nama_event.' - '.$event->id.'.pdf');    
            }
        }
    }
}
