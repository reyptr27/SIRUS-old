@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
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
        Realisasi Pengiriman dan Instalasi Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.realisasipengiriman.index') }}">Realisasi Pengiriman dan Instalasi Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Realisasi Pengiriman dan Instalasi Mesin</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <label for="">Kategori</label>
                                <select name="filter_kategori" id="filter_kategori" class="form-control select2">
                                    <option value="">All</option>
                                    <option value="Penambahan">Penambahan</option>
                                    <option value="Penggantian">Penggantian</option>
                                    <option value="Peminjaman">Peminjaman</option>
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
                                <label for="">Status</label>
                                <select name="filter_status" id="filter_status" class="form-control select2">
                                    <option value="">All</option>
                                    <option value="Rencana Pengiriman">Rencana Pengiriman</option>
                                    <option value="Pengiriman dan Instalasi">Pengiriman dan Instalasi</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:20px;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable" width="100%">
                                    <thead>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tgl Approval</th>
                                        <th class="text-center">Nomor</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">Rencana Kirim</th>
                                        <th class="text-center">Rencana Instalasi</th>
                                        <th class="text-center">Realisasi Kirim</th>
                                        <th class="text-center">Realisasi Instalasi</th>
                                        <th class="text-center">Status</th>
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
                ajax: '{{ route('monitoringmesin.realisasipengiriman.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'tgl_approval', name: 'tgl_approval'},
                    { data: 'nomor', name: 'nomor'},
                    { data: 'kategori', name: 'kategori', className: "text-center"},
                    { data: 'customer', name: 'customer'},
                    { data: 'tgl_plan_kirim', name: 'tgl_plan_kirim'},
                    { data: 'tgl_plan_instalasi', name: 'tgl_plan_instalasi'},
                    { data: 'kol-kirim', name: 'kol-kirim'},
                    { data: 'kol-instalasi', name: 'kol-instalasi'},
                    { data: 'status', name: 'status', className: "text-center"},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });

            $("#filter_kategori").change(function(){ 
                var search = $(this).val();
                dtable.columns(4).search(search).draw();
            });

            $("#filter_customer").change(function(){ 
                var search = $(this).val();
                dtable.columns(5).search(search).draw();
            });

            $("#filter_status").change(function(){ 
                var search = $(this).val();
                dtable.columns(10).search(search).draw();
            });
        });
    </script>
@endsection