@extends('layouts.layout')

@section('title')
    SIRUS | News
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        News
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">News</a></li>
        <li class="active"><a href="{{ route('news.create') }}">Tambah News</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah News</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('news.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Judul</label>
                                <input type="text" name="judul" class="form-control" placeholder="Judul" required>
                            </div>
                            <div class="form-group">
                                <label for="">Konten</label>
                                <textarea name="konten" id="my-editor" cols="30" rows="10" placeholder="Konten" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select name="kategori_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer pull-left">                              
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('news.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection

@section('js-extra')
    <script src="{{ asset('assets/vendors/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'my-editor', {
            filebrowserImageBrowseUrl: '/sirus/ laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/sirus/ laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: '/sirus/ laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/sirus/ laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
        });
    </script>
@endsection
