<?php

namespace App\Http\Controllers\Arsip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Arsip\Arsip;
use App\Models\Arsip\Jenis_arsip;
use DataTables; use App\User;
use DB; use Auth; use Storage; use PDF;

class ArsipController extends Controller
{
    public function json()
    {   
        $user = Auth::user();
        $role = $user->roles->pluck('name')->first();
        if($user->hasPermissionTo('audit-it')){
            $arsip = DB::table('arsip')
                    ->leftJoin('jenis_arsip', 'arsip.jenis_id', '=', 'jenis_arsip.id')
                    ->leftJoin('users as uploader', 'arsip.created_by', '=', 'uploader.id')
                    ->leftJoin('users as updater', 'arsip.updated_by', '=', 'updater.id')
                    ->select([
                        'arsip.id','jenis_arsip.jenis_arsip','arsip.created_at','arsip.nomor','arsip.nama_arsip','jenis_arsip.dept_id',
                        'arsip.tgl_arsip','arsip.tahun','uploader.name as uploader','arsip.deskripsi','arsip.file_size',
                        'arsip.jumlah_download','arsip.format_file','arsip.upload_file','updater.name as updater','arsip.updated_at'
                    ])->where(['arsip.delete_status' => 1]);
        }else{
            $arsip = DB::table('arsip')
            ->leftJoin('jenis_arsip', 'arsip.jenis_id', '=', 'jenis_arsip.id')
            ->leftJoin('users as uploader', 'arsip.created_by', '=', 'uploader.id')
            ->leftJoin('users as updater', 'arsip.updated_by', '=', 'updater.id')
            ->select([
                'arsip.id','jenis_arsip.jenis_arsip','arsip.created_at','arsip.nomor','arsip.nama_arsip','jenis_arsip.dept_id',
                'arsip.tgl_arsip','arsip.tahun','uploader.name as uploader','arsip.deskripsi','arsip.file_size',
                'arsip.jumlah_download','arsip.format_file','arsip.upload_file','updater.name as updater','arsip.updated_at'
            ])->where(['arsip.delete_status' => 1, 'jenis_arsip.dept_id'=>$user->dept_id]);
        }
        return DataTables::of($arsip)
            ->addIndexColumn()
            ->editColumn('created_at', function ($arsip){
                return date('d-m-Y', strtotime($arsip->created_at) );
            })
            ->editColumn('tgl_arsip', function ($arsip){
                return date('d-m-Y', strtotime($arsip->tgl_arsip) );
            })
            ->editColumn('nomor', function ($arsip){
                return '<a data-target="#detailArsip'.$arsip->id.'" data-toggle="modal" href=#detailArsip'.$arsip->id.'">'.$arsip->nomor.'</a>';
            })
            ->addColumn('action', 'arsip.action') //mengambil dari blade view
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        $user = Auth::user();
        $karyawans = User::where('active', 4)->orderBy('name','ASC')->get();
        if($user->hasPermissionTo('arsip-all')){
            $jenis = Jenis_arsip::orderBy('jenis_arsip', 'ASC')->get();
        }else{
            $jenis = Jenis_arsip::where(['dept_id' => $user->dept_id,'status' => 1])->orderBy('jenis_arsip', 'ASC')->get();
        }
        
        return view('arsip.index', compact('jenis','karyawans'));
    }

    public function create()
    {   
        $user = Auth::user();
        if($user->hasPermissionTo('arsip-all')){
            $jenis = Jenis_arsip::orderBy('jenis_arsip', 'ASC')->get();
        }else{
            $jenis = Jenis_arsip::where(['dept_id' => $user->dept_id,'status' => 1])->orderBy('jenis_arsip', 'ASC')->get();
        }
        return view('arsip.create', compact('user', 'jenis'));
    }

    function FileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
            $arBytes = array(
                0 => array(
                    "UNIT" => "TB",
                    "VALUE" => pow(1024, 4)
                ),
                1 => array(
                    "UNIT" => "GB",
                    "VALUE" => pow(1024, 3)
                ),
                2 => array(
                    "UNIT" => "MB",
                    "VALUE" => pow(1024, 2)
                ),
                3 => array(
                    "UNIT" => "KB",
                    "VALUE" => 1024
                ),
                4 => array(
                    "UNIT" => "B",
                    "VALUE" => 1
                ),
            );

        foreach($arBytes as $arItem)
        {
            if($bytes >= $arItem["VALUE"])
            {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'upload_file' => 'required|file|mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
            'tgl_arsip' => 'required|date',
            'jenis_id' => 'required',
            'nama_arsip' => 'nullable|string',
            'nomor' => 'required|string',
            'deskripsi' => 'nullable|string'
        ]);
        
        $user = Auth::user();
        $dept = Departemen::where(['id' => $user->dept_id])->first();
        $jenis = Jenis_arsip::where(['id' => $request->jenis_id])->first();
        
        $arsip = new Arsip;
        $arsip->jenis_id    = $request->jenis_id;
        $arsip->nomor       = $request->nomor;
        $arsip->nama_arsip  = $request->nama_arsip;
        $arsip->deskripsi   = $request->deskripsi;
        $arsip->tgl_arsip   = $request->tgl_arsip;
        $arsip->tahun       = date('Y', strtotime($request->tgl_arsip));
        $arsip->format_file = $request->file('upload_file')->extension();
        
        $fileSizeBytes      = filesize($request->file('upload_file'));
        $arsip->file_size   = self::FileSizeConvert($fileSizeBytes);
        $arsip->jumlah_download = 0;
        $arsip->created_by  = $user->id;
        $arsip->updated_by  = $user->id;
        $nama_file = time().'_'.$request->file('upload_file')->getClientOriginalName();
        $arsip->upload_file = $nama_file;

        $path = Storage::putFileAs(
            'arsip/'.$dept->kode_departemen.'/'.$arsip->tahun.'/'.$jenis->jenis_arsip, //direktori
            $request->file('upload_file'), //file
            $nama_file //nama file berupa time_nama-dokumen-asli
        );
        
        $arsip->save();

        return redirect()->route('arsip.index')->withSuccess($arsip->nama_arsip." Berhasil disimpan di ".$path);
    }

    public function edit($id)
    {   
        $arsip = Arsip::findOrFail($id);
        $user = Auth::user();
        if($user->hasPermissionTo('arsip-all')){
            $jenis = Jenis_arsip::orderBy('jenis_arsip', 'ASC')->get();
        }else{
            $jenis = Jenis_arsip::where(['dept_id' => $user->dept_id,'status' => 1])->orderBy('jenis_arsip', 'ASC')->get();
        }
        return view('arsip.edit', compact('user', 'jenis','arsip'));
    }

    public function update(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id);

        $this->validate($request, [
            'nama_arsip' => 'required|string',
            'nomor' => 'required|string',
            'deskripsi' => 'nullable|string'
        ]);

        $user = Auth::user();
        $arsip->nomor       = $request->nomor;
        $arsip->nama_arsip  = $request->nama_arsip;
        $arsip->deskripsi   = $request->deskripsi;
        $arsip->updated_by  = $user->id;
        $arsip->save();
        return redirect()->route('arsip.index')->withSuccess($arsip->nama_arsip." Berhasil diupdate");
    }

    public function download($id)
    {
        $arsip = Arsip::findOrFail($id);
        $jenis = Jenis_arsip::where(['id' => $arsip->jenis_id])->first();
        $dept = Departemen::where(['id' => $jenis->dept_id])->first();

        $arsip->jumlah_download = $arsip->jumlah_download+1;
        $arsip->save();
        return Storage::download("/arsip/".$dept->kode_departemen."/".$arsip->tahun."/".$jenis->jenis_arsip."/".$arsip->upload_file, $arsip->tgl_arsip.'_'.$arsip->nama_arsip.'.'.$arsip->format_file);
    }

    public function delete($id)
    {
        $arsip  = Arsip::findOrFail($id);
        $user   = Auth::user();
        $arsip->delete_status   = 2;
        $arsip->deleted_by      = $user->id;
        $arsip->save();
        return redirect()->route('arsip.index')->withSuccess($arsip->nama_arsip." Berhasil dihapus");
    }

    public function show($id)
    {   
        $arsip = Arsip::findOrFail($id);
        $jenis = Jenis_arsip::where(['id' => $arsip->jenis_id])->first();
        $dept = Departemen::where(['id' => $jenis->dept_id])->first();

        return Storage::response("/arsip/".$dept->kode_departemen."/".$arsip->tahun."/".$jenis->jenis_arsip."/".$arsip->upload_file, $arsip->tgl_arsip.'_'.$arsip->nama_arsip.'.'.$arsip->format_file);

    }

    //FILE SAMPAH
    public function jsonTrash()
    {   
        $user = Auth::user();
        $arsip = DB::table('arsip')
                ->leftJoin('jenis_arsip', 'arsip.jenis_id', '=', 'jenis_arsip.id')
                ->leftJoin('users as uploader', 'arsip.created_by', '=', 'uploader.id')
                ->leftJoin('users as updater', 'arsip.updated_by', '=', 'updater.id')
                ->leftJoin('users as delete', 'arsip.deleted_by', '=', 'delete.id')
                ->leftJoin('m_departemen as dept', 'jenis_arsip.dept_id', '=', 'dept.id')
                ->select([
                    'arsip.id','jenis_arsip.jenis_arsip','arsip.created_at','arsip.nomor','arsip.nama_arsip','jenis_arsip.dept_id',
                    'arsip.tgl_arsip','arsip.tahun','uploader.name as uploader','arsip.deskripsi','arsip.file_size','delete.name as deleted_by',
                    'arsip.jumlah_download','arsip.format_file','arsip.upload_file','updater.name as updater','arsip.updated_at','dept.kode_departemen'
                ])->where(['arsip.delete_status' => 2]);

        return DataTables::of($arsip)
            ->addIndexColumn()
            ->editColumn('created_at', function ($arsip){
                return date('d-m-Y', strtotime($arsip->created_at) );
            })
            ->editColumn('nomor', function ($arsip){
                return '<a data-target="#detailArsip'.$arsip->id.'" data-toggle="modal" href=#detailArsip'.$arsip->id.'">'.$arsip->nomor.'</a>';
            })
            ->addColumn('action', 'arsip.trashaction') //mengambil dari blade view
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function indexTrash()
    {
        return view('arsip.trash');
    }

    public function destroy($id)
    {
        $arsip  = Arsip::findOrFail($id);
        $jenis  = Jenis_arsip::where(['id' => $arsip->jenis_id])->first();
        $dept   = Departemen::where(['id' => $jenis->dept_id])->first();

        Storage::delete("/arsip/".$dept->kode_departemen."/".$arsip->tahun."/".$jenis->jenis_arsip."/".$arsip->upload_file, $arsip->tgl_arsip.'-'.$arsip->nama_arsip);
        $arsip->delete();
        return redirect()->back()->withSuccess($arsip->nama_arsip." Berhasil dihapus");
    }

    public function restore($id)
    {
        $arsip  = Arsip::findOrFail($id);
        $user   = Auth::user();
        $arsip->delete_status   = 1;
        $arsip->save();
        return redirect()->back()->withSuccess($arsip->nama_arsip." Berhasil direstore");
    }
}
