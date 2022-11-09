@extends('layouts.layout')

@section('title')
    SIRUS | Notulen
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Notulen
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Event</a></li>
        <li class="active"><a href="{{ route('event.notulen', $event->id) }}">Notulen</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Notulen <strong>{{ $event->nama_event }}</strong></h3>
                    </div>
                    <form action="{{ route('event.notulen.update', $event->id) }}" method="post">
                    <div class="box-body">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="date" value="{{ $event->tanggal }}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Agenda</label>
                                <input type="text" value="{{ $event->nama_event }}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Divisi</label>
                                <select name="divisi_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Divisi</option>
                                    @foreach($divisis as $divisi)
                                        <option value="{{ $divisi->id }}" @if($divisi->id == $notulen->divisi_id) selected @endif>{{ $divisi->nama_divisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori</label> <br>
                                <div class="checkbox-inline">
                                    <input type="checkbox" name="kategori_1" value="1" @if($notulen->kategori_1 == true) checked @endif>Rutin
                                </div>
                                <div class="checkbox-inline">
                                    <input type="checkbox" name="kategori_2" value="1" @if($notulen->kategori_2 == true) checked @endif>Evaluasi
                                </div>
                                <div class="checkbox-inline">
                                    <input type="checkbox" name="kategori_3" value="1" @if($notulen->kategori_3 == true) checked @endif>Khusus
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <table class="table table-bordered table-hover" width="100%" id="dynamic_field">
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Deskripsi</th>
                                    <th class="text-center" width="20%">Departemen</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Realisasi</th>
                                    <th class="text-center">Notes</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"></th>
                                </tr>
                                @php $i = 1 @endphp
                                @foreach($notulen_detail as $detail)
                                    <tr id="row{{$i}}">
                                        <td class="text-center">{{ $i }}</td>
                                        <td>
                                            <textarea name="deskripsi[]" placeholder="Deskripsi" class="form-control" required>{{ $detail->deskripsi }}</textarea>
                                        </td>
                                        <td>
                                            <select name="dept_id[]" class="form-control selectpicker" data-live-search="true" >
                                                <option value="" disabled selected>Pilih Departemen readonly
                                                @foreach($departemens as $dept)
                                                    <option value="{{ $dept->id }}" @if($dept->id == $detail->dept_id) selected @endif>{{ $dept->nama_departemen }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" name="tgl_target[]" class="form-control" value="{{ $detail->tgl_target }}" required>
                                        </td>
                                        <td>
                                            <textarea name="realisasi[]" placeholder="Realisasi" class="form-control">{{ $detail->realisasi }}</textarea>
                                        </td>
                                        <td>
                                            <textarea name="notes[]" placeholder="Notes" class="form-control">{{ $detail->notes }}</textarea>
                                        </td>
                                        <td>
                                            <select name="status[]" class="form-control" required>
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option value="1" @if($detail->status == 1) selected @endif>Process</option>
                                                <option value="2" @if($detail->status == 2) selected @endif>Done</option>
                                                <option value="3" @if($detail->status == 3) selected @endif>Cancel</option>
                                            </select>
                                        </td>  
                                        <td>
                                            @if($i > 1)
                                                @if($detail->status == 1)
                                                    <button type="button" name="btn-remove" id="{{$i}}" class="btn btn-danger btn-sm btn-remove"><span class="glyphicon glyphicon-minus"></span></button>
                                                @endif
                                            @else
                                                <button type="button" name="add_more" id="add_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $i++ @endphp
                                @endforeach
                            </table>
                        </div>                     
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('event.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>                 
                    </div>
                    </form>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection

@section('js-extra')
<script>
    $(function () {
        $('.selectpicker').selectpicker();
        var detail = {!! $notulen_detail !!}
        var count = Object.keys(detail).length;

        function add_dynamic_input_field(count){
            var button = '';
            if(count > 1){
                button = '<button type="button" name"btn-remove" id="'+count+'" class="btn btn-danger btn-sm btn-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"add_more" id="add_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';            }
            output = '<tr id="row'+count+'">';
            output += `
                <td class="text-center">${count}</td>
                <td>
                    <textarea name="deskripsi[]" placeholder="Deskripsi" class="form-control" required></textarea>
                </td>
                <td>
                    <select name="dept_id[]" class="form-control selectpicker" data-live-search="true" required>
                        <option value="" disabled selected>Pilih Departemen</option>
                        @foreach($departemens as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nama_departemen }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="date" name="tgl_target[]" class="form-control" required>
                </td>
                <td>
                    <textarea name="realisasi[]" placeholder="Realisasi" class="form-control" required></textarea>
                </td>
                <td>
                    <textarea name="notes[]" placeholder="Notes" class="form-control"></textarea>
                </td>
                <td>
                    <select name="status[]" class="form-control">
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="1">Process</option>
                        <option value="2">Done</option>
                        <option value="3">Cancel</option>
                    </select>
                </td>
            `;
            output += '<td>'+button+'</td></tr>';
            $('#dynamic_field').append(output);
            $(".selectpicker").selectpicker('refresh');
        }

        $(document).on('click','#add_more', function(){
            count = count + 1;
            add_dynamic_input_field(count);
        });

        $(document).on('click','.btn-remove', function(){
            var row_id = $(this).attr("id");
            $('#row'+row_id).remove();
        });
    });
</script>
@endsection