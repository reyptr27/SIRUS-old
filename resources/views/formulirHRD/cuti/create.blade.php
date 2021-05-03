@extends('layouts.layout')

@section('title')
    SIRUS | Formulir Cuti
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Formulir Cuti
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Formulir HRD</a></li>
        <li class="active"><a href="{{ route('hrd.cuti.create') }}">Tambah Formulir Cuti</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Formulir Cuti</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('hrd.cuti.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nama Karyawan</label>
                                <select id="karyawan_id" name="karyawan_id" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="" disabled selected>Pilih Karyawan</option>
                                    @foreach($karyawans as $k)
                                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">NIK</label>
                                <input type="text" id="nik" class="form-control" placeholder="NIK" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Jabatan</label>
                                <input type="text" id="jabatan" class="form-control" placeholder="Jabatan" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <input type="text" id="departemen" class="form-control" placeholder="Departemen" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi/Cabang</label>
                                <input type="text" id="cabang" class="form-control" placeholder="Cabang" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Bergabung</label>
                                <input type="date" name="tanggal_bergabung" class="form-control" required>
                            </div>
                            <table width="100%">
                                <tr>
                                    <td><label for="">Tanggal Awal</label></td>
                                    <td></td>
                                    <td><label for="">Tanggal Akhir</label></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="date" name="tanggal_awal" class="form-control" required>
                                    </td>
                                    <td align="center">sampai</td>
                                    <td>
                                        <input type="date" name="tanggal_akhir" class="form-control" required>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="form-group">
                                <label for="">Alasan Mengambil Cuti</label>
                                <input type="text" name="alasan" class="form-control" placeholder="Alasan Mengambil Cuti" required>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Selama Cuti</label>
                                <textarea name="alamat" class="form-control" placeholder="Alamat Selama Cuti" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Status Kendaraan</label>
                                <select name="status_inventaris" class="form-control" required>
                                    <option value="" disabled selected>Pilih Status Kendaraan</option>
                                    <option value="1">Kendaraan perusahaan</option>
                                    <option value="2">Kendaraan pribadi</option>
                                    <option value="3">Tidak mendapatkan inventaris perusahaan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">No. Telp / Handphone</label>
                                <input type="text" name="no_telp" class="form-control" placeholder="Nomor Telepon / Handphone" required>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Cuti</label>
                                <select name="jenis_cuti" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jenis Cuti</option>
                                    <option value="1">Cuti biasa</option>
                                    <option value="2">Pengganti tugas jaga</option>
                                    <option value="3">Cuti khusus</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Pengganti</label>
                                <select name="pengganti_id" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="" disabled selected>Pilih Pengganti</option>
                                    @foreach($karyawans as $k)
                                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Controller</label>
                                <select name="controller_id" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="" disabled selected>Pilih Controller</option>
                                    @foreach($karyawans as $k)
                                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('hrd.cuti.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
