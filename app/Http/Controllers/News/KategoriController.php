<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News\Kategori;
use Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'ASC')->get();
        return view('news.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $kategori = new Kategori;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->created_by = $user->id;
        $kategori->save();

        return redirect()->route('news.kategori.index')->with('success', $kategori->nama_kategori.' berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->status = $request->status;
        $kategori->save();

        return redirect()->route('news.kategori.index')->with('success',  $kategori->nama_kategori.' berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return redirect()->route('news.kategori.index')->with('success',  $kategori->nama_kategori.' berhasil dihapus');
    }
}
