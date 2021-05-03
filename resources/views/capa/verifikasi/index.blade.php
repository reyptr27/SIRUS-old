@extends('layouts.layout')

@section('title')
    SIRUS | CAPA
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
        Verifikasi CAPA
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('capa.index') }}">CAPA</a></li>
        <li class="active"><a href="{{ route('capa.verifikasi.index') }}">CAPA</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List CAPA</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <label for="">Dari</label>
                                <select name="filter_dari" id="filter_dari" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($dept as $row)
                                        <option value="{{ $row->kode_departemen }}">{{ $row->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Kepada</label>
                                <select name="filter_kepada" id="filter_kepada" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($dept as $row)
                                        <option value="{{ $row->kode_departemen }}">{{ $row->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Lokasi</label>
                                <select name="filter_lokasi" id="filter_lokasi" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($lokasi as $row)
                                        <option value="{{ $row->lokasi }}">{{ $row->lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Verifikasi</label>
                                <select name="filter_status" id="filter_status" class="form-control select2">
                                    <option value="">All</option>
                                    <option value="PROSES-VERIF">Waiting</option>
                                    <option value="NOT-VERIF">Rejected</option>
                                    <option value="VERIFIED">Verified</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:20px;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable" width="100%">
                                    <thead>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nomor</th>
                                        <th class="text-center">Dari</th>
                                        <th class="text-center">Kepada</th>
                                        <th class="text-center" width="20%">Potensi Ketidaksesuaian</th>
                                        <th class="text-center">Lokasi Sumber</th>
                                        <th class="text-center">Tgl Terjadi</th>
                                        <th class="text-center">File (Dokumen)</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Verifikasi</th>
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
        </div>        
    </section>
</div>
@endsection

@section('js-extra')
    <script>
        $(document).ready(function() {
            var dtable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url :'{{ route('capa.verifikasi.json') }}'
                },
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'nomor', name: 'nomor'},
                    { data: 'kode_dari', name: 'kode_dari'},
                    { data: 'kode_kepada', name: 'kode_kepada'},
                    { data: 'inti_masalah', name: 'inti_masalah'},
                    { data: 'lokasi', name: 'lokasi'},
                    { data: 'tgl_terjadi', name: 'tgl_terjadi'},
                    { data: 'upload', name: 'upload'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'approval', name: 'approval', className: "text-center"},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });

            $("#filter_dari").change(function(){ 
                var search = $(this).val();
                dtable.columns(3).search(search).draw();
            });

            $("#filter_kepada").change(function(){ 
                var search = $(this).val();
                dtable.columns(4).search(search).draw();
            });

            $("#filter_lokasi").change(function(){ 
                var search = $(this).val();
                dtable.columns(6).search(search).draw();
            });

            $("#filter_status").change(function(){ 
                var search = $(this).val();
                dtable.columns(10).search(search).draw();
            });
        });
    </script>
@endsection