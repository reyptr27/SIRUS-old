@extends('layouts.layout')

@section('title')
    SIRUS | Event
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
        <li><a href="#">Event</a></li>
        <li class="active"><a href="{{ route('event.edit', $event->id) }}">Update Event</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Event <strong>{{ $event->nama_event }}</strong></h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('event.update', $event->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Tanggal Event</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ $event->tanggal }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Event</label>
                                <input type="text" name="nama_event" class="form-control" placeholder="Nama Event" value="{{ $event->nama_event }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Event</label>
                                <select name="jenis_event" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jenis Event</option>
                                    <option value="1" @if($event->jenis_event == 1) selected @endif>Briefing</option>
                                    <option value="2" @if($event->jenis_event == 2) selected @endif>Meeting</option>
                                    <option value="3" @if($event->jenis_event == 3) selected @endif>Training</option>
                                    <option value="4" @if($event->jenis_event == 4) selected @endif>Lain-lain</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan">{{ $event->keterangan }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Lokasi" value="{{ $event->lokasi }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <div id="dynamic_field">
                                @if($event->all_dept == 0)
                                    @php $i = 1 @endphp
                                    @foreach($event_dept as $ed)
                                        <div class="row" id="row{{$i}}">
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <select id="dept_id" name="dept_id[]" class="form-control selectpicker" data-live-search="true" required>
                                                        <option value="" disabled selected>Pilih Departemen</option>
                                                        @if($i == 1) <option value="ALL" id="all_dept">ALL (Semua Departemen)</option> @endif
                                                        @foreach($departemens as $departemen)
                                                            <option value="{{ $departemen->id }}" @if($departemen->id == $ed->dept_id) selected @endif>{{ $departemen->nama_departemen }}</option>
                                                        @endforeach
                                                    </select>                
                                                </div>
                                            </div>
                                            <div class="col-sm-2" id="dept-btn">
                                                @if($i > 1)
                                                    <button type="button" name="btn-remove" id="{{$i}}" class="btn btn-danger btn-sm btn-remove"><span class="glyphicon glyphicon-minus"></span></button>
                                                @else
                                                    <button type="button" name="add_more" id="add_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                                @endif
                                            </div>
                                        </div>
                                        @php $i++ @endphp
                                    @endforeach
                                @else
                                    <div class="row" id="row1">
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <select id="dept_id" name="dept_id[]" class="form-control selectpicker" data-live-search="true" required>
                                                    <option value="" disabled selected>Pilih Departemen</option>
                                                    <option value="ALL" id="all_dept" selected>ALL (Semua Departemen)</option>
                                                    @foreach($departemens as $departemen)
                                                        <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                                                    @endforeach
                                                </select>                
                                            </div>
                                        </div>
                                        <div class="col-sm-2" id="dept-btn" style="display:none;">
                                            <button type="button" name="add_more" id="add_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                        </div>
                                    </div>
                                @endif
                                </div> 
                                <!-- END Dynamic Field  -->
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('event.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
    $(function () {
        $('.selectpicker').selectpicker();
        var ed_jml = {!! $event_dept !!}; 
        var jml = Object.keys(ed_jml).length;

        if(jml > 0){
            var count = jml;
            console.log(count);
        }else{
            var count = 1;
            console.log(count);
        }

        function add_dynamic_input_field(count){
            var button = '';
            var opsi_all = '';
            if(count > 1){
                button = '<button type="button" name="btn-remove" id="'+count+'" class="btn btn-danger btn-sm btn-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
                opsi_all = '<option value="ALL" id="all_dept">ALL (Semua Departemen)</option>';
            }
            output = '<div class="row" id="row'+count+'">';
            output += `
                <div class="col-sm-10">
                    <div class="form-group">
                        <select id="dept_id" name="dept_id[]" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" disabled selected>Pilih Departemen</option>
                            ${opsi_all}
                            @foreach($departemens as $departemen)
                                <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            `;
            output += '<div class="col-sm-2" id="dept-btn">'+button+'</div></div>';
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

        $('#dept_id').change(function(){
            if(this.value == "ALL"){
                $('#dept-btn').hide();
                $('#dynamic_field > div:gt(0)').remove(); 
            }else{
                $('#dept-btn').show();
            }
        });
    });
</script>
@endsection