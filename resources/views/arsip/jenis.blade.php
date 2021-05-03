@extends('layouts.layout')

@section('title')
    SIRUS | Jenis Arsip
@endsection
    
@section('content')
<?php use App\Models\Departemen; ?>
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Jenis Arsip
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Arsip</a></li>
        <li class="active"><a href="{{ route('jenis.arsip.index') }}">Jenis Arsip</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Jenis Arsip</h3>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahJenis">
                            <i class="fa fa-plus"></i> Tambah
                        </button>

                        <div class="modal fade" id="tambahJenis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Jenis Arsip</h4>
                                    </div>
                                    <form action="{{ route('jenis.arsip.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Jenis Arsip</label>
                                                <input type="text" name="jenis_arsip" class="form-control" placeholder="Jenis Arsip" required>
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
                                    <th class="text-center">JENIS ARSIP</th>
                                    @role('Administrator')
                                    <th class="text-center">DEPT</th>
                                    @endrole
                                    <th class="text-center">DITAMBAHKAN OLEH</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($jenis as $row)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $row->jenis_arsip }}</td>
                                        @role('Administrator')
                                        <?php 
                                            $dept = Departemen::where(['id' => $row->dept_id])->first();
                                            echo '<td>'.$dept->kode_departemen.'</td>';
                                        ?>
                                        @endrole
                                        <td>{{ $row->creator->name }}</td>
                                        <td class="text-center">
                                            @if($row->status == 1 )
                                                <label class="label label-success">Aktif</label>
                                            @else
                                                <label class="label label-danger">Non-Aktif</label>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- tombol action -->
                                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                                data-target="#updateJenis{{ $row->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            @can('arsip-jenis-hapus')
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusJenis{{ $row->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateJenis{{ $row->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit <strong>{{ $row->jenis_arsip }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('jenis.arsip.update', $row->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('patch') }}
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="1" @if($row->status == 1) selected @endif>Aktif</option>
                                                                <option value="2" @if($row->status == 2) selected @endif>Non-Aktif</option>
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
                                    @can('arsip-jenis-hapus')
                                    <!-- modal hapus -->
                                    <div class="modal fade" id="hapusJenis{{ $row->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $row->jenis_arsip }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('jenis.arsip.destroy', $row->id) }}" method="post">
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
                        targets: 4,
                        orderable: false,
                    },
                    { "width": "5%", "targets": 0},
                ],
            });
        });
    </script>
@endsection