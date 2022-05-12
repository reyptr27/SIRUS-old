<?php

namespace App\Http\Controllers\Nomorsurat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nomorsurat\Tujuan_NHD;
use App\Models\Nomorsurat\Kategori_NHD;
use App\Models\Nomorsurat\Surat_NHD;
use DataTables;
use DB;

class SuratNHDController extends Controller
{
    //Tujuan
    public function indexTujuan()
    {
        $tujuans = Tujuan_NHD::orderBy('nama_tujuan', 'ASC')->get();
        return view('nomorsurat.tujuannhd', compact('tujuans'));
    }

    public function storeTujuan(Request $request)
    {
        $tujuan = new Tujuan_NHD;
        $tujuan->nama_tujuan = $request->nama_tujuan;
        $tujuan->status = $request->status;
        $tujuan->save();

        return redirect()->route('tujuan.nhd.index')->with('success', $tujuan->nama_tujuan.' berhasil ditambahkan');
    }

    public function updateTujuan(Request $request, $id)
    {
        $tujuan = Tujuan_NHD::find($id);
        $tujuan->nama_tujuan = $request->nama_tujuan;
        $tujuan->status = $request->status;
        $tujuan->save();

        return redirect()->route('tujuan.nhd.index')->with('success',  $tujuan->nama_tujuan.' berhasil diupdate');
    }

    public function destroyTujuan($id)
    {
        $tujuan = Tujuan_NHD::find($id);
        $tujuan->delete();

        return redirect()->route('tujuan.nhd.index')->with('success',  $tujuan->nama_tujuan.' berhasil dihapus');
    }

    //Kategori
    public function indexKategori()
    {
        $kategoris = Kategori_NHD::orderBy('kategori', 'ASC')->get();
        
        return view('nomorsurat.kategorinhd', compact('kategoris'));
    }

    public function storeKategori(Request $request)
    {
        $kategori = new Kategori_NHD;
        $kategori->kategori = $request->kategori;
        $kategori->status = $request->status;
        $kategori->save();

        return redirect()->route('kategori.nhd.index')->with('success',   $kategori->kategori.' berhasil ditambahkan');
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori_NHD::find($id);
        $kategori->kategori = $request->kategori;
        $kategori->status = $request->status;
        $kategori->save();

        return redirect()->route('kategori.nhd.index')->with('success', $kategori->kategori.' berhasil diupdate');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori_NHD::find($id);
        $kategori->delete();

        return redirect()->route('kategori.nhd.index')->with('success', $kategori->kategori.' berhasil dihapus');
    }

    //Surat
    public function json()
    {
        $surat = DB::table('surat_nhd')
                ->leftJoin('tujuan_nhd', 'surat_nhd.tujuan_id', '=', 'tujuan_nhd.id')
                ->leftJoin('kategori_nhd', 'surat_nhd.kategori_id', '=', 'kategori_nhd.id')
                ->leftJoin('users', 'surat_nhd.created_by', '=', 'users.id')
                ->select([
                    'surat_nhd.id','surat_nhd.no_surat','surat_nhd.created_at',
                    'surat_nhd.keterangan','tujuan_nhd.nama_tujuan','kategori_nhd.kategori','users.name'
                ]);
        
        return DataTables::of($surat)
            ->addIndexColumn()
            ->editColumn('created_at', function ($surat){
                return date('d-m-Y', strtotime($surat->created_at) );
            })
            ->editColumn('keterangan', function ($surat){
                if(!empty($surat->keterangan)){
                    return $surat->keterangan;
                }else{
                    return '<i>(kosong)</i>';
                }
            })
            ->addColumn('action', 'nomorsurat.NHDaction') //mengambil dari blade view
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('nomorsurat.suratnhd');
    }

    public function create(){
        $tujuans        = Tujuan_NHD::orderBy('nama_tujuan', 'ASC')->where('status','=','1')->get();
        $kategoris      = Kategori_NHD::orderBy('kategori', 'ASC')->where('status','=','1')->get();
        return view('nomorsurat.NHDcreate', compact('kategoris','tujuans'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tujuan_id'=> 'required',
            'kategori_id'=> 'required',
        ]);

        $suratterakhir = Surat_NHD::orderBy('created_at', 'DESC')->first(); 
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        
        $surat = new Surat_NHD;
        
        if($suratterakhir == null){
            $hasil = "1";
        }else{
            $nomor = $suratterakhir->no_surat;
            $pisah = explode('/', $nomor);

            if ((int)$pisah[0] > 0 && $pisah[4] != date('Y')) {
               $hasil = "1";
            }else{
                $hasil = (int)$pisah[0]+1;    
            }
        }

        $datano = sprintf("%03s", $hasil);
        $nomorsurat= $datano."/NHD/SBY"."/".$bulanRomawi[date('n')]."/".date('Y');
        $surat->no_surat  = $nomorsurat;

        $surat->tujuan_id = $request->tujuan_id;
        $surat->kategori_id = $request->kategori_id;
        $surat->keterangan= $request->keterangan;
        $surat->created_by= $request->created_by;
        $surat->save();

        return redirect()->route('surat.nhd.index')->withSuccess( $surat->no_surat.' berhasil ditambahkan');
    }

    public function edit($id)
    {
        $surat = Surat_NHD::findOrFail($id);
        $tujuans        = Tujuan_NHD::orderBy('nama_tujuan', 'ASC')->where('status','=','1')->get();
        $kategoris      = Kategori_NHD::orderBy('kategori', 'ASC')->where('status','=','1')->get();
        return view('nomorsurat.NHDedit', compact('kategoris','tujuans','surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = Surat_NHD::findOrFail($id);

        $this->validate($request, [
            'tujuan_id'=> 'required',
            'kategori_id'=> 'required',
        ]);

        $surat->tujuan_id = $request->tujuan_id;
        $surat->kategori_id = $request->kategori_id;
        $surat->keterangan= $request->keterangan;
        $surat->save();
        return redirect()->route('surat.nhd.index')->withSuccess($surat->no_surat.' berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat = Surat_NHD::findOrFail($id);
        $surat->delete();
        return redirect()->route('surat.nhd.index')->withSuccess($surat->no_surat .' berhasil dihapus');
    }
}
