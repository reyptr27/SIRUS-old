@extends('layouts.layout')

@section('title')
    SIRUS | Surat Internal HD
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Surat Internal HD
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Nomor Surat</a></li>
        <li><a href="#">Surat Internal HD</a></li>
        <li class="active"><a href="{{ route('surat.hd.index') }}">List Surat Internal HD</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Surat Internal HD</h3>
                        <a href="{{ route('surat.hd.create') }}" class="btn btn-success pull-right">
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
                                    <th class="text-center">NOMOR SURAT</th>
                                    <th class="text-center">KATEGORI</th>
                                    <th class="text-center">TUJUAN / UP</th>
                                    <th class="text-center" width="25%">KETERANGAN</th>
                                    <th class="text-center">PEMBUAT</th>
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
                ajax: '{{ route('surat.hd.json') }}',
                columns: [
                    //data = dari response data json
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'created_at', name: 'created_at', className: "text-center" },
                    { data: 'no_surat', name: 'no_surat'},
                    { data: 'kategori', name: 'kategori' },
                    { data: 'nama_tujuan', name: 'nama_tujuan' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection