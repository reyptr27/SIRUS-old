@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
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
        Rekomendasi Pengiriman Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.rekomendasi.index') }}">Rekomendasi Pengiriman Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Rekomendasi Pengiriman Mesin</h3>
                        <a href="{{ route('monitoringmesin.rekomendasi.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
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
                                    <option value="Rekomendasi">Rekomendasi</option>
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
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Created at</th>
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
                ajax: {
                    url :'{{ route('monitoringmesin.rekomendasi.json') }}'
                },
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'tgl_approval', name: 'tgl_approval'},
                    { data: 'nomor', name: 'nomor'},
                    { data: 'kategori', name: 'kategori', className: "text-center"},
                    { data: 'customer', name: 'customer'},
                    { data: 'status', name: 'status', className: "text-center"},
                    { data: 'created_at', name: 'created_at'},
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
                dtable.columns(6).search(search).draw();
            });
        });
    </script>
@endsection