<?php

namespace App\Http\Controllers\TAM\BA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use App\Models\TAM\BA\Teknisi;
use Auth;

class TeknisiTAMController extends Controller
{
    public function index(){
        $login = Auth::user();
        $users = User::orderBy('name', 'ASC')->where([['active','=','4'],['dept_id','=','5'],['cabang_id','=',$login->cabang_id]])->get();
       
        $teknisis = DB::table('tam_teknisi')
        // $login = Auth::user();
            ->leftJoin('users as teknisi', 'tam_teknisi.teknisi_id', '=', 'teknisi.id')
                    ->select([
                        'teknisi.*','tam_teknisi.status','tam_teknisi.id as teknisi'
                    ])        
                    ->where('teknisi.active',4)
                    ->where('teknisi.cabang_id',$login->cabang_id)
                    ->orderBy('teknisi.name', 'ASC')->get();
        // $data_teknisi = Teknisi::OrderBy('nama_rs', 'ASC')->get();
        return view('tam.ba.teknisi', compact('teknisis','users'));

        
    }

    public function store(Request $request){
        $teknisiall= Teknisi::all();
        $i=1;
        $teknisi= [];
        
        foreach($teknisiall as $row)
        {
            $teknisi[$i] = $row->teknisi_id;
            $i++;
        }
        $ketemu = array_search($request->karyawan_id, $teknisi);
        if($ketemu){
            return redirect()->route('tam.teknisi.index')->with('warning', 'Data Teknisi sudah terdaftar');
        }else{
            $data_teknisi = new Teknisi;
            $data_teknisi->teknisi_id = $request->karyawan_id;
            $data_teknisi->status = 1;
            $data_teknisi->save();
            return redirect()->route('tam.teknisi.index')->with('success', 'Data Teknisi berhasil ditambahkan');
        }
            
    }

    public function destroy($id){
        $data_teknisi = Teknisi::find($id);
        $data_teknisi->delete();

        return redirect()->route('tam.teknisi.index')->with('success', 'Data Teknisi berhasil dihapus');
    }

    
}
