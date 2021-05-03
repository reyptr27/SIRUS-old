@extends('layouts.layout')

@section('title')
    SIRUS | Data Divisi
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Data Divisi
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active"><a href="{{ route('divisi.index') }}">Divisi</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h2 class="box-title" >List Divisi</h2>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahDivisi">
                            <i class="fa fa-plus"></i> Tambah
                        </button>

                        <div class="modal fade" id="tambahDivisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Divisi</h4>
                                    </div>
                                    <form action="{{ route('divisi.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Divisi</label>
                                                <input type="text" name="nama_divisi" class="form-control" placeholder="Nama Divisi" required>
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
                            <table class="table" id="datatable" >
                                <thead>
                                    <th class="text-center">#</th>
                                    <th class="text-center">NAMA DIVISI</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($divisis as $divisi)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $divisi->nama_divisi }}</td>
                                        <td class="text-center">
                                            @if($divisi->status == 1 )
                                                <label class="label label-success">Aktif</label>
                                            @else
                                                <label class="label label-danger">Non-Aktif</label>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- tombol action -->
                                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                                data-target="#updateDivisi{{ $divisi->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            {{-- <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusDivisi{{ $divisi->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>    --}}
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateDivisi{{ $divisi->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit <strong>{{ $divisi->nama_divisi }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('divisi.update', $divisi->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('patch') }}
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-group">
                                                            <label for="">Nama Divisi</label>
                                                            <input type="text" name="nama_divisi" placeholder="Nama Divisi" class="form-control" value="{{ $divisi->nama_divisi }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="1" @if($divisi->status == 1) selected @endif>Aktif</option>
                                                                <option value="2" @if($divisi->status == 2) selected @endif>Non-Aktif</option>
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
                                    <!-- modal hapus -->
                                    {{-- <div class="modal fade" id="hapusDivisi{{ $divisi->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $divisi->nama_divisi }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('divisi.destroy', $divisi->id) }}" method="post">
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
                                    </div>  --}}
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
                    { "width": "5%", "targets": 0 },
                ]
            });
        });
    </script>
@endsection
