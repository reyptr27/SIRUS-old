@extends('layouts.layout')

@section('title')
    SIRUS | Formulir Cuti
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Formulir Cuti
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Formulir HRD</a></li>
        <li><a href="{{ route('hrd.cuti.index') }}">Formulir Cuti</a></li>
        <li class="active"><a href="{{ route('hrd.cuti.serahterima', $form->id) }}">Serah Terima Pekerjaan</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Formulir Serah Terima Pekerjaan <strong>{{ $form->id }}</strong></h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('hrd.cuti.serahterimastore', $form->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            @php $i = 1 @endphp
                            @if(!empty($cuti_detail))
                                @foreach($cuti_detail as $det)
                                    <div class="row" id="row{{$i}}">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Deskripsi Pekerjaan</label>
                                                <input type="text" name="deskripsi[]" class="form-control" placeholder="Deskripsi Pekerjaan" value="{{ $det->deskripsi }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Nama Pengganti</label>
                                                <select name="pengganti_id[]" class="form-control selectpicker" data-live-search="true" required>
                                                    <option value="" disabled selected>Pilih Pengganti</option>
                                                    @foreach($karyawans as $k)
                                                        <option value="{{ $k->id }}" @if($k->id == $det->pengganti_id) selected @endif>{{ $k->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Nama Controller</label>
                                                <select name="controller_id[]" class="form-control selectpicker" data-live-search="true" required>
                                                    <option value="" disabled selected>Pilih Controller</option>
                                                    @foreach($karyawans as $k)
                                                        <option value="{{ $k->id }}" @if($k->id == $det->controller_id) selected @endif>{{ $k->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Keterangan</label>
                                                <input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" value="{{ $det->keterangan }}">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            @if($i > 1)
                                                <button type="button" name="button-remove" id="{{$i}}" class="btn btn-danger btn-sm button-remove" style="margin-top:25px;"><span class="glyphicon glyphicon-minus"></span></button>
                                            @else
                                                <button type="button" name="add_more" id="add_more" class="btn btn-success btn-sm" style="margin-top:25px;"><span class="glyphicon glyphicon-plus"></span></button>
                                            @endif
                                        </div>
                                    </div>
                                    @php $i++ @endphp
                                @endforeach
                            @endif
                            <div id="dynamic_field">
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('hrd.cuti.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.selectpicker').selectpicker();
        var detail = {!! $cuti_detail !!}
        var jml = Object.keys(detail).length;
        if(jml>0){
            var count = jml;
        }else{
            var count = 1;
            var button = '';
            if(count > 1){
                button = '<button type="button" name"button-remove" id="'+count+'" class="btn btn-danger btn-sm button-remove" style="margin-top:25px;"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"add_more" id="add_more" class="btn btn-success btn-sm" style="margin-top:25px;"><span class="glyphicon glyphicon-plus"></span></button>';
            }
            output = '<div class="row" id="row'+count+'">';
            output += `
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Deskripsi Pekerjaan</label>
                        <input type="text" name="deskripsi[]" class="form-control" placeholder="Deskripsi Pekerjaan" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Nama Pengganti</label>
                        <select name="pengganti_id[]" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" disabled selected>Pilih Pengganti</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Nama Controller</label>
                        <select name="controller_id[]" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" disabled selected>Pilih Controller</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan">
                    </div>
                </div>
            `;
            output =
            output += '<div class="col-md-1">'+button+'</div></div>';
            $('#dynamic_field').append(output);
            $(".selectpicker").selectpicker('refresh');
        }

        function add_dynamic_input_field(count){
            var button = '';
            if(count > 1){
                button = '<button type="button" name"button-remove" id="'+count+'" class="btn btn-danger btn-sm button-remove" style="margin-top:25px;"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"add_more" id="add_more" class="btn btn-success btn-sm" style="margin-top:25px;"><span class="glyphicon glyphicon-plus"></span></button>';
            }
            output = '<div class="row" id="row'+count+'">';
            output += `
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Deskripsi Pekerjaan</label>
                        <input type="text" name="deskripsi[]" class="form-control" placeholder="Deskripsi Pekerjaan" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Nama Pengganti</label>
                        <select name="pengganti_id[]" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" disabled selected>Pilih Pengganti</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Nama Controller</label>
                        <select name="controller_id[]" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" disabled selected>Pilih Controller</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan">
                    </div>
                </div>
            `;
            output =
            output += '<div class="col-md-1">'+button+'</div></div>';
            $('#dynamic_field').append(output);
            $(".selectpicker").selectpicker('refresh');
        }

        $(document).on('click','#add_more', function(){
            count = count + 1;
            if(count < 11){
                add_dynamic_input_field(count);
            }
        });

        $(document).on('click','.button-remove', function(){
            var row_id = $(this).attr("id");
            $('#row'+row_id).remove();
        });
    });
</script>
@endsection
