@extends('layouts.layout')

@section('title')
    SIRUS | BA TAM
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Data Teknisi
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Berita Acara</a></li>
        <li class="active"><a href="{{ route('tam.teknisi.index') }}">List Data Teknisi</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Karyawan <br> PT. Sinar Roda Utama</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12" align="center">
                            <form action="{{ route('tam.teknisi.store', 1) }}" method="post">
                            {{ csrf_field() }}
                                                      
                            <div class="col-sm-12">
                                <label for="">Nama Karyawan</label>
                            </div>
                            <div class="col-sm-12">
                                <select name="karyawan_id" id="karyawan_id" 
                                class="form-control selectpicker" data-live-search="true" required>
                                    <option value="" disabled selected>Pilih Karyawan</option>
                                    @foreach ($users as $karyawan)
                                    <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
                                    @endforeach
                                </select>                                    
                                <p class="text-danger"></p>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"> Tambahkan sebagai teknisi</i> 
                                        <i class="fa fa-arrow-right"></i> 
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>   
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Data Teknisi PT. Sinar Roda Utama</h3>

                        <div class="modal fade" id="tambahRS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Rumah Sakit</h4>
                                    </div>
                                    <form action="" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Rumah Sakit</label>
                                                <input type="text" name="nama_rs" class="form-control" placeholder="Nama Rumah Sakit" required>
                                            </div>  
                                            <div class="form-group">
                                                <label for="">Status</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="1">Aktif</option>
                                                    <option value="2">Non-Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">                                            
                                            <button type="submit" class="btn btn-success">SIMPAN</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">#</th>
                                    <th class="text-center">NAMA TEKNISI</th>
                                    <!-- <th class="text-center">STATUS</th> -->
                                    @can('tam-ba-rs-hapus')<th class="text-center">ACTION</th>@endcan
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($teknisis as $teknisi)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $teknisi->name }}</td>
                                        <!-- <td class="text-center">
                                            @if($teknisi->status == 1 )
                                                <label class="label label-success">Aktif</label>
                                            @else
                                                <label class="label label-danger">Non-Aktif</label>
                                            @endif
                                        </td> -->
                                        @can('tam-ba-rs-hapus')
                                        <td>
                                            <!-- tombol action -->
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusRS{{ $teknisi->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                        @endcan 
                                    </tr>
                                    
                                    
                                    <!-- modal hapus -->
                                    @can('tam-ba-rs-hapus')
                                    <div class="modal fade" id="hapusRS{{ $teknisi->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $teknisi->name }}</strong> dari daftar teknisi?</h4>
                                                </div>
                                                
                                                <form action="{{ route('tam.teknisi.destroy', $teknisi->teknisi) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <div class="modal-footer">
                                                        <center>
                                                            <button type="submit" class="btn btn-primary">HAPUS</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                                                            
                                                        </center>
                                                    </div>
                                                </form> 
                                                    
                                            </div>                                         
                                        </div>
                                    </div>
                                    @endcan 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection

@section('js-extra')
    <script>
        $(document).ready( function(){
            $('#datatable').DataTable({
                columnDefs: [
                    //untuk menghilangkan order
                    {
                        targets: 1,
                        orderable: false,
                    },
                    { "width": "5%", "targets": 0},
                ],
            });
        });
    </script>
@endsection