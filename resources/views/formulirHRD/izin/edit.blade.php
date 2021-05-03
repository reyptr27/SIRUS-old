@extends('layouts.layout')

@section('title')
    SIRUS | Formulir Izin
@endsection

@section('css-extra')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/clockpicker/bootstrap-clockpicker.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Formulir Izin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Formulir HRD</a></li>
        <li class="active"><a href="{{ route('hrd.izin.edit', $form->id) }}">Update Formulir Izin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Formulir Izin</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('hrd.izin.update', $form->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Karyawan</label>
                                        <select id="karyawan_id" name="karyawan_id" class="form-control selectpicker" data-live-search="true" required>
                                            <option value="" disabled selected>Pilih Karyawan</option>
                                            @foreach($karyawans as $k)
                                                <option value="{{ $k->id }}" @if($k->id == $form->karyawan_id) selected @endif>{{ $k->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <?php 
                                        use App\User; use App\Models\Departemen; use App\Models\Cabang;
                                        $user = User::where('id','=',$form->karyawan_id)->first();
                                        $dept = Departemen::where('id','=',$user->dept_id)->first();
                                        $cab = Cabang::where('id','=',$user->cabang_id)->first();
                                    ?>
                                    <div class="form-group">
                                        <label for="">NIK</label>
                                        <input type="text" id="nik" class="form-control" placeholder="NIK" value="{{ $user->nik }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jabatan</label>
                                        <input type="text" id="jabatan" class="form-control" placeholder="Jabatan" value="{{ $user->jabatan }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Departemen</label>
                                        <input type="text" id="departemen" class="form-control" placeholder="Departemen" value="{{ $dept->nama_departemen }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Lokasi/Cabang</label>
                                        <input type="text" id="cabang" class="form-control" placeholder="Cabang" value="{{ $cab->nama_cabang }}"disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal Izin</label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ $form->tanggal }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Keperluan</label>
                                        <select id="keperluan" name="keperluan" class="form-control selectpicker" required>
                                            <option value="" disabled selected>Pilih Keperluan</option>
                                            <option value="1" @if($form->keperluan == 1) selected @endif>Keluar kantor urusan pekerjaan</option>
                                            <option value="2" @if($form->keperluan == 2) selected @endif>Keluar kantor urusan pribadi</option>
                                            <option value="3" @if($form->keperluan == 3) selected @endif>Lambat datang</option>
                                            <option value="4" @if($form->keperluan == 4) selected @endif>Pulang awal</option>
                                        </select>
                                    </div>
                                    <table width="100%">
                                    <tr>
                                        <td><label for="">Jam Keluar</label></td>
                                        <td></td>
                                        <td><label for="">Jam Masuk</label></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group clockpicker">
                                                <input type="text" class="form-control" value="{{ $form->jam_keluar ? date('H:i', strtotime($form->jam_keluar)) : '00:00' }}" name="jam_keluar" id="jam_keluar" @if($form->keperluan == 3) disabled @endif>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td>
                                            <div class="input-group clockpicker">
                                                <input type="text" class="form-control" value="{{ $form->jam_masuk ? date('H:i', strtotime($form->jam_masuk)) : '00:00' }}" name="jam_masuk" id="jam_masuk" @if($form->keperluan == 4) disabled @endif>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    </table>
                                    <br>
                                    <div class="form-group">
                                        <label for="">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" value="{{ $form->keterangan }}" @if($form->keperluan == 1) disabled @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <br>
                                    <center><label class="label label-success" style="font-size:15px;">Wajib Diisi Jika Keluar Kantor Urusan Pekerjaan</label></center>
                                    <br>
                                    <div class="form-group" style="margin-top:14px;">
                                        <label for="">Nama Tujuan (Customer / RS / Lainnya)</label>
                                        <input type="text" name="nama_tujuan" id="nama_tujuan" class="form-control" @if($form->keperluan == 1) value="{{ $form->nama_tujuan }}" @else placeholder="Nama Tujuan" @endif @if($form->keperluan != 1) disabled @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Bertemu dengan (Nama)</label>
                                        <input type="text" name="up_tujuan" id="up_tujuan" class="form-control" @if($form->keperluan == 1) value="{{ $form->up_tujuan }}" @else placeholder="Bertemu Dengan" @endif @if($form->keperluan != 1) disabled @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tujuan Kunjungan</label>
                                        <textarea name="tujuan_kunjungan" id="tujuan_kunjungan" rows="4" class="form-control" @if($form->keperluan != 1) placeholder="Tujuan Kunjungan" disabled @endif>@if($form->keperluan == 1) {{ $form->tujuan_kunjungan }} @endif</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Informasi Lainnya</label>
                                        <textarea name="informasi_tambahan" id="informasi_tambahan" rows="4" class="form-control" @if($form->keperluan != 1) placeholder="Informasi Lainnya yang Bisa Disampaikan" disabled @endif>@if($form->keperluan == 1) {{ $form->informasi_tambahan }} @endif</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('hrd.izin.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
<script type="text/javascript" src="{{ asset('assets/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
<script type="text/javascript">
    $('.clockpicker').clockpicker({
        placement: 'top',
        align: 'left',
        donetext: 'Done'
    });

    $(function () {
        $("#karyawan_id").change(function(){
            var karyawan = $(this).val();
            var token = $("input[name='_token']").val();            
            
            console.log(karyawan);
            $.ajax({
                url: "{{ route('hrd.izin.getKaryawan')}}",
                method: 'POST',
                data: {karyawan:karyawan, _token:token},
                success: function(data) {
                    console.log(data.nik);
                    $('#nik').val('');
                    $('#nik').val(data.nik);
                    $('#jabatan').val('');
                    $('#jabatan').val(data.jabatan);
                    $('#departemen').val('');
                    $('#departemen').val(data.nama_departemen);
                    $('#cabang').val('');
                    $('#cabang').val(data.nama_cabang);
                }
            });
        }); 
    });

    //select opsi keperluan
    $('#keperluan').change(function(){
            if ( this.value == '1'){
                document.querySelector('#keterangan').disabled = true;
                document.querySelector('#nama_tujuan').disabled = false;
                document.querySelector('#up_tujuan').disabled = false;
                document.querySelector('#tujuan_kunjungan').disabled = false;
                document.querySelector('#informasi_tambahan').disabled = false;
                document.querySelector('#jam_masuk').disabled = false;
                document.querySelector('#jam_keluar').disabled = false;
                //required
                document.querySelector('#nama_tujuan').required = true;
                document.querySelector('#up_tujuan').required = true;
                document.querySelector('#tujuan_kunjungan').required = true;
                document.querySelector('#keterangan').required = false;
                document.querySelector('#jam_masuk').required = true;
                document.querySelector('#jam_keluar').required = true;
            }else if ( this.value == '2'){
                document.querySelector('#keterangan').disabled = false;
                document.querySelector('#nama_tujuan').disabled = true;
                document.querySelector('#up_tujuan').disabled = true;
                document.querySelector('#tujuan_kunjungan').disabled = true;
                document.querySelector('#informasi_tambahan').disabled = true;
                document.querySelector('#jam_masuk').disabled = false;
                document.querySelector('#jam_keluar').disabled = false; 
                //required
                document.querySelector('#nama_tujuan').required = false;
                document.querySelector('#up_tujuan').required = false;
                document.querySelector('#tujuan_kunjungan').required = false;
                document.querySelector('#keterangan').required = true;
                document.querySelector('#jam_masuk').required = true;
                document.querySelector('#jam_keluar').required = true;
            }else if ( this.value == '3'){
                document.querySelector('#keterangan').disabled = false;
                document.querySelector('#nama_tujuan').disabled = true;
                document.querySelector('#up_tujuan').disabled = true;
                document.querySelector('#tujuan_kunjungan').disabled = true;
                document.querySelector('#informasi_tambahan').disabled = true;
                document.querySelector('#jam_masuk').disabled = false;
                document.querySelector('#jam_keluar').disabled = true; 
                //required
                document.querySelector('#nama_tujuan').required = false;
                document.querySelector('#up_tujuan').required = false;
                document.querySelector('#tujuan_kunjungan').required = false;
                document.querySelector('#keterangan').required = true;
                document.querySelector('#jam_masuk').required = true;
                document.querySelector('#jam_keluar').required = false;
            }else if ( this.value == '4'){
                document.querySelector('#keterangan').disabled = false;
                document.querySelector('#nama_tujuan').disabled = true;
                document.querySelector('#up_tujuan').disabled = true;
                document.querySelector('#tujuan_kunjungan').disabled = true;
                document.querySelector('#informasi_tambahan').disabled = true;
                document.querySelector('#jam_masuk').disabled = true;
                document.querySelector('#jam_keluar').disabled = false;
                //required
                document.querySelector('#nama_tujuan').required = false;
                document.querySelector('#up_tujuan').required = false;
                document.querySelector('#tujuan_kunjungan').required = false;
                document.querySelector('#keterangan').required = true;
                document.querySelector('#jam_masuk').required = false;
                document.querySelector('#jam_keluar').required = true;
            }else {
                document.querySelector('#keterangan').disabled = true;
                document.querySelector('#nama_tujuan').disabled = true;
                document.querySelector('#up_tujuan').disabled = true;
                document.querySelector('#tujuan_kunjungan').disabled = true;
                document.querySelector('#informasi_tambahan').disabled = true;
                document.querySelector('#jam_masuk').disabled = true;
                document.querySelector('#jam_keluar').disabled = true;
                //required
                document.querySelector('#nama_tujuan').required = false;
                document.querySelector('#up_tujuan').required = false;
                document.querySelector('#tujuan_kunjungan').required = false;
                document.querySelector('#keterangan').required = false;
                document.querySelector('#jam_masuk').required = false;
                document.querySelector('#jam_keluar').required = false;
            }
        });
</script>
@endsection
