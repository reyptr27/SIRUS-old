@extends('layouts.layout')

@section('title')
    SIRUS | Permission Role List 
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Permission Role List
    </h1><br>
    <a href="{{ route('permission.index')}}" class="btn btn-danger"><< KEMBALI </a>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li><a href="{{ route('permission.index') }}">Permission</a></li>
        <li class="active"><a href="#">Permission Role List</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Role yang mempunyai permission <strong>{{ $permission->name }}</strong></h3>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahRole">
                            <i class="fa fa-plus"></i> Tambah Role
                        </button>

                        <div class="modal fade" id="tambahRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Tambahkan Role</h4>
                                    </div>
                                    <form action="{{ route('permission.role.add', $permission->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Role</label>
                                                <select name="role[]" class="form-control selectpicker" data-live-search="true" multiple>
                                                    @foreach($roleall as $row)
                                                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                    @endforeach
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
                                    <th class="text-center">NAMA ROLE</th>
                                    <th class="text-center">GUARD</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @forelse($roles as $row)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->guard_name }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#hapusRole{{ $row->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>   
                                        </td>
                                    </tr>

                                    <!-- modal hapus -->
                                    <div class="modal fade" id="hapusRole{{ $row->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Hapus <strong>{{ $permission->name }}</strong> dari Role <strong>{{ $row->name }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('permission.role.delete', $permission->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="role" value="{{ $row->name }}">
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
                                        <td colspan="4" class="text-center">Permission Belum dipasang pada Role.</td>
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
