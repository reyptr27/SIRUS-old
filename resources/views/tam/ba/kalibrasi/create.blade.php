@extends('layouts.layout')

@section('title')
    SIRUS | Berita Acara Kalibrasi Mesin
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Berita Acara Kalibrasi Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#">Berita Acara</a></li>
        <li class="active"><a href="{{ route('kalibrasi.create') }}">Tambah BA Kalibrasi Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Berita Acara Kalibrasi Mesin</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('kalibrasi.store')}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">

                            <div class="col-md-6">
                                
                                <div class="col-sm-4">
                                    <label for="">Nama Teknisi</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="teknisi_id" id="teknisi_id" 
                                    class="form-control {{ $errors->has('teknisi_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Teknisi</option>
                                        @foreach ($teknisis as $teknisi)
                                        <option value="{{ $teknisi->id }}">{{ $teknisi->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Kepala Teknisi</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="katek_id" id="katek_id" 
                                    class="form-control {{ $errors->has('katek_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Kepala Teknisi</option>
                                        @foreach ($kateks as $katek)
                                        <option value="{{ $katek->id }}">{{ $katek->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Kepala TAM</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="katam_id" id="katam_id" 
                                    class="form-control {{ $errors->has('katam_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        
                                        @foreach ($katams as $katam)
                                        <option value="{{ $katam->id }}">{{ $katam->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                    
                                </div>                                                                                
                                <div class="col-sm-4"><label for="">Nama Rumah Sakit :</label></div>
                                <div class="col-sm-8">
                                    <select name="rs_id" id="rs_id" 
                                        class="form-control {{ $errors->has('rs_id') ? 'is-invalid':'' }}
                                        selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Rumah Sakit</option>
                                        @foreach ($rumah_sakit as $rs)
                                        <option value="{{ $rs->id }}">{{ $rs->nama_rs }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Tanggal Pengerjaan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal Pelaksanaan" required>
                                    <p class="text-danger"></p>
                                    <br> <br>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="col-sm-5 bg-light-blue ">
                                    <p class="text-danger"></p>
                                    <label for="">Merk / Type</label>
                                    <p class="text-danger"></p>
                                </div> 
                                <div class="col-sm-5 bg-light-blue ">
                                    <p class="text-danger"></p>
                                    <label for="">No Seri</label>
                                    <p class="text-danger"></p>
                                </div>  
                                <div class="col-sm-2 bg-light-blue" align="center">
                                    <p class="text-danger"></p>
                                    <label for="">-</label>
                                    <p class="text-danger"></p>
                                </div>
                                <br><br><br>
                                <div id="dynamic_field"></div>
                            
                            </div>

                            
                            <div class="col-md-12">
                            <br>
                                <div class="col-sm-5"></div>
                                
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"> SUBMIT</i>  
                                    </button>
                                    <a href="{{ route('kalibrasi.index') }}" class="btn btn-danger btn-sm">
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
        $(function () {
            $('.selectpicker').selectpicker();
            var count = 1; 
            add_dynamic_input_field(count);

            function add_dynamic_input_field(count){
                var button = '';
                if(count > 1){
                    button = '<button type="button" name"barang-remove" id="'+count+'" class="btn btn-danger btn-sm barang-remove"><span class="glyphicon glyphicon-minus"></span></button>';
                }else{
                    button = '<button type="button" name"barang_more" id="barang_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
                }
                output = '<div class="row" id="barang'+count+'">';                
                output += `
                    
                    <div class="col-sm-5">
                        <div class="form-group">
                        <select name="merk[]" id="merk" 
                                    class="form-control
                                     selectpicker" required >
                                        <option value="1" selected>SURDIAL</option>
                                        <option value="2">SURDIAL 55</option>
                                        <option value="3">SURDIAL 55 PLUS</option>
                                    </select>      
                        
                            <p class="text-danger"></p>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                        <input type="text" name="no_seri[]" id="no_seri" class="form-control" placeholder="No Seri" required>
                            <p class="text-danger"></p>
                        </div>
                    </div>
                `;
                output += '<div class="col-sm-2">'+button+'</div></div>';
                $('#dynamic_field').append(output);
                $(".selectpicker").selectpicker('refresh');
            }

            $(document).on('click','#barang_more', function(){
                count = count + 1;
                add_dynamic_input_field(count);
            });

            $(document).on('click','.barang-remove', function(){
                var row_id = $(this).attr("id");
                $('#barang'+row_id).remove();
            });

            

        });        

    </script>


@endsection

