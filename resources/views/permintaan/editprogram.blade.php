@extends('layouts.layout')

@section('title')
    SIRUS | Edit Pengajuan Program
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Edit Pengajuan Program Aplikasi
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Permintaan</a></li>
        <li><a href="{{ route('program.index') }}">Program</a></li>
        <li class="active"><a href="">Edit Pengajuan Program</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Mengedit Pengajuan Program Aplikasi</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('program.update', $program->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                            
                            <div class="col-md-6">
                                
                                <div class="col-sm-4">
                                    <label for="">Nama</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="pemohon_id" id="pemohon_id" 
                                    class="form-control {{ $errors->has('pemohon_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" >
                                        <option value="" disabled>Pilih Pemohon</option>
                                        @foreach ($pemohons as $pemohon)
                                        <option 
                                        @if ($pemohon->id == $program->pemohon_id ) selected @endif
                                        value="{{ $pemohon->id }}">{{ $pemohon->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>                                    
                                </div>
                              
                                <div class="col-sm-4">
                                    <label for="">NIK</label>
                                </div>
                                <div class="col-sm-8">
                                    @foreach($pemohons as $pemohon)
                                        @if ($pemohon->id == $program->pemohon_id)
                                            <input type="text" name="nik" id="nik" 
                                            value=" {{$pemohon->nik}} " 
                                            class="form-control">
                                        @endif                                                                                
                                    @endforeach                                   
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Jabatan</label>
                                </div>
                                <div class="col-sm-8">
                                    @foreach($pemohons as $pemohon)
                                        @if ($pemohon->id == $program->pemohon_id)
                                            <input type="text" name="jabatan" id="jabatan" 
                                            value=" {{$pemohon->jabatan}} " 
                                            class="form-control">
                                        @endif                                                                                
                                    @endforeach
                                    <p class="text-danger"></p>
                                </div>  

                                <div class="col-sm-4">
                                    <label for="">Email</label>
                                </div>
                                <div class="col-sm-8">
                                @foreach($pemohons as $pemohon)
                                        @if ($pemohon->id == $program->pemohon_id)
                                            <input type="email" name="email" id="email" 
                                            value=" {{$pemohon->email}} " 
                                            class="form-control">
                                        @endif                                                                                
                                    @endforeach
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                </div>   
                                <div class="col-sm-4">
                                    <label for="">Departemen</label>
                                </div>
                                <div class="col-sm-8">
                                    @foreach($pemohons as $pemohon)
                                        @if ($pemohon->id == $program->pemohon_id)
                                            <input type="text" name="departemen" id="departemen" 
                                            value=" {{$pemohon->dept->nama_departemen}} " 
                                            class="form-control">
                                        @endif                                                                                
                                    @endforeach
                                    <p class="text-danger"></p>
                                </div>               
                             
                                <div class="col-sm-4">
                                    <label for="">Cabang</label>
                                </div>
                                <div class="col-sm-8">
                                    @foreach($pemohons as $pemohon)
                                        @if ($pemohon->id == $program->pemohon_id)
                                            <input type="text" name="cabang" id="cabang" 
                                            value=" {{$pemohon->cabang->nama_cabang}} " 
                                            class="form-control">
                                        @endif                                                                                
                                    @endforeach
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Kadiv / Kadept </label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="kadept_id" id="kadept_id" 
                                    class="form-control {{ $errors->has('pemohon_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" >
                                        <option value="" disabled>Pilih Kadiv / Kadept</option>
                                        @foreach ($pemohons as $pemohon)
                                        <option 
                                        @if ($pemohon->id == $program->kadept_id ) selected @endif
                                        value="{{ $pemohon->id }}">{{ $pemohon->name }}</option>
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
                                    <select id="jenis" name="jenis" 
                                    class="jenis form-control 
                                    selectpicker" data-live-search="true">
                                        <option value="" disabled="true">Pilih Jenis Pengajuan</option>
                                        <option value="1"@if($program->kode == '1') selected @endif>Pengembangan Aplikasi</option>
                                        <option value="2"@if($program->kode == '2') selected @endif>Pembuatan Aplikasi Baru</option>
                                    </select>
                                    <p class="text-danger"></p>   
                                </div>                                


                                <div class="col-sm-12"><label for="">Deskripsi Program Aplikasi :</label></div>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="program" 
                                    id="program" cols="60" rows="3" required>{{ $program->program }}</textarea>
                                </div>
                                <div class="col-sm-12">
                                <label for="">Alasan Permohonan (isi dengan jelas) :</label></div>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="alasan" id="alasan" 
                                    cols="60" rows="3">{{ $program->alasan }}</textarea>
                                </div>                                 
                                                                                                                 
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
        $("select[name='jenis']").change(function(){
            var jenis = $(this).val();
            var token = $("input[name='_token']").val();            
            var op=" ";
            console.log(jenis);
            $.ajax({
                url: "{{ route('pengadaan.selectjenis')}}",
                method: 'POST',
                data: {jenis:jenis, _token:token},
                success: function(data) {
                    var div=$(this).parent();

                    op+='<option value=" " selected disabled> -- Pilih Spesifikasi --</option>';
                    if(data!=null){
                    for(var i=0; i<data.length; i++){
                        op+='<option value="'+data[i].id+'">'+data[i].spesifikasi+'</option>';
                    };
                    }                 
                    $('#jenis_id').html(" ");
                    $('#jenis_id').append(op);
                }
            });

        });

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
