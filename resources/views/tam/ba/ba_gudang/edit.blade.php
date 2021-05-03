@extends('layouts.layout')

@section('title')
    SIRUS | Berita Acara Gudang
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Berita Acara Gudang
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href=" {{route('bagudang.index')}} ">Berita Acara</a></li>
        <li class="active"><a href="{{ route('bagudang.edit', $ba->id) }}">Edit Serah Terima Barang</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Berita Acara Serah Terima Barang</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('bagudang.update', $ba->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">

                        <div class="col-md-6">
                                
                                <div class="col-sm-4">
                                    <label for="">Nama Penerima</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="penerima_id" id="penerima_id" 
                                    class="form-control {{ $errors->has('penerima_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Penerima</option>
                                        @foreach ($penerimas as $penerima)
                                        <option 
                                        @if ($penerima->id == $ba->penerima_id ) selected @endif
                                        value="{{ $penerima->id }}">{{ $penerima->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Jabatan</label>
                                </div>
                                <div class="col-sm-8">
                                    @foreach($penerimas as $penerima)
                                        @if ($penerima->id == $ba->penerima_id)
                                            <input type="text" name="jabatan" id="jabatan" 
                                            value="{{$penerima->jabatan}}" 
                                            class="form-control">
                                        @endif                                                                                
                                    @endforeach
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Perusahaan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="perusahaan_penerima" id="perusahaan_penerima" 
                                    value="PT. Sinar Roda Utama" class="form-control" placeholder="Perusahaan">
                                    <p class="text-danger"></p>
                                </div>  

                                <div class="col-sm-4"><label for="">Alamat Penerima :</label></div>
                                <div class="col-sm-8">
                                <select name="alamat_id" id="alamat_id" 
                                    class="form-control {{ $errors->has('alamat_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Alamat Penerima</option>
                                        @foreach ($alamats as $alamat)
                                        <option 
                                        @if ($alamat->id == $ba->alamat_id ) selected @endif
                                        value="{{ $alamat->id }}">{{ $alamat->nama_gudang }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Nama Pengirim</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control" 
                                    value="{{$ba->nama_pengirim}}" placeholder="Nama Pengirim" required>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Perusahaan Pengirim</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="perusahaan_pengirim" id="perusahaan_pengirim" class="form-control"
                                    value="{{$ba->perusahaan_pengirim}}" placeholder="Perusahaan"required>
                                    <p class="text-danger"></p>
                                </div> 
                                
                                <div class="col-sm-4"><label for="">Alamat Pengirim :</label></div>
                                <div class="col-sm-8">
                                <textarea class="form-control" name="alamat_pengirim" id="alamat_pengirim" cols="60"
                                 rows="3" required> {{$ba->alamat_pengirim}} </textarea>
                                 </div>                                 
                                  
                                                                                   
                            </div>

                            <div class="col-md-6">

                                <div class="col-sm-4">
                                    <label for="">Berupa</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="jenis_barang" id="jenis_barang" class="form-control" 
                                    value="{{$ba->jenis_barang}}" placeholder="Jenis Barang" required>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Dokumen : </label>
                                </div>
                                <div class="col-sm-8">
                                    <br>
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-sm-4">
                                    <label for=""> - No. PL / Resi</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="no_resi" id="no_resi" class="form-control" placeholder="N0 PL / Resi"
                                    value="{{$ba->no_resi}}" required>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for=""> - No. Container / Nopol</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="no_container" id="no_container" class="form-control" 
                                    value="{{$ba->no_container}}" placeholder="No Container" required>
                                    <p class="text-danger"></p> <br>
                                </div> <br>
                                <div class="col-sm-4">
                                    <label for=""> - No. Seal</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="no_seal" id="no_seal" class="form-control" placeholder="No Seal"
                                    value="{{$ba->no_seal}}" required>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for=""> - No. Surat Jalan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="no_surat_jalan" id="no_surat_jalan" class="form-control" 
                                    value="{{$ba->no_surat_jalan}}" placeholder="No Surat Jalan" required>
                                    <p class="text-danger"></p>
                                    <br>
                                </div>


                                <div class="col-sm-4">
                                    <label for="">Sesuai</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="sesuai" id="sesuai" 
                                    class="form-control {{ $errors->has('sesuai') ? 'is-invalid':'' }}
                                     selectpicker" >
                                        <option value="1" @if($ba->sesuai==1) selected @endif>Sesuai</option>
                                       
                                        <option value="0" @if($ba->sesuai==0) selected @endif>Tidak sesuai</option>
                                        
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div> 
                                <div class="col-sm-4">
                                    <label for="">Selisih</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="number" name="selisih" id="selisih" class="form-control" 
                                    @if($ba->sesuai==1) disabled @endif
                                    @if($ba->sesuai==0) value="{{$ba->selisih}}" @endif
                                    placeholder="Jumlah Selisih" >
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Cacat</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="number" name="cacat" id="cacat" class="form-control" 
                                    @if($ba->sesuai==1) disabled @endif
                                    @if($ba->sesuai==0) value="{{$ba->cacat}}" @endif
                                    placeholder="Jumlah barang Cacat">
                                    <p class="text-danger"></p>
                                    <br>
                                </div> 

                                                                                                                 
                            </div>

                            <div class="col-md-12">
                                
                                
                                <div class="col-sm-3 bg-light-blue">
                                    <label for="">Nama Barang</label>
                                    <p class="text-danger"></p>
                                </div> 
                                <div class="col-sm-2 bg-light-blue">
                                    <label for="">Kuantitas</label>
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-sm-2 bg-light-blue ">
                                    <label for="">Satuan</label>
                                    <p class="text-danger"></p>
                                </div> 
                                <div class="col-sm-2 bg-light-blue ">
                                    <label for="">Kondisi</label>
                                    <p class="text-danger"></p>
                                </div> 
                                <div class="col-sm-2 bg-light-blue ">
                                    <label for="">Keterangan</label>
                                    <p class="text-danger"></p>
                                </div> 
                                <div class="col-sm-1 bg-light-blue">
                                <label for="">-</label>
                                <p class="text-danger"></p>
                                </div>
                                <br><br>

                                @php $i = 1 @endphp
                            @foreach($barangs as $barang)
                                <div class="row" id="barang{{$i}}">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <input type="text" name="nama_barang[]" id="nama_barang" class="form-control"
                                        value="{{$barang->nama_barang}}" placeholder="Nama Barang" required>
                                            <p class="text-danger">{{ $errors->first('nama_barang[]') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <input type="number" name="kuantitas[]" id="kuantitas" class="form-control" 
                                        value="{{$barang->kuantitas}}" placeholder="Kuantitas"required>
                                            <p class="text-danger">{{ $errors->first('kuantitas[]') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <input type="text" name="satuan[]" id="satuan" class="form-control" 
                                        value="{{$barang->satuan}}" placeholder="Satuan" required>
                                            <p class="text-danger">{{ $errors->first('satuan[]') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <select name="kondisi[]" id="sesuai" 
                                                    class="form-control {{ $errors->has('kondisi[]') ? 'is-invalid':'' }}
                                                    selectpicker" required >
                                                        <option value="1" @if($barang->kondisi==1) selected @endif>Baik</option>                                       
                                                        <option value="0" @if($barang->kondisi==0) selected @endif>Tidak baik</option>                                        
                                                    </select>      
                                        
                                            <p class="text-danger">{{ $errors->first('kondisi[]') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <input type="text" name="keterangan[]" id="keterangan" class="form-control" 
                                        value="{{$barang->keterangan}}" placeholder="Keterangan" required>
                                            <p class="text-danger">{{ $errors->first('keterangan[]') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        @if($i > 1)
                                            <button type="button" name="barang-remove" id="{{$i}}" class="btn btn-danger btn-sm barang-remove"><span class="glyphicon glyphicon-minus"></span></button>
                                        @else
                                            <button type="button" name="barang_more" id="barang_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                        @endif
                                    </div>
                                </div>
                                @php $i++ @endphp
                            @endforeach


                                <div id="dynamic_field"></div>

                            
                            </div>
                            
                            <div class="col-md-12">
                            <br>
                                <div class="col-sm-5"></div>
                                
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"> SUBMIT</i>  
                                    </button>
                                    <a href="{{ route('bagudang.index') }}" class="btn btn-danger btn-sm">
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
       
        $("select[name='penerima_id']").change(function(){
            var pemohon = $(this).val();
            var token = $("input[name='_token']").val();            
            
            console.log(pemohon);
            $.ajax({
                url: "{{ route('pengadaan.selectpemohon')}}",
                method: 'POST',
                data: {pemohon:pemohon, _token:token},
                success: function(data) {
                    console.log(data.nik);
                    $('#perusahaan_penerima').val(" ");
                    $('#perusahaan_penerima').val("PT. Sinar Roda Utama");
                    $('#jabatan').val(" ");
                    $('#jabatan').val(data.jabatan);
                           

                }

            });

        });


        $('#sesuai').change(function(){
            if ( this.value == '0'){
                // $("#cacat").enable();
                document.querySelector('#selisih').disabled = false;
                document.querySelector('#cacat').disabled = false;
                document.querySelector('#cacat').required = true;
                document.querySelector('#selisih').required = true;
                
            }          
            else {
                document.querySelector('#cacat').required = false;
                document.querySelector('#selisih').required = false;
                document.querySelector('#selisih').disabled = true;
                document.querySelector('#cacat').disabled = true;
                $('#selisih').val(null);
                $('#cacat').val(null);
            }
        });


        $(function () {
            $('.selectpicker').selectpicker();
            // var count = 1; 
            // add_dynamic_input_field(count);
            var jml_barang = {!! $barangs !!}; 
            var count = Object.keys(jml_barang).length;

            function add_dynamic_input_field(count){
                var button = '';
                if(count > 1){
                    button = '<button type="button" name"barang-remove" id="'+count+'" class="btn btn-danger btn-sm barang-remove"><span class="glyphicon glyphicon-minus"></span></button>';
                }else{
                    button = '<button type="button" name"barang_more" id="barang_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
                }
                output = '<div class="row" id="barang'+count+'">';                
                output += `
                    
                   
                    <div class="col-sm-3">
                        <div class="form-group">
                        <input type="text" name="nama_barang[]" id="nama_barang" class="form-control" placeholder="Nama Barang" required>
                            <p class="text-danger">{{ $errors->first('nama_barang[]') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                        <input type="number" name="kuantitas[]" id="kuantitas" class="form-control" 
                        placeholder="Kuantitas"required>
                            <p class="text-danger">{{ $errors->first('kuantitas[]') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                        <input type="text" name="satuan[]" id="satuan" class="form-control" placeholder="Satuan" required>
                            <p class="text-danger">{{ $errors->first('satuan[]') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                        <select name="kondisi[]" id="sesuai" 
                                    class="form-control {{ $errors->has('kondisi[]') ? 'is-invalid':'' }}
                                     selectpicker" required >
                                        <option value="1" selected>Baik</option>                                       
                                        <option value="0">Tidak baik</option>                                        
                                    </select>      
                        
                            <p class="text-danger">{{ $errors->first('kondisi[]') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                        <input type="text" name="keterangan[]" id="keterangan" class="form-control" placeholder="Keterangan" required>
                            <p class="text-danger">{{ $errors->first('keterangan[]') }}</p>
                        </div>
                    </div>
                `;
                output += '<div class="col-sm-1">'+button+'</div></div>';
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

