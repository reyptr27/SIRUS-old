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
        <li class="active"><a href="{{ route('capa.create') }}">Tambah CAPA</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah CAPA</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('capa.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Dari</label><small><i> (Departemen yang menemukan)</i></small>
                                <select name="dari_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departemens as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kepada</label> <small><i>(Departemen temuan)</i></small>
                                <select name="kepada_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departemens as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi Sumber</label>
                                <select name="lokasi_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Lokasi</option>
                                    @foreach($lokasis as $row)
                                        <option value="{{ $row->id }}">{{ $row->lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Terjadi</label>
                                <input type="date" name="tgl_terjadi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="kategori_1">
                                    Management Review
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="kategori_2">
                                    Tindakan Koreksi  
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="kategori_3">
                                    Tindakan Pencegahan
                                </div>
                            </div>

                            <div class="form-group">
								<label for="">Potensi Ketidaksesuaian/Permasalahan</label>
								<textarea name="inti_masalah" class="form-control" placeholder="Potensi Ketidaksesuaian/Permasalahan" required></textarea>
							</div>

							<div class="form-group">
								<label for="">Rincian Permasalahan</label>
								<textarea name="rincian_masalah" class="form-control" placeholder="Rincian Permasalahan" required></textarea>
							</div>

							<div class="form-group">
								<label for="">Penyebab Permasalahan</label>
								<textarea name="penyebab_masalah" class="form-control" placeholder="Penyebab Permasalahan" required></textarea>
							</div>

							<div class="form-group">
								<label for="">Tindakan Koreksi</label>
								<textarea name="koreksi" class="form-control" placeholder="Tindakan Koreksi" required></textarea>
							</div>

							<div class="form-group">
								<label for="">Tindakan Pencegahan</label>
								<textarea name="pencegahan" class="form-control" placeholder="Tindakan Pencegahan" required></textarea>
							</div>

							<div class="form-group">
								<label for="">Target Waktu Penyelesaian</label>
								<input type="date" class="form-control" name="tgl_target" required="">
							</div>

							<div class="form-group">
								<label for="">PIC Penyelesaian</label> 
								<select name="pic_id" class="form-control selectpicker" data-live-search="true" required>
									<option value="" disabled selected>Pilih PIC</option>
									@foreach($karyawans as $row)
										<option value="{{ $row->id }}">{{ $row->name }}</option>
									@endforeach
								</select>
                            </div>

                            <div class="form-group">
								<label for="">Verifikator</label> 
								<select name="verifikator_id" class="form-control selectpicker" data-live-search="true" required>
									<option value="" disabled selected>Pilih Verifikator</option>
									@foreach($karyawans as $row)
										<option value="{{ $row->id }}">{{ $row->name }}</option>
									@endforeach
								</select>
                            </div>
                            
                            <div class="form-group">
								<label for="">Tembusan Pertama</label>
								<input name="tembusan_1" class="form-control" value="Direktur" placeholder="Tembusan Pertama" required>
                            </div>

                            <div class="form-group">
								<label for="">Tembusan Kedua</label>
								<input name="tembusan_2" class="form-control" value="Pimpinan" placeholder="Tembusan Kedua" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <small><i>(Departemen-departemen yang terkait dalam CAPA)</i></small>
                                <div id="dynamic_field"></div>
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
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