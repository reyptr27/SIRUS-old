<?php

namespace App\Http\Controllers\Nomorsurat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nomorsurat\SuratMasuk;
use App\Models\Departemen;
use App\User;
use Auth; use DataTables; use Storage;


class SuratMasukController extends Controller
{
    public function json(){
        $auth = Auth::user();

        if($auth->hasPermissionTo('nomorsurat-masuk-all')){
            $model = SuratMasuk::query()->with(['creator', 'up', 'departemen']);
        }else{
            $model = SuratMasuk::query()->with(['creator', 'up', 'departemen'])
            ->where('dept_id', $auth->dept_id)
            ->orWhere('up_id', $auth->id)
            ->orWhere('created_by', $auth->id);
        }

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('tgl_terima', function ($model){
                return date('d-m-Y', strtotime($model->tgl_terima) );
            })
            ->editColumn('tgl_eksternal', function ($model){
                return date('d-m-Y', strtotime($model->tgl_eksternal) );
            })
            ->editColumn('up_id', function ($model){
                return $model->up->name;
            })
            ->editColumn('dept_id', function ($model){
                return $model->departemen->nama_departemen;
            })
            ->editColumn('tindakan', function ($model){
                if($model->tindakan == 1){
                    return '<label class="label label-warning" style="font-size:11px;"><i class="fa fa-download"></i> diterima sekretariat</label>';
                }else if($model->tindakan == 2){
                    return '<label class="label label-primary" style="font-size:11px;"><i class="fa fa-check-square-o"></i> diterima oleh up</label>';
                }else if($model->tindakan == 3){
                    return '<label class="label label-success" style="font-size:11px;"><i class="fa fa-reply"></i> dibalas oleh up</label>';
                }
            })
            ->editColumn('keterangan', function ($model){
                if(!empty($model->keterangan)){
                    return $model->keterangan;
                }else{
                    return '<i>(kosong)</i>';
                }
            })
            ->addColumn('upload', 'nomorsurat.suratmasuk.upload')
            ->addColumn('action', 'nomorsurat.suratmasuk.action') //mengambil dari blade view
            ->rawColumns(['action','upload'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('nomorsurat.suratmasuk.index');
    }

    public function create()
    {
        $departemens = Departemen::orderBy('nama_departemen', 'ASC')->where('status', 1)->get();
        $karyawans   = User::orderBy('name', 'ASC')->where('active', 4)->get();

        return view('nomorsurat.suratmasuk.create', compact('departemens','karyawans'));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $this->validate($request, [
            'tgl_terima'=> 'required',
            'customer'=> 'required',
            'tgl_eksternal'=> 'required',
            'nomor_eksternal'=> 'required|string',
            'hal'=> 'required|string',
            'up_id'=> 'required',
            'dept_id'=> 'required',
            'perlu_balasan'=> 'required',
        ]);

        $suratterakhir = SuratMasuk::orderBy('id', 'DESC')->first(); 
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        
        $model = new SuratMasuk;
        
        if($suratterakhir == null){
            $hasil = "1";
        }else{
            $nomor = $suratterakhir->nomor;
            $pisah = explode('/', $nomor);

            if ((int)$pisah[0] > 0 && $pisah[4] != date('Y')) {
               $hasil = "1";
            }else{
                $hasil = (int)$pisah[0]+1;    
            }
        }

        $datano     = sprintf("%04s", $hasil);
        $nomorsurat = $datano."/SM/SBY"."/".$bulanRomawi[date('n')]."/".date('Y');

        $model->nomor           = $nomorsurat;
        $model->nomor_eksternal = $request->nomor_eksternal;
        $model->tgl_terima      = $request->tgl_terima;
        $model->tgl_eksternal   = $request->tgl_eksternal;
        $model->hal             = $request->hal;
        $model->up_id           = $request->up_id;
        $model->dept_id         = $request->dept_id;
        $model->customer        = $request->customer;
        $model->perlu_balasan   = $request->perlu_balasan;
        $model->keterangan      = $request->keterangan;
        $model->created_by      = $auth->id;

        $model->save();

        return redirect()->route('surat.masuk.index')->withSuccess( $model->nomor.' berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = SuratMasuk::findORFail($id);
        $departemens = Departemen::orderBy('nama_departemen', 'ASC')->where('status', 1)->get();
        $karyawans   = User::orderBy('name', 'ASC')->where('active', 4)->get();

        return view('nomorsurat.suratmasuk.edit', compact('departemens','karyawans', 'model'));
    }

    public function update(Request $request, $id)
    {
        $auth = Auth::user();
        $model = SuratMasuk::findOrFail($id);

        $this->validate($request, [
            'tgl_terima'=> 'required',
            'customer'=> 'required',
            'tgl_eksternal'=> 'required',
            'nomor_eksternal'=> 'required|string',
            'hal'=> 'required|string',
            'up_id'=> 'required',
            'dept_id'=> 'required',
            'perlu_balasan'=> 'required',
        ]);
       
        $model->nomor_eksternal = $request->nomor_eksternal;
        $model->customer        = $request->customer;
        $model->tgl_terima      = $request->tgl_terima;
        $model->tgl_eksternal   = $request->tgl_eksternal;
        $model->hal             = $request->hal;
        $model->up_id           = $request->up_id;
        $model->dept_id         = $request->dept_id;
        $model->perlu_balasan   = $request->perlu_balasan;
        $model->keterangan      = $request->keterangan;

        $model->save();

        return redirect()->route('surat.masuk.index')->withSuccess('Surat masuk ' .$model->nomor. ' berhasil diupdate');
    }

    public function destroy($id){
        $model = SuratMasuk::findOrFail($id);

        if($model->upload_file != null){
            Storage::delete("public/SuratMasuk/".$model->upload_file);
        }

        $model->delete();
        
        return redirect()->route('surat.masuk.index')->withSuccess('Surat masuk ' .$model->nomor. ' berhasil dihapus');
    }

    //Upload File
    public function upload(Request $request, $id)
    {
        $model = SuratMasuk::findOrFail($id);
        //upload file
        
            if($model->upload_file != null){
                Storage::delete("public/SuratMasuk/".$model->upload_file);
            } 

            $path = Storage::putFileAs(
                'public/SuratMasuk/', //direktori
                $request->file('upload_file'), //file
                time().'_'.$request->file('upload_file')->getClientOriginalName()//nama file berupa time_nama-dokumen-asli
            );
            
            $nama_file = time().'_'.$request->file('upload_file')->getClientOriginalName();
            $model->upload_file = $nama_file;
            $model->save();
        
        return redirect()->route('surat.masuk.index')->withSuccess("Surat Berhasil diupload");
        // return response()->json($request);
    }
    public function download($id)
    {
        $model = SuratMasuk::findOrFail($id);       
        return Storage::download("public/SuratMasuk/".$model->upload_file);
    }

    public function show($id)
    {   
        $model = SuratMasuk::findOrFail($id);       
        return Storage::response("public/SuratMasuk/".$model->upload_file);       
    }
}
