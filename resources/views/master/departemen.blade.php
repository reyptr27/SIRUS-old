@extends('layouts.layout')

@section('title')
    SIRUS | Data Departemen
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Data Departemen
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active"><a href="{{ route('departemen.index') }}">Departemen</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h2 class="box-title" >List Departemen</h2>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahDepartemen">
                            <i class="fa fa-plus"></i> Tambah
                        </button>

                        <div class="modal fade" id="tambahDepartemen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Departemen</h4>
                                    </div>
                                    <form action="{{ route('departemen.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Departemen</label>
                                                <input type="text" name="nama_departemen" class="form-control" placeholder="Nama Departemen" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Kode Departemen</label>
                                                <input type="text" name="kode_departemen" class="form-control" placeholder="Kode Departemen" required>
                                            </div>    
                                            <div class="form-group">
                                                <label for="">Divisi</label>
                                                <select name="divisi_id" class="form-control" required>
                                                    <option value="" disabled selected>Pilih Divisi</option>
                                                    @foreach ($divisis as $divisi)
                                                    <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                                                    @endforeach
                                                </select>
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
                                    <th class="text-center">NAMA DEPARTEMEN</th>
                                    <th class="text-center">KODE DEPT</th>
                                    <th class="text-center">DIVISI</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($departemens as $departemen)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $departemen->nama_departemen }}</td>
                                        <td>{{ $departemen->kode_departemen }}</td>
                                        <td>
                                            @if($departemen->divisi_id != null)
                                                {{ $departemen->divisi->nama_divisi }}
                                            @else 
                                                <i>(kosong)</i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($departemen->status == 1 )
                                                <label class="label label-success">Aktif</label>
                                            @else
                                                <label class="label label-danger">Non-Aktif</label>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- tombol action -->
                                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                                data-target="#updateDepartemen{{ $departemen->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            {{-- <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusDepartemen{{ $departemen->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>    --}}
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateDepartemen{{ $departemen->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit <strong>{{ $departemen->nama_departemen }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('departemen.update', $departemen->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('patch') }}
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-group">
                                                            <label for="">Nama Departemen</label>
                                                            <input type="text" name="nama_departemen" placeholder="Nama Departemen" class="form-control" value="{{ $departemen->nama_departemen }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Kode Departemen</label>
                                                            <input type="text" name="kode_departemen" placeholder="Nama Departemen" class="form-control" value="{{ $departemen->kode_departemen }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Divisi</label>
                                                            <select name="divisi_id" class="form-control" required>
                                                                <option value="" disabled selected>Pilih Divisi</option>
                                                                @foreach ($divisis as $divisi)
                                                                    <option value="{{ $divisi->id }}" @if($divisi->id == $departemen->divisi_id) selected @endif>{{ $divisi->nama_divisi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="1" @if($departemen->status == 1) selected @endif>Aktif</option>
                                                                <option value="2" @if($departemen->status == 2) selected @endif>Non-Aktif</option>
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
                                    {{-- <div class="modal fade" id="hapusDepartemen{{ $departemen->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $departemen->nama_departemen }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('departemen.destroy', $departemen->id) }}" method="post">
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
                        targets: 4,
                        orderable: false,
                    },
                    { "width": "5%", "targets": 0 },
                ]
            });
        });
    </script>
@endsection
