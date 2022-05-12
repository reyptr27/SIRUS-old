@extends('layouts.layout')

@section('title')
    SIRUS | Manual Book
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
        Manual Book
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ route('manualbook.index') }}">Manual Book</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Manual Book</h3>
                        <a href="{{ route('manualbook.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Cover</th>
                                    <th class="text-center">Judul</th>
                                    <th class="text-center">Departemen</th>
                                    <th class="text-center">Diupload Oleh</th>
                                    <th class="text-center">Tgl Upload</th>
                                    <th class="text-center">Action</th>
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
                ajax: '{{ route('manualbook.json') }}',
                columns: [
                    { data: 'id', name: 'mb.id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'cover_image', name: 'cover_image', orderable: false,searchable: false, className: "text-center"},
                    { data: 'judul', name: 'mb.judul'},
                    { data: 'kol-dept', name: 'kol-dept'},
                    { data: 'creator', name: 'c.name'},
                    { data: 'created_at', name: 'mb.created_at'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection