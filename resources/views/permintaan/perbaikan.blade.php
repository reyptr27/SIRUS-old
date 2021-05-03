@extends('layouts.layout')

@section('title')
    SIMIT | Perbaikan
@endsection
    
@section('content')

<div class="content-wrapper">

    <!-- Section Content Header -->
    <section class="content-header">
        <h1>Permintaan Perbaikan</h1>

        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#"></a>Permintaan IT</li>
            <li><a href="{{ route('perbaikan.index') }}">Permintaan Perbaikan</a></li>
        </ol>
    </section>

    <!-- Section Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <!-- BOX Header -->
                    <div class="box-header with-border text-center">

                        <h3 class="box-title text-center">List Permintaan Perbaikan</h3>

                        <a href="{{ route('perbaikan.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah Perbaikan
                        </a> 
                         <br><br><br>

                        <div class="col-sm-12">
                            <form action="{{route('export.perbaikan')}}" class="form-inline pull-right" method="GET">
                            <div class="col-sm-12">
                                <label for="">Export : </label> 
                                <div class="input-daterange input-group" data-plugin-datepicker="">
                                    <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="date" class="form-control" name="startDate" id="input-datepicker" style="width:10em;" placeholder="Tanggal awal" required>
                                    <span class="input-group-addon">-</span>
                                    <input type="date" class="form-control" name="endDate" id="input-datepicker" style="width:10em;" placeholder="Tanggal akhir" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm" name="action" value="excel"><i class="fa fa-file-excel-o "></i> Excel</button>
							    <button type="submit" class="btn btn-primary btn-sm" name="action" value="pdf"><i class="fa fa-file"></i> PDF</button>
                            </div>
                            </form>
                        </div>
                                        
                    </div>
                   


                    
                    <!-- Box Body -->

                    <div class="box-body">                    
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" id="datatable">
                                <thead>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">TANGGAL</th>
                                    <th class="text-center">NOMOR PERBAIKAN</th>
                                    <th class="text-center">PEMOHON</th>
                                    <th class="text-center">JENIS</th>
                                    <th class="text-center">DESKRIPSI</th>
                                    <th class="text-center">STATUS</th>
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
                ajax: '{{ route('perbaikan.json') }}',
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'created_at', name: 'created_at', className: "text-center" },
                    { data: 'no_document', name: 'no_document'},
                    { data: 'pemohon', name: 'pemohon'},
                    { data: 'jenis', name: 'jenis'},
                    { data: 'deskripsi', name: 'deskripsi'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });
        });
    </script>

    
@endsection
