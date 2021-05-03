@extends('layouts.layout')

@section('title')
    {{ config('app.name') }} | List Users
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
        List Users
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active"><a href="{{ route('users.index') }}">Users</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Data Users</h3>
                        <a href="{{ route('users.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah User baru
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" id="datatable">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Nama User</th>
                                    <th class="text-center">Cabang</th>
                                    <th class="text-center">Dept</th>
                                    <th class="text-center">Role</th>
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
    </section>
</div>
@endsection

@section('js-extra')
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'image', name: 'image', orderable: false,searchable: false, className: "text-center"},
                    { data: 'name', name: 'name'},
                    { data: 'kode_cabang', name: 'kode_cabang', className: "text-center"},
                    { data: 'kode_departemen', name: 'kode_departemen', className: "text-center"},
                    { data: 'kol-role', name: 'kol-role', orderable: false},
                    { data: 'active', name: 'active', className: "text-center"},
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>
@endsection