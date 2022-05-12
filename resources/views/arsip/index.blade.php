@extends('layouts.layout')

@section('title')
    SIRUS | Manajemen Arsip
@endsection

@section('css-extra')
<style>
    th { font-size: 14px; }
    td { font-size: 12px; }
    .select2-selection.select2-selection--multiple {
        min-height: 25px;
        max-height: 25px;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Manajemen Arsip
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Arsip</a></li>
        <li class="active"><a href="{{ route('arsip.index') }}">List Arsip</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Arsip</h3>
                        <a href="{{ route('arsip.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="col-md-1">
                                <label for="">Jenis</label>
                            </div>
                            <div class="col-md-4">
                                
                                <select name="filter_jenis" id="filter_jenis" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($jenis as $row)
                                        <option value="{{ $row->jenis_arsip }}">{{ $row->jenis_arsip }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                
                            </div>
                            <div class="col-md-1">
                                <label for="">Diupload oleh</label>
                            </div>
                            <div class="col-md-4">
                                <select name="filter_uploader" id="filter_uploader" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($karyawans as $row)
                                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-12" style="margin-top:20px;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable" width="100%">
                                    <thead>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Jenis Arsip</th>
                                        <th class="text-center">Tgl Arsip</th>
                                        <th class="text-center">Nomor</th>
                                        <th class="text-center">Nama Arsip</th>
                                        <th class="text-center">Deskripsi</th>
                                        <th class="text-center">Tgl Upload</th>
                                        <th class="text-center">Diupload Oleh</th>
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
        </div>        
    </section>
</div>
@endsection

@section('js-extra')
    <script>
        $(function() {
            var dtable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('arsip.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'jenis_arsip', name: 'jenis_arsip.jenis_arsip'},
                    { data: 'tgl_arsip', name: 'tgl_arsip', className: "text-center"},
                    { data: 'nomor', name: 'nomor' },
                    { data: 'nama_arsip', name: 'nama_arsip' },
                    { data: 'deskripsi', name: 'deskripsi', "visible": false },
                    { data: 'created_at', name: 'created_at', className: "text-center" },
                    { data: 'uploader', name: 'uploader.name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });

            $("#filter_jenis").change(function(){ 
                var search = $(this).val();
                dtable.columns(2).search(search).draw();
            });

            $("#filter_uploader").change(function(){ 
                var search = $(this).val();
                dtable.columns(8).search(search).draw();
            });
        });
    </script>
@endsection