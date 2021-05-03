@extends('layouts.layout')

@section('title')
    SIRUS | CAPA
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        CAPA (Corrective Action Preventive Action)
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">CAPA</a></li>
        <li class="active"><a href="{{ route('capa.edit', $model->id) }}">Update CAPA</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update <strong>{{$model->nomor}}</strong></h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('capa.update',$model->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Dari</label><small><i> (Departemen yang menemukan)</i></small>
                                <select name="dari_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departemens as $row)
                                        <option value="{{ $row->id }}" @if($model->dari_id == $row->id) selected @endif>{{ $row->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kepada</label> <small><i>(Departemen temuan)</i></small>
                                <select name="kepada_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departemens as $row)
                                        <option value="{{ $row->id }}" @if($model->kepada_id == $row->id) selected @endif>{{ $row->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi Sumber</label>
                                <select name="lokasi_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Lokasi</option>
                                    @foreach($lokasis as $row)
                                        <option value="{{ $row->id }}" @if($model->lokasi_id == $row->id) selected @endif>{{ $row->lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Terjadi</label>
                                <input type="date" name="tgl_terjadi" class="form-control" value="{{ $model->tgl_terjadi }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="kategori_1" @if($model->kategori_1 == 2) checked @endif>
                                    Management Review
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="kategori_2" @if($model->kategori_2 == 2) checked @endif>
                                    Tindakan Koreksi  
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="kategori_3" @if($model->kategori_3 == 2) checked @endif>
                                    Tindakan Pencegahan
                                </div>
                            </div>

                            <div class="form-group">
								<label for="">Potensi Ketidaksesuaian/Permasalahan</label>
								<textarea name="inti_masalah" class="form-control" placeholder="Potensi Ketidaksesuaian/Permasalahan" required>{{ $model->inti_masalah }}</textarea>
							</div>

							<div class="form-group">
								<label for="">Rincian Permasalahan</label>
								<textarea name="rincian_masalah" class="form-control" placeholder="Rincian Permasalahan" required>{{ $model->rincian_masalah }}</textarea>
							</div>

							<div class="form-group">
								<label for="">Penyebab Permasalahan</label>
								<textarea name="penyebab_masalah" class="form-control" placeholder="Penyebab Permasalahan" required>{{ $model->penyebab_masalah }}</textarea>
							</div>

							<div class="form-group">
								<label for="">Tindakan Koreksi</label>
								<textarea name="koreksi" class="form-control" placeholder="Tindakan Koreksi" required>{{ $model->koreksi }}</textarea>
							</div>

							<div class="form-group">
								<label for="">Tindakan Pencegahan</label>
								<textarea name="pencegahan" class="form-control" placeholder="Tindakan Pencegahan" required>{{ $model->pencegahan }}</textarea>
							</div>

							<div class="form-group">
								<label for="">Target Waktu Penyelesaian</label>
								<input type="date" class="form-control" name="tgl_target" value="{{ $model->tgl_target }}" required>
							</div>

							<div class="form-group">
								<label for="">PIC Penyelesaian</label> 
								<select name="pic_id" class="form-control selectpicker" data-live-search="true" required>
									<option value="" disabled selected>Pilih PIC</option>
									@foreach($karyawans as $row)
										<option value="{{ $row->id }}" @if($model->pic_id == $row->id) selected @endif>{{ $row->name }}</option>
									@endforeach
								</select>
                            </div>

                            <div class="form-group">
								<label for="">Verifikator</label> 
								<select name="verifikator_id" class="form-control selectpicker" data-live-search="true" required>
									<option value="" disabled selected>Pilih Verifikator</option>
									@foreach($karyawans as $row)
										<option value="{{ $row->id }}" @if($model->verifikator_id == $row->id) selected @endif>{{ $row->name }}</option>
									@endforeach
								</select>
                            </div>
                            
                            <div class="form-group">
								<label for="">Tembusan Pertama</label>
								<input name="tembusan_1" class="form-control" value="{{ $model->tembusan_1 }}" placeholder="Tembusan Pertama" required>
                            </div>

                            <div class="form-group">
								<label for="">Tembusan Kedua</label>
								<input name="tembusan_2" class="form-control" value="{{ $model->tembusan_2 }}" placeholder="Tembusan Kedua" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Departemen </label><small><i> (Departemen-departemen terkait)</i></small>
                                <div id="dynamic_field">
                                @if($model->all_dept == 0)
                                    @php $i = 1 @endphp
                                    @foreach($model_dept as $md)
                                        <div class="row" id="row{{$i}}">
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <select id="dept_id" name="dept_id[]" class="form-control selectpicker" data-live-search="true" required>
                                                        <option value="" disabled selected>Pilih Departemen</option>
                                                        @if($i == 1) <option value="ALL" id="all_dept">ALL (Semua Departemen)</option> @endif
                                                        @foreach($departemens as $departemen)
                                                            <option value="{{ $departemen->id }}" @if($departemen->id == $md->dept_id) selected @endif>{{ $departemen->nama_departemen }}</option>
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
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('capa.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
        var md_jml = {!! $model_dept !!}; 
        var jml = Object.keys(md_jml).length;

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