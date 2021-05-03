<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event\Notulen_Detail;
use App\Models\Event\Notulen;
use App\Models\Event\Event;
use App\Models\Event\Event_Dept;
use App\Models\Departemen;
use App\Models\Divisi;
use App\User;
use PDF;

class NotulenController extends Controller
{
    public function form($id)
    {
        $event = Event::findOrFail($id);
        $notulen = Notulen::where(['event_id' => $id])->first();
        $departemens = Departemen::orderBy('nama_departemen', 'ASC')->get();
        $divisis = Divisi::orderBy('nama_divisi', 'ASC')->get();

        if(empty($notulen)){
            return view('event.notulen.create', compact('event','departemens','divisis'));
        }else{
            $notulen_detail = Notulen_Detail::where(['notulen_id' => $notulen->id])->get();
            return view('event.notulen.edit', compact('event', 'notulen','departemens','divisis','notulen_detail'));
        }
    }

    public function store(Request $request,$id)
    {
        $event = Event::findOrFail($id);
        $notulen = new Notulen;
        $notulen->event_id   = $event->id;
        $notulen->divisi_id  = $request->divisi_id;
        if($request->kategori_1){
            $notulen->kategori_1 = $request->kategori_1;
        }else{
            $notulen->kategori_1 = false;
        }

        if($request->kategori_2){
            $notulen->kategori_2 = $request->kategori_2;
        }else{
            $notulen->kategori_2 = false;
        }

        if($request->kategori_3){
            $notulen->kategori_3 = $request->kategori_3;
        }else{
            $notulen->kategori_3 = false;
        }
       
        $notulen->save();

        $i = 0;
        foreach($request->deskripsi as $row){
            $detail = new Notulen_Detail;
            $detail->notulen_id = $notulen->id;
            $detail->deskripsi  = $request->deskripsi[$i];
            $detail->dept_id    = $request->dept_id[$i];
            $detail->tgl_target = $request->tgl_target[$i];
            $detail->realisasi  = $request->realisasi[$i];
            $detail->notes      = $request->notes[$i];
            $detail->status     = $request->status[$i];
            $detail->save();
            $i++;
        }

        return redirect()->route('event.index')->withSuccess('Notulen berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $notulen = Notulen::where(['event_id' => $id])->first();

        $notulen->divisi_id  = $request->divisi_id;
        if($request->kategori_1){
            $notulen->kategori_1 = $request->kategori_1;
        }else{
            $notulen->kategori_1 = false;
        }

        if($request->kategori_2){
            $notulen->kategori_2 = $request->kategori_2;
        }else{
            $notulen->kategori_2 = false;
        }

        if($request->kategori_3){
            $notulen->kategori_3 = $request->kategori_3;
        }else{
            $notulen->kategori_3 = false;
        }
        $notulen->save();
        $notulen_detail = Notulen_Detail::where(['notulen_id' => $notulen->id])->get();
        if($notulen_detail){
            $notulen_detail->each->delete();
        }
        $i = 0;
        foreach($request->deskripsi as $row){
            $detail = new Notulen_Detail;
            $detail->notulen_id = $notulen->id;
            $detail->deskripsi  = $request->deskripsi[$i];
            $detail->dept_id    = $request->dept_id[$i];
            $detail->tgl_target = $request->tgl_target[$i];
            $detail->realisasi  = $request->realisasi[$i];
            $detail->notes      = $request->notes[$i];
            $detail->status     = $request->status[$i];
            $detail->save();
            $i++;
        }

        return redirect()->route('event.index')->withSuccess('Notulen berhasil diupdate');
    }

    public function print($id)
    {
        $event = Event::findOrFail($id);
        $notulen = Notulen::where(['event_id' => $id])->first();
        $notulen_detail = Notulen_Detail::where(['notulen_id' => $notulen->id])->get();
        $event_dept = Event_Dept::where(['event_id' => $event->id])->get();

        $pdf = PDF::loadView('event.notulen.pdf', compact('event', 'notulen','notulen_detail','event_dept'));
        return $pdf->stream('Notulen '.$event->nama_event.' - '.$event->id.'.pdf');
    }
}
