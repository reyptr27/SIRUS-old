@extends('layouts.layout')

@section('title')
    SIRUS | News List
@endsection

@section('css-extra')
<style>
    th { font-size: 14px; }
    td { font-size: 12px; }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        News List
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">News</a></li>
        <li class="active"><a href="{{ route('news.index') }}">News List</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">News List</h3>
                        <a href="{{ route('news.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Judul</th>
                                    <th class="text-center" width="25%">Konten</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Created by</th>
                                    <th class="text-center">Created at</th>
                                    <th class="text-center" width="15%">ACTION</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection

@section('js-extra')
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('news.json') }}',
                columns: [
                    { data: 'id', name: 'news.id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'judul', name: 'news.judul'},
                    { data: 'konten', name: 'news.konten'},
                    { data: 'nama_kategori', name: 'kategori.nama_kategori'},
                    { data: 'created_by', name: 'created_by.name'},
                    { data: 'created_at', name: 'news.created_at', className: "text-center" },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection