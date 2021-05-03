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
        <li class="active"><a href="{{ route('surattugas.edit', $surat->id) }}">Edit Surat Tugas</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Surat Tugas <strong> 07.{{ $surat->nomor_surat }}</strong></h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('surattugas.update', $surat->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">
                            <label for="">Nama Karyawan</label>
                            @php $i = 1 @endphp
                            @foreach($this_pegawais as $peg)
                                <div class="row" id="pegawai{{$i}}">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select name="pegawai_id[]" class="form-control selectpicker" data-live-search="true" required>
                                            <option value="" disabled selected>Pilih Karyawan</option> 
                                            @foreach($pegawais as $pegawai)
                                                <option value="{{ $pegawai->id }}" @if($pegawai->id == $peg->pegawai_id) selected @endif>{{ $pegawai->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-sm-2">
                                        @if($i > 1)
                                            <button type="button" name="pegawai-remove" id="{{$i}}" class="btn btn-danger btn-sm pegawai-remove"><span class="glyphicon glyphicon-minus"></span></button>
                                        @else
                                            <button type="button" name="pegawai_more" id="pegawai_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                        @endif
                                    </div>
                                </div>
                                @php $i++ @endphp
                            @endforeach
                            <div id="dynamic_field"></div>
                            <div class="form-group">
                                <label for="">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" value="{{ $surat->jabatan }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Kegiatan</label>
                                <textarea name="kegiatan" class="form-control" placeholder="Kegiatan" required>{{ $surat->kegiatan }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Polisi</label>
                                <input type="text" name="nomor_polisi" class="form-control" placeholder="Nomor Polisi" value="{{ $surat->nomor_polisi }}">
                            </div>
                            <label for="">Tujuan</label>
                            @php $j = 1 @endphp
                            @foreach($this_tujuans as $tuj)
                                <div class="row" id="tujuan{{$j}}">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select name="tujuan_id[]" class="form-control selectpicker" data-live-search="true" required>
                                            <option value="" disabled selected>Pilih Tujuan</option> 
                                            @foreach($tujuans as $tujuan)
                                                <option value="{{ $tujuan->id }}" @if($tujuan->id == $tuj->tujuan_id) selected @endif>{{ $tujuan->nama_tujuan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-sm-2">
                                        @if($j > 1)
                                            <button type="button" name="tujuan-remove" id="{{$j}}" class="btn btn-danger btn-sm tujuan-remove"><span class="glyphicon glyphicon-minus"></span></button>
                                        @else
                                            <button type="button" name="tujuan_more" id="tujuan_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                        @endif
                                    </div>
                                </div>
                                @php $j++ @endphp
                            @endforeach
                            <div id="dynamic_field2"></div>
                            <div class="form-group">
                                <label for="">Template Tanggal Tugas</label>
                                <select id="opsi_tanggal" name="opsi_tanggal" class="form-control" required>
                                    <option value="" disabled selected>Pilih Template Tanggal</option>
                                    <option value="1" @if($surat->opsi_tanggal == 1)selected @endif>Tanggal s/d Tanggal</option>
                                    <option value="2" @if($surat->opsi_tanggal == 2)selected @endif>Tanggal Dinamis</option>
                                </select>
                            </div>

                            <!-- opsi tanggal  -->
                            <div id="range_date" class="row" @if($surat->opsi_tanggal == 2) style="display:none;" @endif>
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ $surat->tanggal_awal }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ $surat->tanggal_akhir }}">
                                </div>
                            </div>

                            <div id="dynamic_date" @if($surat->opsi_tanggal == 1) style="display:none;" @endif>
                                <label for="">Tanggal Tugas</label>
                                @php $k = 1 @endphp
                                @if(!empty($this_tanggal))
                                @foreach($this_tanggal as $tgl)
                                    <div class="row" id="tanggal{{$k}}">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="date" name="tanggal[]" id="tanggal_dinamis" class="form-control" value="{{ $tgl->tanggal }}">
                                        </div>
                                    </div>
                                        <div class="col-sm-2">
                                            @if($k > 1)
                                                <button type="button" name="tanggal-remove" id="{{$k}}" class="btn btn-danger btn-sm tanggal-remove"><span class="glyphicon glyphicon-minus"></span></button>
                                            @else
                                                <button type="button" name="tanggal_more" id="tanggal_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                            @endif
                                        </div>
                                    </div>
                                    @php $k++ @endphp
                                @endforeach
                                @endif
                                <div id="dynamic_field3">
                                </div>
                            </div>
                            <!-- END Opsi tanggal  -->

                            <div class="form-group">
                                <label for="">Tampilkan kolom tanda tangan Customer?</label>
                                <select name="status_ttd" class="form-control selecpicker" required>
                                    <option value="" disabled selected>Pilih Opsi</option>
                                    <option value="1" @if($surat->status_ttd == 1) selected @endif>Iya</option>
                                    <option value="2" @if($surat->status_ttd == 2) selected @endif>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer pull-left">                              
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
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
    $(document).ready(function () {
        $('.selectpicker').selectpicker();
        var pegawai_jml = {!! $this_pegawais !!}; 
        var count = Object.keys(pegawai_jml).length;
        // console.log(count);
        function add_dynamic_input_field(count){
            var button = '';
            if(count > 1){
                button = '<button type="button" name="pegawai-remove" id="'+count+'" class="btn btn-danger btn-sm pegawai-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name="pegawai_more" id="pegawai_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
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
        var tujuan_jml = {!! $this_tujuans !!}; 
        var count2 = Object.keys(tujuan_jml).length;

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
                        <select name="tujuan_id[]" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" disabled selected>Pilih Tujuan</option> 
                            @foreach($tujuans as $tujuan)
                                <option value="{{ $tujuan->id }}">{{ $tujuan->nama_tujuan }}</option>
                            @endforeach
                        </select>
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
        var tanggal_jml = {!! $this_tanggal !!}
        console.log(tanggal_jml); 
        if(tanggal_jml){
            var count3 = Object.keys(tanggal_jml).length;
        }else{
            var count3 = 1;
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
                        <input type="date" name="tanggal[]" id="tanggal_dinamis" class="form-control">
                    </div>
                </div>
            `;
            output =
            output += '<div class="col-sm-2">'+button+'</div></div>';
            $('#dynamic_field3').append(output);
        }

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
                        <input type="date" name="tanggal[]" id="tanggal_dinamis" class="form-control">
                    </div>
                </div>
            `;
            output =
            output += '<div class="col-sm-2">'+button+'</div></div>';
            $('#dynamic_field3').append(output);
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
            }
        });


    });
</script>
@endsection
