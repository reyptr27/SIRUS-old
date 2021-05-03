@extends('layouts.layout')

@section('title')
    SIRUS | Create Permintaan Program Aplikasi
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Create Permintaan Program Aplikasi
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Permintaan</a></li>
        <li><a href="{{ route('program.index') }}">Program</a></li>
        <li class="active"><a href="{{ route('program.create') }}">Add Program Aplikasi</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Menambahkan Permintaan Program Aplikasi</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('program.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            
                            <div class="col-md-6">
                                
                                <div class="col-sm-4">
                                    <label for="">Nama</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="pemohon_id" id="pemohon_id" 
                                    class="form-control {{ $errors->has('pemohon_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" >
                                        <option value="" disabled selected>Pilih Pemohon</option>
                                        @foreach ($pemohons as $pemohon)
                                        <option value="{{ $pemohon->id }}">{{ $pemohon->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>                               

                                <div class="col-sm-4">
                                    <label for="">NIK</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="nik" id="nik" class="form-control" placeholder="NIK">
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Jabatan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Jabatan">
                                    <p class="text-danger"></p>
                                </div>  

                                <div class="col-sm-4">
                                    <label for="">Email</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" placeholder="Email">
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                </div>   
                                <div class="col-sm-4">
                                    <label for="">Departemen</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="departemen" id="departemen"  class="form-control" placeholder="Departemen">
                                    <p class="text-danger"></p>
                                </div>               
                             
                                <div class="col-sm-4">
                                    <label for="">Cabang</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="cabang" id="cabang"  
                                    class="form-control" placeholder="Cabang">
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Kadiv / Kadept </label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="kadept_id" id="kadept_id" 
                                    class="form-control {{ $errors->has('kadept_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" >
                                        <option value="" disabled selected>Pilih Kadiv / Kadept</option>
                                        @foreach ($pemohons as $pemohon)
                                        <option value="{{ $pemohon->id }}">{{ $pemohon->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>  

                                   
                                                                                   
                            </div>

                            <div class="col-md-6">
                                <div class="col-sm-4">
                                    <label for="">Jenis Pengajuan : </label>
                                </div>
                                <div class="col-sm-8">
                                <select id="jenis"  name="jenis"
                                    class="jenis form-control 
                                    selectpicker" data-live-search="true">
                                        <option value="" disabled="true" selected>Pilih Jenis Pengajuan</option>
                                        <option value="1">Pengembangan Aplikasi</option>
                                        <option value="2">Pembuatan Aplikasi Baru</option>                                        
                                    </select>
                                    <p class="text-danger"></p>   
                                </div> 

                                <div class="col-sm-12"><label for="">Deskripsi Program Aplikasi :</label></div>
                                <div class="col-sm-12"><textarea class="form-control" name="program" id="program" cols="60" rows="3" required></textarea></div>
                                <div class="col-sm-12"><label for="">Alasan Permohonan (isi dengan jelas) :</label></div>
                                <div class="col-sm-12"><textarea class="form-control" name="alasan" id="alasan" cols="60" rows="3" required></textarea></div>                                 
                                                                                                                 
                            </div>
                            
                            <div class="col-md-12">
                            <br>
                                <div class="col-sm-5"></div>
                                
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"> SUBMIT</i>  
                                    </button>
                                    <a href="{{ route('program.index') }}" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>  BATAL
                                    </a>
                                </div>

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

        $("select[name='pemohon_id']").change(function(){
            var pemohon = $(this).val();
            var token = $("input[name='_token']").val();            
            
            console.log(pemohon);
            $.ajax({
                url: "{{ route('pengadaan.selectpemohon')}}",
                method: 'POST',
                data: {pemohon:pemohon, _token:token},
                success: function(data) {
                    console.log(data.nik);
                    $('#nik').val(" ");
                    $('#nik').val(data.nik);
                    $('#jabatan').val(" ");
                    $('#jabatan').val(data.jabatan);
                    $('#email').val(" ");
                    $('#email').val(data.email);
                    $('#departemen').val(" ");
                    $('#departemen').val(data.nama_departemen);
                    $('#cabang').val(" ");
                    $('#cabang').val(data.nama_cabang);
                  
                 
                    // $('#jenis_id').html(" ");
                    // $('#jenis_id').append(op);               

                }

            });

        });        

    </script>


@endsection
