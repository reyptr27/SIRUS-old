@extends('layouts.layout')

@section('title')
    SIRUS | Formulir Unpaid Leave
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Formulir Unpaid Leave
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Formulir HRD</a></li>
        <li class="active"><a href="{{ route('hrd.unpaid.edit', $form->id) }}">Update Formulir Unpaid Leave</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Formulir Unpaid Leave {{ $form->id }}</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('hrd.unpaid.update', $form->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">
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
                                <input type="text" id="cabang" class="form-control" placeholder="Cabang" value="{{ $cab->nama_cabang }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Divisi</label>
                                <input type="text" id="divisi" name="divisi" class="form-control" placeholder="Divisi" value="{{ $form->divisi }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Alasan</label>
                                <input type="text" id="alasan" name="alasan" class="form-control" placeholder="Alasan" value="{{ $form->alasan }}" required>
                            </div>
                            <table width="100%">
                                <tr>
                                    <td><label for="">Tanggal Awal</label></td>
                                    <td></td>
                                    <td><label for="">Tanggal Akhir</label></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="date" name="tanggal_awal" value="{{ $form->tanggal_awal }}" class="form-control" required>
                                    </td>
                                    <td align="center">sampai</td>
                                    <td>
                                        <input type="date" name="tanggal_akhir" value="{{ $form->tanggal_akhir }}" class="form-control" required>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="form-group">
                                <label for="">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" value="{{ $form->tanggal_masuk }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Atasan</label>
                                <select id="atasan_id" name="atasan_id" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="" disabled selected>Pilih Atasan</option>
                                    @foreach($karyawans as $k)
                                        <option value="{{ $k->id }}" @if($k->id == $form->karyawan_id) selected @endif>{{ $k->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('hrd.unpaid.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
</script>
@endsection
