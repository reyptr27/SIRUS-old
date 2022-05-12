@extends('layouts.layout')

@section('title')
    SIRUS | Surat Masuk
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
        Surat Masuk
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Surat Masuk</a></li>
        <li class="active"><a href="{{ route('surat.masuk.index') }}">Surat Masuk</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Surat Masuk</h3>
                        <a href="{{ route('surat.masuk.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">TANGGAL</th>
                                    <th class="text-center">NOMOR</th>
                                    <th class="text-center">CUSTOMER</th>
                                    <th class="text-center">TGL EKSTERNAL</th>
                                    <th class="text-center">NO EKSTERNAL</th>
                                    <th class="text-center">HAL</th>
                                    <th class="text-center">TUJUAN / UP</th>
                                    <th class="text-center">DEPT</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center" width="8%">FILE</th>
                                    <th class="text-center" width="8%">ACTION</th>
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
                ajax: '{{ route('surat.masuk.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'tgl_terima', name: 'tgl_terima', className: "text-center" },
                    { data: 'nomor', name: 'nomor'},
                    { data: 'customer', name: 'customer'},
                    { data: 'tgl_eksternal', name: 'tgl_eksternal'},
                    { data: 'nomor_eksternal', name: 'nomor_eksternal'},
                    { data: 'hal', name: 'hal'},
                    { data: 'up_id', name: 'up_id'},
                    { data: 'dept_id', name: 'dept_id'},
                    { data: 'tindakan', name: 'tindakan', className: "text-center"},
                    { data: 'upload', name: 'upload'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection