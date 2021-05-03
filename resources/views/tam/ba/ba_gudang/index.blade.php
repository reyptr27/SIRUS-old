@extends('layouts.layout')

@section('title')
    SIRUS | Berita Acara Serah Terima
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
        Berita Acara Serah Terima
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">BA Serah Terima</a></li>
        <li class="active"><a href="{{ route('bagudang.index') }}">List Berita Acara</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Berita Acara Serah Terima</h3>
                        <a href="{{ route('bagudang.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">NOMOR DOCUMENT</th>
                                    <th class="text-center">TGL. DOCUMENT</th>
                                    <th class="text-center">NAMA GUDANG</th>
                                    <th class="text-center">PENERIMA</th>
                                    <th class="text-center">PENGIRIM</th>
                                    <th class="text-center" width="10%">FILE (DOKUMEN)</th>
                                    <!-- <th class="text-center">TUJUAN</th>
                                    <th class="text-center">TGL. TUGAS</th> -->
                                    <th class="text-center" width="13%">ACTION</th>
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
                ajax: '{{ route('bagudang.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex',  orderable: false,searchable: false, className: "text-center"},
                    { data: 'no_document', name: 'no_document'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'nama_gudang', name: 'nama_gudang'},
                    { data: 'nama_penerima', name: 'nama_penerima'},
                    { data: 'nama_pengirim', name: 'nama_pengirim'},
                    { data: 'upload', name: 'upload', orderable: false, searchable: false, className: "text-center"},
                    
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection