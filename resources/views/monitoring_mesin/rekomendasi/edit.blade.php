<?php 
    use App\Models\Monitoring_Mesin\Stock_Mesin;
?>
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
        Rekomendasi Pengiriman Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.rekomendasi.update', $header->id) }}">Update Rekomendasi Pengiriman Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Rekomendasi Pengiriman Mesin </h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('monitoringmesin.rekomendasi.update', $header->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal Approval</label>
                                <input type="date" name="tgl_approval" class="form-control" value="{{ $header->tgl_approval }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Customer</label>
                                    <select name="customer_id" class="form-control selectpicker"  data-live-search="true"required>
                                        <option value="" disabled selected>Pilih Customer</option>
                                        @foreach($customer as $row)
                                            <option value="{{ $row->id }}" @if($row->id == $header->customer_id) selected @endif>{{ $row->nama_rs }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-md-12">
                                <div class="col-sm-2 bg-light-blue">
                                    <label for="">Jenis</label>
                                </div> 
                                <div class="col-sm-10 bg-light-blue">
                                    <label for="">Data Stock</label>
                                </div>
                                <br><br>

                                @php $i = 1 @endphp
                                @foreach($detail as $det)
                                    <div class="row" id="mesin{{$i}}">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select name="jenis_id[]" id="{{ $i }}" class="form-control jenis" required readonly>
                                                    <option value="" disabled selected>Pilih Jenis</option>
                                                    @foreach($jenis as $row)
                                                        <option value="{{ $row->id }}" @if($row->id == $det->jenis_id) @endif>{{ $row->jenis }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <select name="stock_id[]" id="{{ $i }}" class="selectpicker form-control stock{{ $i }}" required readonly>
                                                    <option value="" disabled selected>Pilih Stock</option>
                                                    @php 
                                                        $stock = Stock_Mesin::where(['id' => $det->stock_id])->first();
                                                    @endphp
                                                    @foreach($tipe as $row)
                                                        <option value="{{ $row->id }}" @if($row->id == $stock->tipe_id) selected @endif>{{ $stock->tipe." | ".$stock->nomor }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @if($i > 1)
                                                <button type="button" name="mesin-remove" id="{{$i}}" class="btn btn-danger btn-sm mesin-remove"><span class="glyphicon glyphicon-minus"></span></button>
                                            @else
                                                <button type="button" name="mesin_more" id="mesin_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                            @endif
                                        </div>
                                    </div>
                                    @php $i++ @endphp
                                @endforeach
                                <div id="dynamic_field"></div>             
                            </div>
                        </div>
                        <div class="box-footer">                           
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('monitoringmesin.rekomendasi.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
        var count = {!! $jumlah_detail !!}; 
        
        function add_dynamic_input_field(count){
            var button = '';
            if(count > 1){
                button = '<button type="button" name"mesin-remove" id="'+count+'" class="btn btn-danger btn-sm mesin-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"mesin_more" id="mesin_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
            }
            output = '<div class="row" id="mesin'+count+'">';
            output += `
                <div class="col-md-2">
                    <div class="form-group">
                        <select name="jenis_id[]" id="${count}" class="form-control jenis" required>
                            <option value="" disabled selected>Pilih Jenis</option>
                            @foreach($jenis as $row)
                                <option value="{{ $row->id }}">{{ $row->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <select name="stock_id[]" id="${count}" class="selectpicker form-control stock${count}" required>
                            <option value="" disabled selected>Pilih Jenis Terlebih Dahulu</option> 
                        </select>
                    </div>
                </div>
            `;
            output += '<div class="col-md-2">'+button+'</div></div>';
            $('#dynamic_field').append(output);
            $('.selectpicker').selectpicker('refresh');
        }

        $(document).on('click','#mesin_more', function(){
            count = count + 1;
            add_dynamic_input_field(count);
        });

        $(document).on('click','.mesin-remove', function(){
            var row_id = $(this).attr("id");
            $('#mesin'+row_id).remove();
        });

        $(document).on('change','.jenis', function(){
            var row_id   = $(this).attr("id");
            var jenis_id = $(this).val();
            var kondisi = "";
            var token = $("input[name='_token']").val();            
            var op="";
            console.log('jenis_id='+jenis_id);
            $.ajax({
                url: "{{ route('monitoringmesin.rekomendasi.getStock')}}",
                method: 'POST',
                data: {jenis_id:jenis_id, _token:token},
                success: function(data) {
                    console.log(data);
                    console.log('row ke-'+row_id);

                    var $select = $('<select/>', {
                        'class':"form-control selectpicker stock"+row_id,'name':"stock_id[]",'id':row_id,'data-live-search':"true"
                    });
                    $select.append('<option value="">Pilih Stock</option>');
                    for(var i=0; i<data.length; i++) {
                        if(data[i].kondisi == 1){
                            kondisi = "Baru";
                        }else if(data[i].kondisi == 2){
                            kondisi = "Bekas";
                        }else if(data[i].kondisi == 3){
                            kondisi = "Rekondisi";
                        }
                        $select.append('<option value=' + data[i].id + '>' + data[i].tipe + ' | '+ data[i].nomor + ' | ' + kondisi + ' | ' + ' | ' + data[i].gudang + ' | ' +data[i].customer +'</option>');
                    }
                    $('.stock'+row_id).html("");
                    $select.appendTo('.stock'+row_id).selectpicker('refresh');
                }
            });
        });

    });
</script>
@endsection
