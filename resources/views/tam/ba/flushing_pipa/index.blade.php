@extends('layouts.layout')

@section('title')
    SIRUS | Berita Acara Flushing Pipa
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
        Berita Acara Flushing Pipa
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">BA Flushing Pipa</a></li>
        <li class="active"><a href="{{ route('flushing.index') }}">List Berita Acara</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Berita Acara Flushing Pipa</h3>
                        <a href="{{ route('flushing.create') }}" class="btn btn-success pull-right">
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
                                    <th class="text-center">TGL. PENGERJAAN</th>
                                    <th class="text-center">NAMA RS</th>
                                    <th class="text-center">TEKNISI</th>
                                    <th class="text-center" width="10%">FILE (DOKUMEN)</th>
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
                ajax: '{{ route('flushing.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex',  orderable: false,searchable: false, className: "text-center"},
                    { data: 'nomor', name: 'nomor'},
                    { data: 'tanggal', name: 'tanggal'},
                    { data: 'nama_rs', name: 'nama_rs'},
                    { data: 'teknisi', name: 'teknisi'},                    
                    { data: 'upload', name: 'upload', orderable: false, searchable: false, className: "text-center"},                    
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection