@extends('layouts.layout')

@section('title')
    SIRUS | Create Perbaikan
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Create Perbaikan
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Permintaan</a></li>
        <li><a href="{{ route('perbaikan.index') }}">Perbaikan</a></li>
        <li class="active"><a href="{{ route('perbaikan.create') }}">Add Perbaikan</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Menambahkan Perbaikan</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('perbaikan.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            
                            <div class="col-md-6">
                                
                                <div class="col-sm-4">
                                    <label for="">Nama</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="pemohon_id" id="pemohon_id" 
                                    class="form-control {{ $errors->has('pemohon_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" 
                                     onchange="showPemohon(this.value)" required>
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
                                    <input type="text" name="nik" id="nik" class="form-control" 
                                    placeholder="NIK" disabled>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Jabatan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control jabatan" 
                                    placeholder="Jabatan" disabled>
                                    <p class="text-danger"></p>
                                </div>  

                                <div class="col-sm-4">
                                    <label for="">Email</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="email" name="email" id="email" 
                                    class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" 
                                    placeholder="Email" disabled>
                                    <p class="text-danger"></p>
                                </div>   
                                <div class="col-sm-4">
                                    <label for="">Departemen</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="departemen" id="departemen"  class="form-control"
                                     placeholder="Departemen" disabled>
                                    <p class="text-danger"></p>
                                </div>               
                             
                                <div class="col-sm-4">
                                    <label for="">Cabang</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="cabang" id="cabang" class="form-control"
                                     placeholder="Cabang" disabled>
                                    <p class="text-danger"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="col-sm-4">
                                    <label for="">Jenis Pengajuan </label>
                                </div>
                                <div class="col-sm-8">
                                    <select id="jenis"  name="jenis"
                                    class="jenis form-control 
                                    selectpicker" data-live-search="true" required>
                                        <option value="" disabled="true" selected>Pilih Jenis Pengajuan</option>
                                        <option value="Hardware">Hardware</option>
                                        <option value="Software">Software</option>
                                        <option value="Consumables">Consumables</option>
                                        <option value="Service">Service</option>
                                        <option value="Email">Email</option>
                                    </select>
                                    <p class="text-danger"></p> 
                                    <br>  
                                </div>
                                

                                <div class="col-sm-4">
                                    <label for="">Spesifikasi :</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="jenis_id" id="jenis_id" method="POST"
                                    class=" form-control" data-live-search="true" required>
                                        <option value="">[Pilih Spesifikasi]</option>

                                                                                  
                                    </select>                                    
                                    
                                    <p class="text-danger"></p>
                                </div>   

                                <div class="col-sm-12"><label for="">Deskripsi :</label></div>
                                <div class="col-sm-12"><textarea class="form-control" name="deskripsi" 
                                id="deskripsi" cols="60" rows="3" required></textarea></div>
                                <div class="col-sm-12"><label for="">Akibat Kerusakan  :</label></div>
                                <div class="col-sm-12"><textarea class="form-control" name="akibat" 
                                id="akibat" cols="60" rows="3" required></textarea></div>                                 
                                                                                                                 
                            </div>
                            
                            
                            
                            
                            
                            <div class="col-md-12">
                            <br>
                                <div class="col-sm-5"></div>
                                
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"> SUBMIT</i>  
                                    </button>
                                    <a href="{{ route('perbaikan.index') }}" class="btn btn-danger btn-sm">
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
            $.ajax({
                url: "{{ route('pengadaan.selectjenis')}}",
                method: 'POST',
                data: {jenis:jenis, _token:token},
                success: function(data) {
                    var div=$(this).parent();                   
                    op+='<option value="" disabled selected> -- Pilih Spesifikasi --</option>';
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
                              

                }

            });

        });
        

    </script>

@endsection
