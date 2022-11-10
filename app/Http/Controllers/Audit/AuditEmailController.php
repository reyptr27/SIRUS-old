<?php

namespace App\Http\Controllers\Audit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Audit\AuditLokasi;
use App\Models\Audit\AuditEmail;
use App\Models\Departemen;
use App\User;
use App\Exports\Audit\Email\AuditEmailExport;
use Maatwebsite\Excel\Excel;
use Auth; 
use DataTables; 
use DB; 


class AuditEmailController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function export() 
    {
        return $this->excel->download(new AuditEmailExport, 'auditemail.xlsx', Excel::XLSX);
    }

    public function json()
    {
        $user = Auth::user();
        
        if($user->hasPermissionTo('audit-it')){
            $auditemail = DB::table('audit_email')
                ->leftJoin('m_departemen as dept', 'dept.id', '=', 'audit_email.dept_id')
                ->leftJoin('audit_lokasi as lokasi', 'lokasi.id', '=', 'audit_email.lokasi_id')
                ->select([
                    'audit_email.*', 'dept.nama_departemen as dept', 'lokasi.lokasi'
                ])
            ->groupBy('audit_email.id');
        }

        return DataTables::of($auditemail)
            ->addIndexColumn()
            //  ->editColumn('lokasi_id', function ($model){
            //      return $model->lokasi->nama_lokasi;
            //  })
            //  ->editColumn('tgl_terjadi', function ($model){
            //      return date('d-m-Y', strtotime($model->tgl_terjadi) );
            //  })
            //->addColumn('kol-status', 'audit-email.kol-status')
            ->addColumn('action', 'audit.email.action')
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dept = Departemen::where([
            ['status',1],
            ['nama_departemen', '!=' , 'All Department']
        ])->orderBy('nama_departemen','ASC')->get();
        $lokasi = AuditLokasi::where('status',1)->orderBy('lokasi','ASC')->get();

        return view('audit.email.index',compact('dept','lokasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auditemail = new AuditEmail;
        $auditemail->nama = $request->nama;
        $auditemail->email = $request->email;
        $auditemail->password = $request->password;
        $auditemail->dept_id = $request->dept_id;
        $auditemail->lokasi_id = $request->lokasi_id;
        $auditemail->save();

        return redirect()->route('audit-email.index')->with('success', 'Data audit email berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auditemail = AuditEmail::find($id);
        $auditemail->nama = $request->nama;
        $auditemail->email = $request->email;
        $auditemail->password = $request->password;
        $auditemail->dept_id = $request->dept_id;
        $auditemail->lokasi_id = $request->lokasi_id;
        $auditemail->save();

        return redirect()->route('audit-email.index')->with('success', $auditemail->email.' berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auditemail = AuditEmail::find($id);
        $auditemail->delete();

        return redirect()->route('audit-email.index')->with('success', $auditemail->email.' berhasil dihapus');
    }
}
