<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arsip\Arsip;
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
        return view('dashboard',compact('jumlah_arsip'));
    }

    public function downloadpanduanregister()   {
            
        return Storage::download("public/TUTORIAL REGISTRASI USER.pdf");
    }

    public function downloadpanduanapprove()   {
            
        return Storage::download("public/TUTORIAL APPROVE USER.pdf");
    }
}
