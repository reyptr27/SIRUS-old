@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('css-extra')
    <link rel="stylesheet" href="{{asset('assets/vendors/select2/css/select2.min.css')}}"/>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Penerimaan Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.penerimaan.create') }}">Tambah Penerimaan Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Penerimaan Mesin</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('monitoringmesin.penerimaan.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal Penerimaan</label>
                                    <input type="date" name="tgl_terima" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Gudang Penerima</label>
                                    <select name="gudang_id" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Gudang</option>
                                        @foreach($gudang as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_gudang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Customer</label>
                                    <select name="customer_id" class="form-control selectpicker"  data-live-search="true"required>
                                        <option value="" disabled selected>Pilih Customer</option>
                                        @foreach($customer as $row)
                                            <option value="{{ $row->id }}">{{ $row->nama_rs }}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="form-group">
                                    <label for="">Nomor Surat Jalan</label>
                                    <input type="text" name="surat_jalan" class="form-control" placeholder="Nomor Surat Jalan" required>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="col-sm-2 bg-light-blue">
                                    <label for="">Jenis</label>
                                </div> 
                                <div class="col-sm-4 bg-light-blue">
                                    <label for="">Tipe</label>
                                </div>
                                <div class="col-sm-3 bg-light-blue">
                                    <label for="">Nomor Seri</label>
                                </div>
                                <div class="col-sm-2 bg-light-blue ">
                                    <label for="">Kondisi</label>     
                                </div> 
                                <div class="col-sm-1 bg-light-blue">
                                    <label for="">&nbsp;</label>
                                </div>
                                <br><br>
                                <div id="dynamic_field"></div>             
                            </div>
                        </div>
                        <div class="box-footer">                           
                            <button type="button" title="Submit" class="btn btn-success" data-toggle="modal" data-target="#konfirmasi">
                                <i class="fa fa-send"></i> SIMPAN
                            </button>

                            <div class="modal fade" id="konfirmasi" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menyimpan data penerimaan ?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table width="100%">
                                            <tr>
                                                <td align="center">Data yang disimpan akan dimasukkan pada stock dan tidak dapat diedit kembali</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <center>
                                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>BATAL</button>
                                        </center>
                                    </div>
                                    </div>                                         
                                </div>
                            </div>

                            <a href="{{ route('monitoringmesin.penerimaan.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
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
        var count = 1; 
        add_dynamic_input_field(count);

        function add_dynamic_input_field(count){
            var button = '';
            if(count > 1){
                button = '<button type="button" name"mesin-remove" id="'+count+'" class="btn btn-danger btn-sm mesin-remove"><span class="glyphicon glyphicon-minus"></span></button>';
            }else{
                button = '<button type="button" name"mesin_more" id="mesin_more" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button>';
            }
            output = '<div class="row" id="mesin'+count+'">';
            output += `
                <div class="col-md-2">
                    <div class="form-group">
                        <select name="jenis_id[]" id="${count}" class="form-control jenis" required>
                            <option value="" disabled selected>Pilih Jenis</option>
                            @foreach($jenis as $row)
                                <option value="{{ $row->id }}">{{ $row->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="tipe_id[]" id="${count}" class="form-control tipe${count}" required>
                            <option value="" disabled selected>Pilih Jenis Terlebih Dahulu</option> 
                           
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="nomor_seri[]" class="form-control" placeholder="Nomor Seri" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select name="kondisi[]" class="form-control" required>
                            <option value="" disabled selected>Pilih Kondisi</option>
                            <option value="1">Baru</option> 
                            <option value="2">Bekas</option>
                            <option value="3">Rekondisi</option>
                        </select>
                    </div>
                </div>
            `;
            output += '<div class="col-md-1">'+button+'</div></div>';
            $('#dynamic_field').append(output);
        }

        $(document).on('click','#mesin_more', function(){
            count = count + 1;
            add_dynamic_input_field(count);
        });

        $(document).on('click','.mesin-remove', function(){
            var row_id = $(this).attr("id");
            $('#mesin'+row_id).remove();
        });

        $(document).on('change','.jenis', function(){
            var row_id   = $(this).attr("id");
            var jenis_id = $(this).val();
            var token = $("input[name='_token']").val();            
            var op="";
            console.log('jenis_id='+jenis_id);
            $.ajax({
                url: "{{ route('monitoringmesin.penerimaan.getTipe')}}",
                method: 'POST',
                data: {jenis_id:jenis_id, _token:token},
                success: function(data) {
                    console.log(data);
                    console.log('row ke-'+row_id);
                    var div=$(this).parent();
                    op+='<option value="" disabled selected>Pilih Tipe Mesin</option>';
                    
                        for(var i=0; i<data.length; i++){
                            op+='<option value="'+data[i].id+'">'+data[i].tipe+'</option>';
                        };
                                    
                    $('.tipe'+row_id).html("");
                    $('.tipe'+row_id).append(op);
                }
            });
        });

    });
</script>
@endsection
