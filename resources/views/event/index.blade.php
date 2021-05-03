@extends('layouts.layout')

@section('title')
    SIRUS | Event
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
        Event
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ route('event.index') }}">Event</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Event</h3>
                        <a href="{{ route('event.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Tgl Event</th>
                                    <th class="text-center">Nama Event</th>
                                    <th class="text-center">Jenis Event</th>
                                    <th class="text-center">Lokasi</th>
                                    <th class="text-center">Dept</th>
                                    <th class="text-center"></th>
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
                ajax: '{{ route('event.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'tanggal', name: 'tanggal'},
                    { data: 'nama_event', name: 'nama_event'},
                    { data: 'jenis_event', name: 'jenis_event'},
                    { data: 'lokasi', name: 'lokasi'},
                    { data: 'kol-dept', name: 'kol-dept'  },
                    { data: 'kol-absen', name: 'kol-absen', orderable: false, searchable: false, className: "text-center"  },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection