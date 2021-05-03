@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('css-extra')
    <link rel="stylesheet" href="{{asset('assets/vendors/select2/css/select2.min.css')}}"/>
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
        <li class="active"><a href="{{ route('monitoringmesin.stock.edit', $stock->id) }}">Update Stock Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Stock Mesin</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('monitoringmesin.stock.update', $stock->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal Penerimaan</label>
                                    <input type="date" name="tgl_terima" value="{{ $stock->tgl_terima }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Jenis</label>
                                    <select name="jenis_id" class="form-control jenis" required>
                                        <option value="" disabled selected>Pilih Jenis Mesin</option>
                                        @foreach($jenis as $row)
                                        <option value="{{ $row->id }}" @if($row->id == $stock->jenis_id) selected @endif>{{ $row->jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tipe</label>
                                    <select name="tipe_id" class="form-control tipe" required>
                                        <option value="" disabled selected>Pilih Tipe Mesin</option>
                                        @foreach($tipe as $row)
                                        <option value="{{ $row->id }}" @if($row->id == $stock->tipe_id) selected @endif>{{ $row->tipe }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Nomor Seri</label>
                                    <input type="text" name="nomor_seri" class="form-control" placeholder="Nomor Seri" value="{{ $stock->nomor }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Kondisi</label>
                                    <select name="kondisi" class="form-control" required>
                                        <option value="" disabled selected>Pilih Kondisi</option>
                                        <option value="1" @if($stock->kondisi == 1) selected @endif>Baru</option> 
                                        <option value="2" @if($stock->kondisi == 2) selected @endif>Bekas</option>
                                        <option value="3" @if($stock->kondisi == 3) selected @endif>Rekondisi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Gudang Penerima</label>
                                    <select name="gudang_id" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Gudang</option>
                                        @foreach($gudang as $row)
                                        <option value="{{ $row->id }}" @if($row->id == $stock->gudang_id) selected @endif>{{ $row->nama_gudang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Customer</label>
                                    <select name="customer_id" class="form-control selectpicker"  data-live-search="true"required>
                                        <option value="" disabled selected>Pilih Customer</option>
                                        @foreach($customer as $row)
                                            <option value="{{ $row->id }}" @if($row->id == $stock->customer_id) selected @endif>{{ $row->nama_rs }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">                           
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('monitoringmesin.stock.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection

@section('js-extra')
<script>
    $(document).ready(function () {
        $('.jenis').change(function(){
            var jenis_id = $(this).val();
            var token = $("input[name='_token']").val();            
            var op="";
            console.log('jenis_id='+jenis_id);
            $.ajax({
                url: "{{ route('monitoringmesin.penerimaan.getTipe')}}",
                method: 'POST',
                data: {jenis_id:jenis_id, _token:token},
                success: function(data) {
                    console.log(data);
                    var div=$(this).parent();
                    op+='<option value="" disabled selected>Pilih Tipe Mesin</option>';
                    
                        for(var i=0; i<data.length; i++){
                            op+='<option value="'+data[i].id+'">'+data[i].tipe+'</option>';
                        };
                                    
                    $('.tipe').html("");
                    $('.tipe').append(op);
                }
            });
        });

    });
</script>
@endsection
