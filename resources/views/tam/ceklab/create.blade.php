@extends('layouts.layout')

@section('title')
    SIRUS | Form Permintaan Pemeriksaan Cek Lab
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Form Permintaan Pemeriksaan Cek Lab
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#">Formulir TAM</a></li>
        <li class="active"><a href="{{ route('ceklab.create') }}">Tambah Form Cek Lab</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Formulir Permintaan Pemeriksaan Cek Lab</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('ceklab.store')}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">

                        <div class="col-md-12">
                                
                                <div class="col-sm-3">
                                    <label for="">Nama Pemohon</label>
                                </div>
                                <div class="col-sm-9">
                                    <select name="pemohon_id" id="pemohon_id" 
                                    class="form-control
                                     selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Pemohon</option>
                                        @foreach ($pemohons as $pemohon)
                                        <option value="{{ $pemohon->id }}">{{ $pemohon->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>                                
                                <div class="col-sm-3"><label for="">Rumah Sakit / Customer </label></div>
                                <div class="col-sm-9">
                                    <select name="rs_id" id="rs_id" 
                                        class="form-control {{ $errors->has('rs_id') ? 'is-invalid':'' }}
                                        selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Rumah Sakit / Customer</option>
                                        @foreach ($rumah_sakit as $rs)
                                        <option value="{{ $rs->id }}">{{ $rs->nama_rs }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Type Mesin /No Seri</label>
                                </div>
                                <div class="col-sm-9">
                                <input type="text" name="type" id="type" class="form-control" 
                                placeholder="Type Mesin /No Seri" required>
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-sm-3"><label for="">Alamat Customer </label></div>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="alamat" 
                                    id="alamat" cols="60" rows="3" required></textarea>
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-sm-3"><label for="">Pihak Ketiga </label></div>
                                <div class="col-sm-9">
                                    <select name="pihak_ketiga" id="pihak_ketiga" 
                                        class="form-control 
                                        selectpicker" required>
                                        <option value="" disabled selected>Pilih Pihak Ketiga</option>
                                        <option value="1">PT. SUCOFINDO - Laboratory Surabaya</option>
                                        <option value="2">PERSADA LABORATORY - Mojokerto</option>
                                        <option value="3">Balai Besar Laboratorium Kesehatan(BBLK) - Surabaya</option>
                                        <option value="4">PT. CITO DIAGNOSTIKA UTAMA - Semarang</option>                                        
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>  
                                <div class="col-sm-3"><label for="">Pemeriksaan </label></div>
                                <div class="col-sm-9">
                                    <select name="pemeriksaan" id="pemeriksaan" 
                                        class="form-control 
                                        selectpicker" required>
                                        <option value="" disabled selected>Pilih Tes yang diperlukan</option>
                                        <option value="1">Tes Na dan K</option>
                                        <option value="2">Tes Air RO standart AAMI (Lengkap)</option>
                                        <option value="3">Lainnya : Mikrobiologi (TPC)</option>
                                        <option value="4">Lainnya : Air Bersih (Kimia Kesehatan)</option>
                                        <option value="5">Lainnya </option>
                                        
                                    </select>  
                                    <p class="text-danger"></p>                                  
                                    
                                </div>
                                <div class="col-sm-3"><label for="" style="margin-left:30px">- Lainnya </label></div>
                                <div class="col-sm-9">
                                    <input type="text" name="lainnya" id="lainnya" class="form-control" placeholder="Lainnya" disabled>                                     
                                    
                                </div>
                               
                                <p class="text-danger"></p>
                                
                                                                                   
                            </div>

                            
                            <div class="col-md-12">
                            <br>
                                <div class="col-sm-5"></div>
                                
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"> SUBMIT</i>  
                                    </button>
                                    <a href="{{ route('ceklab.index') }}" class="btn btn-danger btn-sm">
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
        $('#pemeriksaan').change(function(){
            if(this.value == '5')
            {
                document.querySelector('#lainnya').disabled = false;
            }
            else
            {
                document.querySelector('#lainnya').disabled = true;
                $('#lainnya').val('');
                // document.querySelector('#lainnya'). = true;
            }

        })
    </script>


@endsection

