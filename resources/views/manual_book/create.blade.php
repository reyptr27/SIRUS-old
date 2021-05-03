@extends('layouts.layout')

@section('title')
    SIRUS | Manual Book
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manual Book
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('manualbook.index') }}">Manual Book</a></li>
            <li class="active"><a href="{{ route('manualbook.create') }}">Tambah Manual Book</a></li>
        </ol>
    </section>    

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Manual Book</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('manualbook.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Judul</label>
                                <input type="text" name="judul" class="form-control" placeholder="Judul" value="{{ old('judul') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Cover / Sampul</label><br>
                                <img id="cover_preview" src="{{ asset('storage/ManualBook/cover/default.jpg')}}" width="175" height="250" />
                                <input type="file" id="cover_upload" name="cover_image" class="form-control" value="{{ old('cover_image') }}" accept="image/png, image/jpeg, image/gif">
                                
                            </div>
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" placeholder="Deskripsi" value="{{ old('deskripsi') }}" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">File Manual Book</label>
                                <input type="file" name="upload_file" class="form-control" value="{{ old('upload_file') }}" 
                                accept="image/png, image/jpeg, application/pdf, application/msword, application/vnd.ms-powerpoint,application/vnd.ms-excel,
                                        application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation
                                " required>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen </label><small><i> (Departemen-departemen terkait)</i></small>
                                <div id="dynamic_field"></div>
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('manualbook.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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

        $('#cover_upload').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
            {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cover_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            else{
                $('#cover_preview').attr('src', '/storage/ManualBook/cover/default.jpg');
            }
        });
    });
</script>
@endsection