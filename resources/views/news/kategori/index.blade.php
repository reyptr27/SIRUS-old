@extends('layouts.layout')

@section('title')
    SIRUS | Kategori News
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        List Kategori News
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">News</a></li>
        <li class="active"><a href="{{ route('news.kategori.index') }}">Kategori</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Kategori News</h3>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahKategori">
                            <i class="fa fa-plus"></i> Tambah Kategori
                        </button>

                        <div class="modal fade" id="tambahKategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Kategori</h4>
                                    </div>
                                    <form action="{{ route('news.kategori.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Kategori</label>
                                                <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
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
                                    <th class="text-center">Nama Kategori</th>
                                    <th class="text-center">Ditambahkan Oleh</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @forelse($kategoris as $row)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $row->nama_kategori }}</td>
                                        <td>
                                            @if($row->created_by != null)    
                                                {{ $row->user->name }}
                                            @else
                                                <label class="label label-warning">Belum diset</label>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($row->status == 1)
                                                <label for="" class="label label-success">Aktif</label>
                                            @else
                                                <label for="" class="label label-danger">Non-Aktif</label>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#editKategori{{ $row->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button> 
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#hapusKategori{{ $row->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>   
                                        </td>
                                    </tr>
                                    <!-- modal edit  -->
                                    <div class="modal fade" id="editKategori{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Update Kategori <strong>{{ $row->nama_kategori }}</strong></h4>
                                                </div>
                                                <form action="{{ route('news.kategori.update', $row->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('patch') }}
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">Nama Kategori</label>
                                                            <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" value="{{ $row->nama_kategori }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="1" @if($row->status == 1) selected @endif>Aktif</option>
                                                                <option value="2" @if($row->status == 2) selected @endif>Non-Aktif</option>
                                                            </select>
                                                        </div>  
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info"><i class="fa fa-send"></i> UPDATE</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- modal hapus -->
                                    <div class="modal fade" id="hapusKategori{{ $row->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus Kategori : <strong>{{ $row->nama_kategori }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('news.kategori.destroy', $row->id) }}" method="post">
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

                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
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
                { "width": "7%", "targets": 0}

            ],
            });
        });
    </script>
@endsection
