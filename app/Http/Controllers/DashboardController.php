<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arsip\Arsip;
use App\Models\CAPA\CAPA;
use App\Models\Event\Event;
use App\Models\Nomorsurat\Surat_eksternal;
use Storage;

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

        return view('dashboard',compact('jumlah_arsip','jumlah_capa', 'jumlah_surat_eksternal','jumlah_event'));
    }

    public function downloadpanduanregister()   {
            
        return Storage::download("public/TUTORIAL REGISTRASI USER.pdf");
    }

    public function downloadpanduanapprove()   {
            
        return Storage::download("public/TUTORIAL APPROVE USER.pdf");
    }
}
