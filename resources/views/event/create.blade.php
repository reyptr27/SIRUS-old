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
        <li class="active"><a href="{{ route('event.create') }}">Tambah Event</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Event</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('event.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Tanggal Event</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Event</label>
                                <input type="text" name="nama_event" class="form-control" placeholder="Nama Event" value="{{ old('nama_event') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Event</label>
                                <select name="jenis_event" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jenis Event</option>
                                    <option value="1">Briefing</option>
                                    <option value="2">Meeting</option>
                                    <option value="3">Training</option>
                                    <option value="4">Lain-lain</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan">{{ old('keterangan') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Lokasi" value="{{ old('lokasi') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <div id="dynamic_field"></div>
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
        var count = 1; 
        add_dynamic_input_field(count);

        function add_dynamic_input_field(count){
            var button = '';
            var opsi_all = '';
            if(count > 1){
                button = '<button type="button" name"btn-remove" id="'+count+'" class="btn btn-danger btn-sm btn-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"add_more" id="add_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
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