@extends('layouts.layout')

@section('title')
    SIRUS | CAPA
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Lokasi CAPA
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">CAPA</a></li>
        <li class="active"><a href="{{ route('capa.lokasi.index') }}">Lokasi</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Lokasi CAPA</h3>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahCapa">
                            <i class="fa fa-plus"></i> Tambah
                        </button>

                        <div class="modal fade" id="tambahCapa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Lokasi CAPA</h4>
                                    </div>
                                    <form action="{{ route('capa.lokasi.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Lokasi</label>
                                                <input type="text" name="lokasi" class="form-control" placeholder="Nama Lokasi" required>
                                            </div>  
                                            <div class="form-group">
                                                <label for="">Alamat Lokasi</label>
                                                <input type="text" name="alamat" class="form-control" placeholder="Alamat Lokasi" required>
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
                                    <th class="text-center">NAMA LOKASI</th>
                                    <th class="text-center">ALAMAT</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($lokasis as $lokasi)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $lokasi->lokasi }}</td>
                                        <td>{{ $lokasi->alamat }}</td>
                                        <td class="text-center">
                                            @if($lokasi->status == 1 )
                                                <label class="label label-success">Aktif</label>
                                            @else
                                                <label class="label label-danger">Non-Aktif</label>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- tombol action -->
                                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                                data-target="#updateCapa{{ $lokasi->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            @can('capa-hapus')
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusCapa{{ $lokasi->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>  
                                            @endcan 
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateCapa{{ $lokasi->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit <strong>{{ $lokasi->lokasi }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('capa.lokasi.update', $lokasi->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('patch') }}
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-group">
                                                            <label for="">Nama Lokasi</label>
                                                            <input type="text" name="lokasi" placeholder="Nama Lokasi" class="form-control" value="{{ $lokasi->lokasi }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Alamat Lokasi</label>
                                                            <input type="text" name="alamat" placeholder="Alamat Lokasi" class="form-control" value="{{ $lokasi->alamat }}" required>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="1" @if($lokasi->status == 1) selected @endif>Aktif</option>
                                                                <option value="2" @if($lokasi->status == 2) selected @endif>Non-Aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">UPDATE</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                                                    </div>
                                                </form>
                                            
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    @can('capa-hapus')
                                        <!-- modal hapus -->
                                        <div class="modal fade" id="hapusCapa{{ $lokasi->id }}" role="dialog" aria-labelledby="myModalLabel">

                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    
                                                    <div class="modal-header text-center">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $lokasi->lokasi}}</strong> ?</h4>
                                                    </div>
                                                    
                                                    <form action="{{ route('capa.lokasi.destroy', $lokasi->id) }}" method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
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
                        targets: 4,
                        orderable: false,
                    },
                    { "width": "5%", "targets": 0},
                ],
            });
        });
    </script>
@endsection