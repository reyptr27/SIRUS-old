<?php

namespace App\Http\Controllers\ManualBook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ManualBook\ManualBook;
use App\Models\ManualBook\ManualBook_Departemen;
use App\User; use App\Models\Departemen;
use Storage; use DB; use DataTables; use Auth; 

class ManualBookController extends Controller
{
    public function json()
    {
        $user = Auth::user();
        if($user->hasPermissionTo('manual-book-all')){
            $model = DB::table('manual_book as mb')
                ->leftJoin('users as c', 'c.id', '=', 'mb.created_by')
                ->leftJoin('users as u', 'u.id', '=', 'mb.updated_by')
                ->leftJoin('manual_book_departemen as dept', 'dept.manual_id','=','mb.id')
                ->select([
                   'mb.*' ,'u.name as updater','c.name as creator'  
                ])
            ->groupBy('mb.id');
        }else{
            $model = DB::table('manual_book as mb')
                ->leftJoin('users as c', 'c.id', '=', 'mb.created_by')
                ->leftJoin('users as u', 'u.id', '=', 'mb.updated_by')
                ->leftJoin('manual_book_departemen as dept', 'dept.manual_id','=','mb.id')
                ->select([
                   'mb.*' ,'u.name as updater','c.name as creator'  
                ])
            ->groupBy('mb.id')
            ->where('dept.dept_id',$user->dept_id)->orWhere('mb.all_dept', 1);
        }

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('cover_image', function ($model){
                if($model->cover_image == null){
                    $url=asset("storage/ManualBook/cover/default.jpg"); 
                    return '<img src='.$url.' width="175" height="250" >';
                }else{
                    $url=asset("storage/ManualBook/cover/$model->cover_image"); 
                    return '<img src='.$url.' width="175" height="250" >';
                }
            })
            ->editColumn('created_at', function ($model){
                return date('d-m-Y', strtotime($model->created_at) );
            })
            ->editColumn('judul', function ($model){
                return '<a data-target="#lihatModel'.$model->id.'" data-toggle="modal" href=#lihatModel'.$model->id.'">'.$model->judul.'</a>';
            })
            ->addColumn('kol-dept', 'manual_book.kol-dept')
            ->addColumn('action', 'manual_book.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('manual_book.index');
    }

    public function create()
    {
        $departemens = Departemen::where('status',1)->orderBy('nama_departemen','ASC')->get();

        return view('manual_book.create',compact('departemens'));
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
        $user = Auth::user();
        $model = new ManualBook;
        $model->judul       = $request->judul;
        $model->deskripsi   = $request->deskripsi;
        $model->created_by  = $user->id;
        $model->updated_by  = $user->id;

        $format_file        = $request->file('upload_file')->extension();
        $model->format_file = $format_file;
        $fileSizeBytes      = filesize($request->file('upload_file'));
        $model->file_size   = self::FileSizeConvert($fileSizeBytes);
        $nama_file = time().'_'.$request->judul.'.'.$format_file;
        $model->upload_file = $nama_file;

        Storage::putFileAs(
            'public/ManualBook/file', //direktori
            $request->file('upload_file'), //file
            $nama_file //nama file berupa time_nama-dokumen-asli
        );

        if($request->cover_image){
            $nama_cover         = time().'_'.$request->file('cover_image')->getClientOriginalName();
            $model->cover_image = $nama_cover;
            $path2 = Storage::putFileAs(
                'public/ManualBook/cover/', //direktori
                $request->file('cover_image'), //file
                $nama_cover
            );
        }
        
        $model->save();

        if($request->dept_id[0] == "ALL"){
            $model->all_dept = 1;
            $model->save();
        }else{
            $i = 0;
            foreach($request->dept_id as $row){
                $md = new ManualBook_Departemen;
                $md->manual_id = $model->id;
                $md->dept_id = $request->dept_id[$i];
                $md->save();
                $i++;
            }
        }
        return redirect()->route('manualbook.index')->withSuccess($model->judul.' Berhasil ditambahkan');

    }

    public function edit($id)
    {
        $model = ManualBook::findOrFail($id);
        $model_dept = ManualBook_Departemen::where(['manual_id' => $model->id])->get();
        $departemens = Departemen::where('status',1)->orderBy('nama_departemen','ASC')->get();

        return view('manual_book.edit',compact('model','departemens','model_dept'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $model = ManualBook::findOrFail($id);
        $model->judul       = $request->judul;
        $model->deskripsi   = $request->deskripsi;
        $model->updated_by  = $user->id;

        if($request->upload_file){
            Storage::delete('public/ManualBook/file/'.$model->upload_file);
            $format_file        = $request->file('upload_file')->extension();
            $model->format_file = $format_file;
            $fileSizeBytes      = filesize($request->file('upload_file'));
            $model->file_size   = self::FileSizeConvert($fileSizeBytes);
            $nama_file = time().'_'.$request->judul.'.'.$format_file;
            $model->upload_file = $nama_file;

            Storage::putFileAs(
                'public/ManualBook/file/', //direktori
                $request->file('upload_file'), //file
                $nama_file //nama file berupa time_nama-dokumen-asli
            );
        }

        if($request->cover_image){
            if($model->cover_image){
                Storage::delete('public/ManualBook/cover/'.$model->cover_image);
            }
            $nama_cover         = time().'_'.$request->file('cover_image')->getClientOriginalName();
            $model->cover_image = $nama_cover;
            Storage::putFileAs(
                'public/ManualBook/cover/', //direktori
                $request->file('cover_image'), //file
                $nama_cover
            );
        }

        $model_dept = ManualBook_Departemen::where(['manual_id' => $model->id])->get();
        if($model_dept){
            $model_dept->each->delete();
        }

        if($request->dept_id[0] == "ALL"){
            $model->all_dept = 1;
        }else{
            $model->all_dept = 0;
            $i = 0;
            foreach($request->dept_id as $row){
                $md = new ManualBook_Departemen;
                $md->manual_id = $model->id;
                $md->dept_id = $request->dept_id[$i];
                $md->save();
                $i++;
            }
        }
        $model->save();

        return redirect()->route('manualbook.index')->withSuccess($model->judul.' Berhasil diupdate');
    }

    public function download($id)
    {
        $model = ManualBook::findOrFail($id);  
        $model->jumlah_download = $model->jumlah_download+1;
        $model->save();
        return Storage::download("public/ManualBook/file/".$model->upload_file);
    }

    public function show($id)
    {   
        $model = ManualBook::findOrFail($id);
        $model->jumlah_lihat = $model->jumlah_lihat+1;
        $model->save();    
        return Storage::response("public/ManualBook/file/".$model->upload_file);       
    }

    public function destroy($id)
    {   
        $model = ManualBook::findOrFail($id);
        if($model->cover_image){
            Storage::delete('public/ManualBook/cover/'.$model->cover_image);
        }

        if($model->upload_file){
            Storage::delete('public/ManualBook/file/'.$model->upload_file);
        }
        
        $model->delete();    
        return redirect()->route('manualbook.index')->withSuccess($model->judul.' Berhasil dihapus');     
    }
}
