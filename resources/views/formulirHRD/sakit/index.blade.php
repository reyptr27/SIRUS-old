@extends('layouts.layout')

@section('title')
    SIRUS | Formulir Pemberitahuan Sakit
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
        Formulir Pemberitahuan Sakit
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Formulir HRD</a></li>
        <li class="active"><a href="{{ route('hrd.sakit.index') }}">Formulir Pemberitahuan Sakit</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Formulir Pemberitahuan Sakit</h3>
                        <a href="{{ route('hrd.sakit.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Tgl Form</th>
                                    <th class="text-center">Karyawan</th>
                                    <th class="text-center">Departemen</th>
                                    <th class="text-center">Cabang</th>
                                    <th class="text-center">Tgl Sakit</th>
                                    <th class="text-center">Tgl Masuk</th>
                                    <th class="text-center" width="13%">Upload</th>
                                    <th class="text-center" width="13%">Action</th>
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
                ajax: '{{ route('hrd.sakit.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'name', name: 'name'},
                    { data: 'nama_departemen', name: 'nama_departemen'},
                    { data: 'nama_cabang', name: 'nama_cabang'},
                    { data: 'tanggal_awal', name: 'tanggal_awal'},
                    { data: 'tanggal_masuk', name: 'tanggal_masuk'},
                    { data: 'upload', name: 'upload', orderable: false, searchable: false, className: "text-center"},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection