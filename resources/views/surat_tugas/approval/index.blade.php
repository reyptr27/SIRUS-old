@extends('layouts.layout')

@section('title')
    SIRUS | Surat Tugas
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
        Surat Tugas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Surat Tugas</a></li>
        <li class="active"><a href="{{ route('surattugas.approval.index') }}">List Approval</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Approval Surat Tugas</h3>
                        <a href="{{ route('surattugas.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">TGL. SURAT</th>
                                    <th class="text-center">NOMOR</th>
                                    <th class="text-center">KARYAWAN</th>
                                    <th class="text-center">JABATAN</th>
                                    <th class="text-center">KEGIATAN</th>
                                    <th class="text-center">TUJUAN</th>
                                    <th class="text-center">TGL. TUGAS</th>
                                    <th class="text-center">ACTION</th>
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
                ajax: '{{ route('surattugas.approval.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'nomor_surat', name: 'nomor_surat'},
                    { data: 'kol-karyawan', name: 'kol-karyawan'},
                    { data: 'jabatan', name: 'jabatan'},
                    { data: 'kegiatan', name: 'kegiatan'},
                    { data: 'kol-tujuan', name: 'kol-tujuan'},
                    { data: 'kol-tanggal', name: 'kol-tanggal'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection