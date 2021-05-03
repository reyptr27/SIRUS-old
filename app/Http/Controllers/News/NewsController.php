<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News\Kategori; 
use App\Models\News\News; 
use DB; use DataTables; use Str; use Auth;

class NewsController extends Controller
{
    public function json()
    {
        $news = DB::table('news')
        ->leftJoin('users as created_by', 'created_by.id', '=', 'news.created_by')
        ->leftJoin('users as updated_by', 'updated_by.id', '=', 'news.updated_by')
        ->leftJoin('news_kategori as kategori', 'kategori.id', '=', 'news.kategori_id' )
        ->select([
            'news.id','news.judul','news.konten','kategori.nama_kategori','updated_by.name as updated_by',
            'created_by.name as created_by','news.created_at','news.updated_at'
        ])
        ->get();

        return DataTables::of($news)
            ->addIndexColumn()
            ->editColumn('created_at', function ($news){
                return date('d-m-Y', strtotime($news->created_at) );
            })
            ->editColumn('konten', function ($news) {
                return Str::limit($news->konten, 100);
            })
            ->addColumn('action', 'news.action')
            ->rawColumns(['action'])
            ->escapeColumns([]) //untuk mengaplikasikan html syntax
        ->make(true);
    }

    public function index()
    {
        return view('news.index');
    }

    public function create()
    {   
        $kategoris = Kategori::orderBy('nama_kategori', 'ASC')->get();
        return view('news.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $news = new News;
        $news->judul = $request->judul;
        $news->konten = $request->konten;
        $news->kategori_id = $request->kategori_id;
        $news->created_by = $user->id;
        $news->updated_by = $user->id;
        $news->save();

        return redirect()->route('news.index')->withSuccess('Berita berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('news.index')->withSuccess('Berita berhasil dihapus');
    }
}
