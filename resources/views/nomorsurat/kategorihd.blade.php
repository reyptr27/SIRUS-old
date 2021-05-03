@extends('layouts.layout')

@section('title')
    SIRUS | Kategori Nomor Surat
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Kategori Surat HD
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Nomor Surat</a></li>
        <li><a href="#">Surat Internal HD</a></li>
        <li class="active"><a href="{{ route('kategori.hd.index') }}">Kategori Surat HD</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Kategori Surat HD</h3>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahKategori">
                            <i class="fa fa-plus"></i> Tambah
                        </button>

                        <div class="modal fade" id="tambahKategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Kategori</h4>
                                    </div>
                                    <form action="{{ route('kategori.hd.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Kategori</label>
                                                <input type="text" name="kategori" class="form-control" placeholder="Nama Kategori" required>
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
                                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
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
                                    <th class="text-center">KATEGORI</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($kategoris as $kategori)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $kategori->kategori }}</td>
                                        <td class="text-center">
                                            @if($kategori->status == 1 )
                                                <label class="label label-success">Aktif</label>
                                            @else
                                                <label class="label label-danger">Non-Aktif</label>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- tombol action -->
                                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                                data-target="#updateKategori{{ $kategori->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            @can('nomorsurat-hapus')
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusKategori{{ $kategori->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                            @endcan 
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateKategori{{ $kategori->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit <strong>{{ $kategori->kategori }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('kategori.hd.update', $kategori->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('patch') }}
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-group">
                                                            <label for="">Nama Kategori</label>
                                                            <input type="text" name="kategori" placeholder="Nama Kategori" class="form-control" value="{{ $kategori->kategori }}" required>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="1" @if($kategori->status == 1) selected @endif>Aktif</option>
                                                                <option value="2" @if($kategori->status == 2) selected @endif>Non-Aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
                                                    </div>
                                                </form>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    @can('nomorsurat-hapus')
                                    <!-- modal hapus -->
                                    <div class="modal fade" id="hapusKategori{{ $kategori->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $kategori->kategori }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('kategori.hd.destroy', $kategori->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <div class="modal-footer">
                                                        <center>
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-trash-o"></i> HAPUS</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
                                                            
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
                        targets: 3,
                        orderable: false,
                    },
                    { "width": "5%", "targets": 0},
                ],
            });
        });
    </script>
@endsection