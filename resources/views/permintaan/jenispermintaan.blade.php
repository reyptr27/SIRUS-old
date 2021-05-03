@extends('layouts.layout')

@section('title')
    SIRUS | Data Jenis Permintaan
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Data Jenis Permintaan
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Permintaan</a></li>
        <li class="active"><a href="{{ route('jenispermintaan.index') }}">Jenis Permintaan</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Jenis Permintaan</h3>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahCabang">
                            <i class="fa fa-plus"></i> Tambah
                        </button>

                        <div class="modal fade" id="tambahCabang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Jenis Permintaan</h4>
                                    </div>
                                    <form action="{{ route('jenispermintaan.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Jenis Permintaan</label>
                                                <select name="kode" class="form-control" required>
                                                    <option value="Hardware">Hardware</option>
                                                    <option value="Software">Software</option>
                                                    <option value="Consumables">Consumables</option>
                                                    <option value="Service">Service</option>
                                                    <option value="Email">Email</option>
                                                </select>

                                            </div>  
                                            <div class="form-group">
                                                <label for="">Spesifikasi</label>
                                                <input type="text" name="spesifikasi" class="form-control" placeholder="Spesifikasi" required>
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
                                    <th class="text-center">JENIS PERMINTAAN</th>
                                    <th class="text-center">SPESIFIKASI</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($jenispermintaans as $jenispermintaan)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $jenispermintaan->kode }}</td>
                                        <td>{{ $jenispermintaan->spesifikasi }}</td>
                                        <td class="text-center">
                                            @if($jenispermintaan->status == 1 )
                                                <label class="label label-success">Aktif</label>
                                            @else
                                                <label class="label label-danger">Non-Aktif</label>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- tombol action -->
                                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                                data-target="#updateJP{{ $jenispermintaan->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusJP{{ $jenispermintaan->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>   
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateJP{{ $jenispermintaan->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit Data <strong> {{ $jenispermintaan->spesifikasi }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('jenispermintaan.update', $jenispermintaan->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('patch') }}
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-group">
                                                            <label for="">Jenis Permintaan</label>
                                                            <select name="kode" class="form-control" required>
                                                                <option value="Hardware" @if($jenispermintaan->kode == 'Hardware') selected @endif>Hardware</option>
                                                                <option value="Software" @if($jenispermintaan->kode == 'Software') selected @endif>Software</option>
                                                                <option value="Consumable" @if($jenispermintaan->kode == 'Consumable') selected @endif>Consumable</option>
                                                                <option value="Service" @if($jenispermintaan->kode == 'Service') selected @endif>Service</option>
                                                                <option value="Email" @if($jenispermintaan->kode == 'Email') selected @endif>Email</option>
                                                            </select>

                                                        </div>  
                                                        <div class="form-group">
                                                            <label for="">Spesifikasi</label>
                                                            <input type="text" name="spesifikasi" value="{{$jenispermintaan->spesifikasi}}" class="form-control" placeholder="Spesifikasi" required>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="1" @if($jenispermintaan->status == 1) selected @endif>Aktif</option>
                                                                <option value="2" @if($jenispermintaan->status == 2) selected @endif>Non-Aktif</option>
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
                                    <div class="modal fade" id="hapusJP{{ $jenispermintaan->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $jenispermintaan->spesifikasi }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('jenispermintaan.destroy', $jenispermintaan->id) }}" method="post">
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