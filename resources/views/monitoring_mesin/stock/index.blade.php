@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
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
        Stock Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.stock.index') }}">Stock Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Stock Mesin</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <label for="">Jenis</label>
                                <select name="filter_jenis" id="filter_jenis" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($jenis as $row)
                                        <option value="{{ $row->jenis }}">{{ $row->jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">Tipe</label>
                                <select name="filter_tipe" id="filter_tipe" class="form-control select2">
                                    <option value="">All</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">Kondisi</label>
                                <select name="filter_kondisi" id="filter_kondisi" class="form-control select2">
                                    <option value="">All</option>
                                    <option value="Baru">Baru</option>
                                    <option value="Bekas">Bekas</option>
                                    <option value="Rekondisi">Rekondisi</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Gudang</label>
                                <select name="filter_gudang" id="filter_gudang" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($gudang as $row)
                                        <option value="{{ $row->nama_gudang }}">{{ $row->nama_gudang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Customer</label>
                                <select name="filter_customer" id="filter_customer" class="form-control select2">
                                    <option value="">All</option>
                                    @foreach ($customer as $row)
                                        <option value="{{ $row->nama_rs }}">{{ $row->nama_rs }}</option>
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
                                        <th class="text-center">Tgl Penerimaan</th>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">Tipe</th>
                                        <th class="text-center">Nomor Seri</th>
                                        <th class="text-center">Kondisi</th>
                                        <th class="text-center">Gudang</th>
                                        <th class="text-center">Customer</th>
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
        </div>        
    </section>
</div>
@endsection

@section('js-extra')
    <script>
        $(function() {
            var dtable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url :'{{ route('monitoringmesin.stock.json') }}',
                    data: function (d) {
                        d.filter_jenis = $('#filter_jenis').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    { data: 'id', name: 'id', "visible": false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, className: "text-center"},
                    { data: 'tgl_terima', name: 'tgl_terima'},
                    { data: 'jenis', name: 'jenis'},
                    { data: 'tipe', name: 'tipe'},
                    { data: 'nomor', name: 'nomor'},
                    { data: 'kondisi', name: 'kondisi'},
                    { data: 'gudang', name: 'gudang'},
                    { data: 'customer', name: 'customer'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"},
                ],
                "order": [0, 'DESC']
            });

            $("#filter_jenis").change(function(){
                dtable.draw();
                var jenis = $(this).val();
                var token = $("input[name='_token']").val();
                var op="";
                console.log('jenis='+jenis);
                $.ajax({
                    url: "{{ route('monitoringmesin.stock.getTipe')}}",
                    method: 'POST',
                    data: {jenis:jenis, _token:token},
                    success: function(data) {
                        var div=$(this).parent();
                        op+='<option value="">All</option>';
                        
                            for(var i=0; i<data.length; i++){
                                op+='<option value="'+data[i].tipe+'">'+data[i].tipe+'</option>';
                            };
                                        
                        $('#filter_tipe').html("");
                        $('#filter_tipe').append(op);
                    }
                });
            });

            $("#filter_tipe").change(function(){ 
                var search = $(this).val();
                console.log('tipe='+search);
                dtable.columns(4).search(search).draw();
            });

            $("#filter_kondisi").change(function(){ 
                var search = $(this).val();
                dtable.columns(6).search(search).draw();
            });

            $("#filter_gudang").change(function(){ 
                var search = $(this).val();
                dtable.columns(7).search(search).draw();
            });

            $("#filter_customer").change(function(){ 
                var search = $(this).val();
                dtable.columns(8).search(search).draw();
            });
        });
    </script>
@endsection