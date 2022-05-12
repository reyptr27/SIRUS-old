@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('css-extra')
<style>
    th { font-size: 13px; }
    td { font-size: 12px; }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Akuisisi Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.akuisisi.index') }}">Akuisisi Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Akuisisi Mesin</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <label for="">Kategori</label>
                                <select name="filter_kategori" id="filter_kategori" class="form-control select2">
                                    <option value="">All</option>
                                    <option value="1">Penambahan</option>
                                    <option value="2">Penggantian</option>
                                    <option value="3">Peminjaman</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Customer</label>
                                <select name="filter_customer" id="filter_customer" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($customer as $row)
                                        <option value="{{ $row->nama_rs }}">{{ $row->nama_rs }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">Status Akuisisi</label>
                                <select name="filter_status" id="filter_status" class="form-control select2">
                                    <option value="">All</option>
                                    <option value="1">Process</option>
                                    <option value="2">Done</option>
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
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">Rencana Kirim</th>
                                        <th class="text-center">Rencana Instalasi</th>
                                        <th class="text-center">Realisasi Kirim</th>
                                        <th class="text-center">Realisasi Instalasi</th>
                                        <th class="text-center">Tgl BAST</th>
                                        <th class="text-center">Akuisisi</th>
                                        <th class="text-center">File / Dokumen</th>
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
        $(function() {
            var dtable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('monitoringmesin.akuisisi.json') }}',
                columns: [
                    { data: 'id', name: 'header.id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'nomor', name: 'header.nomor'},
                    { data: 'kategori', name: 'header.kategori', className: "text-center"},
                    { data: 'customer', name: 'customer.nama_rs'},
                    { data: 'tgl_plan_kirim', name: 'header.tgl_plan_kirim'},
                    { data: 'tgl_plan_instalasi', name: 'header.tgl_plan_instalasi'},
                    { data: 'tgl_kirim', name: 'header.tgl_kirim'},
                    { data: 'tgl_instalasi', name: 'header.tgl_instalasi'},
                    { data: 'tgl_bast', name: 'header.tgl_bast'},
                    { data: 'akuisisi', name: 'header.akuisisi', className: "text-center"},
                    { data: 'upload', name: 'upload', className: "text-center"},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });

            $("#filter_kategori").change(function(){ 
                var search = $(this).val();
                dtable.columns(3).search(search).draw();
            });

            $("#filter_customer").change(function(){ 
                var search = $(this).val();
                dtable.columns(4).search(search).draw();
            });

            $("#filter_status").change(function(){ 
                var search = $(this).val();
                dtable.columns(10).search(search).draw();
            });
        });
    </script>
@endsection