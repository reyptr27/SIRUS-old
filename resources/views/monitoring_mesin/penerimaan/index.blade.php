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
        Penerimaan Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.penerimaan.index') }}">Penerimaan Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Penerimaan Mesin</h3>
                        <a href="{{ route('monitoringmesin.penerimaan.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <label for="">Gudang</label>
                                <select name="filter_gudang" id="filter_gudang" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($gudang as $row)
                                        <option value="{{ $row->nama_gudang }}">{{ $row->nama_gudang }}</option>
                                    @endforeach
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
                        </div>
                        <div class="col-md-12" style="margin-top:20px;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable" width="100%">
                                    <thead>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tgl Penerimaan</th>
                                        <th class="text-center">Nomor</th>
                                        <th class="text-center">Gudang</th>
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">Surat Jalan</th>
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
                ajax: '{{ route('monitoringmesin.penerimaan.json') }}',
                columns: [
                    { data: 'id', name: 'header.id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'tgl_terima', name: 'header.tgl_terima'},
                    { data: 'nomor', name: 'header.nomor'},
                    { data: 'gudang', name: 'gudang.nama_gudang'},
                    { data: 'customer', name: 'customer.nama_rs'},
                    { data: 'surat_jalan', name: 'header.surat_jalan'},
                    { data: 'created_at', name: 'header.created_at'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });

            $("#filter_gudang").change(function(){ 
                var search = $(this).val();
                dtable.columns(4).search(search).draw();
            });

            $("#filter_customer").change(function(){ 
                var search = $(this).val();
                dtable.columns(5).search(search).draw();
            });
        });
    </script>
@endsection