@extends('layouts.layout')

@section('title')
    SIRUS | Manajemen Arsip
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
        <li class="active"><a href="{{ route('trash.index') }}">List Trash Bin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Trash Bin</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Jenis Arsip</th>
                                    <th class="text-center">DEPT</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Nomor</th>
                                    <th class="text-center">Nama Arsip</th>
                                    <th class="text-center">Tgl Upload</th>
                                    <th class="text-center">Dihapus Oleh</th>
                                    <th class="text-center" width="10%">ACTION</th>
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
                ajax: '{{ route('trash.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'jenis_arsip', name: 'jenis_arsip'},
                    { data: 'kode_departemen', name: 'kode_departemen', className: "text-center"},
                    { data: 'tahun', name: 'tahun', className: "text-center"},
                    { data: 'nomor', name: 'nomor' },
                    { data: 'nama_arsip', name: 'nama_arsip' },
                    { data: 'created_at', name: 'created_at', className: "text-center" },
                    { data: 'deleted_by', name: 'deleted_by' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection