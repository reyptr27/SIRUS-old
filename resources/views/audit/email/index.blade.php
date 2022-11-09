@extends('layouts.layout')

@section('title')
    SIRUS | Audit Email
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
            Data Email
        </h1>

        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Audit IT</a></li>
            <li class="active"><a href="{{ route('audit-email.index') }}">Audit Email</a></li>
        </ol>
    </section> 

    <section class="content"> 

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title pull-left">List Email</h3>
                        
                        <button type="button" style="margin-left: 5px;" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahAuditEmail">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        
                        <div class="modal fade" id="tambahAuditEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Data Audit Email</h4>
                                    </div>
                                    <form action="{{ route('audit-email.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama</label>
                                                <input type="text" name="nama" class="form-control" placeholder="Nama User" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" name="email" class="form-control" placeholder="Email" required>
                                            </div>    
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <input type="text" name="password" class="form-control" placeholder="Password Email" required>
                                            </div>    
                                            <div class="form-group">
                                                <label for="">Department</label>
                                                <select name="dept_id" class="form-control" required>
                                                    <option value="" disabled selected>Pilih Department</option>
                                                    @foreach ($dept as $depts)
                                                    <option value="{{ $depts->id }}">{{ $depts->nama_departemen }}</option>
                                                    @endforeach
                                                </select>
                                            </div>  
                                            <div class="form-group">
                                                <label for="">Lokasi</label>
                                                <select name="lokasi_id" class="form-control" required>
                                                    <option value="" disabled selected>Pilih Lokasi</option>
                                                    @foreach ($lokasi as $lokasis)
                                                    <option value="{{ $lokasis->id }}">{{ $lokasis->lokasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>  
                                            <!-- <div class="form-group">
                                                <label for="">Status</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="1">Aktif</option>
                                                    <option value="2">Non-Aktif</option>
                                                </select>
                                            </div> -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">SIMPAN</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#exportAuditEmail">
                            <i class="fa fa-upload"></i> Export
                        </button>

                    </div>

                    <div class="box-body">
                        <div class="col-md-12">
                            
                            <div class="col-md-2">
                                <label for="">Department</label>
                            </div>
                            
                            <div class="col-md-4">             
                                <select name="filter_department" id="filter_department" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($dept as $row)
                                        <option value="{{ $row->nama_departemen }}">{{ $row->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1">
                                
                            </div>

                            <div class="col-md-1">
                                <label for="">Lokasi</label>
                            </div>
                            
                            <div class="col-md-4">
                                <select name="filter_lokasi" id="filter_lokasi" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($lokasi as $row)
                                        <option value="{{ $row->lokasi }}">{{ $row->lokasi }}</option>
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
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Password</th>
                                        <th class="text-center">Departemen</th>
                                        <th class="text-center">Lokasi</th>
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
        </div>

    </section>
</div>
@endsection

@section('js-extra')
    <script>
       $(document).ready(function() {
            var dtable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url :'{{ route('audit-email.json') }}'
                },
                columns: [
                    { data: 'id', name: 'id', "visible": false, searchable: false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'nama', name: 'Nama'},
                    { data: 'email', name: 'Email'},
                    { data: 'password', name: 'Password'},
                    { data: 'dept', name: 'dept.nama_departemen'},
                    { data: 'lokasi', name: 'lokasi.lokasi'},
                    //{ data: 'tgl_terjadi', name: 'tgl_terjadi'},
                    //{ data: 'upload', name: 'upload'},
                    //{ data: 'kol-status', name: 'kol-status', className: "text-center"},
                    //{ data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            }); 

            $("#filter_department").change(function(){ 
                var search = $(this).val();
                dtable.columns(5).search(search).draw();
            });

            $("#filter_lokasi").change(function(){ 
                var search = $(this).val();
                dtable.columns(6).search(search).draw();
            });
        });
    </script>
@endsection