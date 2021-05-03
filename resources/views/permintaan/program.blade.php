@extends('layouts.layout')

@section('title')
    SIMIT | Program
@endsection
    
@section('content')

<div class="content-wrapper">

    <!-- Section Content Header -->
    <section class="content-header">
        <h1>Permintaan Program Aplikasi</h1>

        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#"></a>Permintaan IT</li>
            <li><a href="{{ route('pengadaan.index') }}">Permintaan Program Aplikasi</a></li>
        </ol>
    </section>

    <!-- Section Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <!-- BOX Header -->
                    <div class="box-header with-border text-center">
                        <h3 class="box-title text-center">List Permintaan Program Aplikasi</h3>

                        <a href="{{ route('program.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah Pengajuan
                        </a>
                                        
                    </div>
                    <!-- Box Body -->

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" id="datatable">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">TANGGAL</th>
                                    <th class="text-center">NOMOR PERMINTAAN</th>
                                    <th class="text-center">PEMOHON</th>
                                    <th class="text-center">JENIS PERMINTAAN</th>
                                    <th class="text-center">PROGRAM</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center" width="120px">ACTION</th>
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
                ajax: '{{ route('program.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'created_at', name: 'created_at', className: "text-center" },
                    { data: 'no_document', name: 'no_document'},
                    { data: 'pemohon', name: 'pemohon'},
                    { data: 'jenis', name: 'jenis'},
                    { data: 'program', name: 'program'},
                    { data: 'approval', name: 'approval'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection
