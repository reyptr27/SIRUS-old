<?php

namespace App\Http\Controllers\Audit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Audit\AuditLokasi;

class AuditLokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lokasis = AuditLokasi::OrderBy('lokasi', 'ASC')->get();
        return view('audit.lokasi.index', compact('lokasis'));
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
        $lokasi = new AuditLokasi;
        $lokasi->lokasi = $request->lokasi;
        $lokasi->alamat = $request->alamat;
        $lokasi->status = $request->status;
        $lokasi->save();

        return redirect()->route('audit-lokasi.index')->with('success', $lokasi->lokasi.' berhasil ditambahkan');
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
        $lokasi = AuditLokasi::find($id);
        $lokasi->lokasi = $request->lokasi;
        $lokasi->alamat = $request->alamat;
        $lokasi->status = $request->status;
        $lokasi->save();

        return redirect()->route('audit-lokasi.index')->with('success', $lokasi->lokasi.' berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lokasi = AuditLokasi::find($id);
        $lokasi->delete();

        return redirect()->route('audit-lokasi.index')->with('success', $lokasi->lokasi.' berhasil dihapus');
    }
}
