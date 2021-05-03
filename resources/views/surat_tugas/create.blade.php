@extends('layouts.layout')

@section('title')
    SIRUS | Surat Tugas
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Surat Tugas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Surat Tugas</a></li>
        <li class="active"><a href="{{ route('surattugas.create') }}">Tambah Surat Tugas</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Surat Tugas</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('surattugas.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <label for="">Nama Karyawan</label>
                            <div id="dynamic_field"></div>
                            <div class="form-group">
                                <label for="">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" value="{{ old('jabatan') }}" required>
                                <p class="text-danger">{{ $errors->first('jabatan') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Kegiatan</label>
                                <textarea name="kegiatan" class="form-control" placeholder="Kegiatan" required>{{ old('kegiatan') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Polisi</label>
                                <input type="text" name="nomor_polisi" class="form-control" placeholder="Nomor Polisi">
                            </div>
                            <label for="">Tujuan</label>
                            <div id="dynamic_field2"></div>
                            <div class="form-group">
                                <label for="">Template Tanggal Tugas</label>
                                <select id="opsi_tanggal" name="opsi_tanggal" class="form-control" required>
                                    <option value="" disabled selected>Pilih Template Tanggal</option>
                                    <option value="1">Tanggal s/d Tanggal</option>
                                    <option value="2">Tanggal Dinamis</option>
                                </select>
                            </div>

                            <!-- opsi tanggal  -->
                            <div id="range_date" class="row" style="display:none;">
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                                </div>
                            </div>

                            <div id="dynamic_date" style="display:none;">
                                <label for="">Tanggal Tugas</label>
                                <div id="dynamic_field3"></div>
                            </div>
                            <!-- END Opsi tanggal  -->

                            <div class="form-group">
                                <label for="">Tampilkan kolom tanda tangan Customer?</label>
                                <select name="status_ttd" class="form-control selecpicker" required>
                                    <option value="" disabled selected>Pilih Opsi</option>
                                    <option value="1">Iya</option>
                                    <option value="2">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer pull-left">                              
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('surattugas.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
            if(count > 1){
                button = '<button type="button" name"pegawai-remove" id="'+count+'" class="btn btn-danger btn-sm pegawai-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"pegawai_more" id="pegawai_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
            }
            output = '<div class="row" id="pegawai'+count+'">';
            output += `
                <div class="col-sm-8">
                    <div class="form-group">
                        <select name="pegawai_id[]" class="form-control selectpicker {{ $errors->has('pegawai_id[]') ? 'is-invalid':'' }}" data-live-search="true" required>
                            <option value="" disabled selected>Pilih Karyawan</option> 
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                                
                            @endforeach
                        </select>
                        <p class="text-danger">{{ $errors->first('pegawai_id[]') }}</p>
                    </div>
                </div>
            `;
            output += '<div class="col-sm-2">'+button+'</div></div>';
            $('#dynamic_field').append(output);
            $(".selectpicker").selectpicker('refresh');
        }

        $(document).on('click','#pegawai_more', function(){
            count = count + 1;
            add_dynamic_input_field(count);
        });

        $(document).on('click','.pegawai-remove', function(){
            var row_id = $(this).attr("id");
            $('#pegawai'+row_id).remove();
        });

        //TUJUAN
        var count2 = 1; 
        add_dynamic_input_field2(count2);

        function add_dynamic_input_field2(count2){
            var button = '';
            if(count2 > 1){
                button = '<button type="button" name"tujuan-remove" id="'+count2+'" class="btn btn-danger btn-sm tujuan-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"tujuan_more" id="tujuan_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
            }
            output = '<div class="row" id="tujuan'+count2+'">';
            output += `
                <div class="col-sm-8">
                    <div class="form-group">
                        <select name="tujuan_id[]" class="form-control selectpicker {{ $errors->has('tujuan_id[]') ? 'is-invalid':'' }}" data-live-search="true" required>
                            <option value="" disabled selected>Pilih Tujuan</option> 
                            @foreach($tujuans as $tujuan)
                                <option value="{{ $tujuan->id }}">{{ $tujuan->nama_tujuan }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger">{{ $errors->first('tujuan_id[]') }}</p>
                    </div>
                </div>
            `;
            output += '<div class="col-sm-2">'+button+'</div></div>';
            $('#dynamic_field2').append(output);
            $(".selectpicker").selectpicker('refresh');
        }

        $(document).on('click','#tujuan_more', function(){
            count2 = count2 + 1;
            add_dynamic_input_field2(count2);
        });

        $(document).on('click','.tujuan-remove', function(){
            var row_id = $(this).attr("id");
            $('#tujuan'+row_id).remove();
        });

        //Opsi tanggal
        var count3 = 1; 
        add_dynamic_input_field3(count3);

        function add_dynamic_input_field3(count3){
            var button = '';
            if(count3 > 1){
                button = '<button type="button" name"tanggal-remove" id="'+count3+'" class="btn btn-danger btn-sm tanggal-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"tanggal_more" id="tanggal_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
            }
            output = '<div class="row" id="tanggal'+count3+'">';
            output += `
                <div class="col-sm-8">
                    <div class="form-group">
                        <input type="date" name="tanggal[]" id="tanggal_dinamis" class="form-control" required>
                        <p class="text-danger">{{ $errors->first('tanggal[]') }}</p>
                    </div>
                </div>
            `;
            output += '<div class="col-sm-2">'+button+'</div></div>';
            $('#dynamic_field3').append(output);
            $(".selectpicker").selectpicker('refresh');
        }

        $(document).on('click','#tanggal_more', function(){
            count3 = count3 + 1;
            add_dynamic_input_field3(count3);
        });

        $(document).on('click','.tanggal-remove', function(){
            var row_id = $(this).attr("id");
            $('#tanggal'+row_id).remove();
        });
        
        //select opsi_tanggal
        $('#opsi_tanggal').change(function(){
            if ( this.value == '1'){
                $("#range_date").show();
                document.querySelector('#tanggal_awal').required = true;
                document.querySelector('#tanggal_akhir').required = true;
                document.querySelector('#tanggal_dinamis').required = false;
                $("#dynamic_date").hide();  
            }
            else if ( this.value == '2'){
                document.querySelector('#tanggal_awal').required = false;
                document.querySelector('#tanggal_akhir').required = false;
                $("#range_date").hide();
                $("#dynamic_date").show();
                document.querySelector('#tanggal_dinamis').required = true;
            }else {
                $("#range_date").hide();
                $("#dynamic_date").hide();
            }
        });


    });
</script>
@endsection
