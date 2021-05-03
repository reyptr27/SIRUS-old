<?php

namespace App\Http\Controllers\Portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Portal\Portal;
use Auth;

class PortalController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            return redirect()->route('dashboard');
        }else
        {
            $link = Portal::all();
            return view('portal.index',compact('link'));

        }
    }

    public function link()
    {
        $portal = Portal::OrderBy('id', 'DESC')->get();
        return view('portal.link', compact('portal'));
    }

    public function create()
    {
        return view('portal.create');
    }

    public function store(Request $request){
        $portal = new Portal;
        $portal->nama_aplikasi = $request->nama_aplikasi;
        $portal->subtitle = $request->subtitle;
        $portal->icon = $request->icon;
        $portal->save();

        return redirect()->route('portal.link')->with('success',  $portal->nama_aplikasi.' berhasil ditambahkan');
    }

    public function destroy($id){
        $portal = Portal::find($id);
        $portal->delete();

        return redirect()->route('portal.link')->with('success', $portal->nama_aplikasi.' berhasil dihapus');
    }
}
