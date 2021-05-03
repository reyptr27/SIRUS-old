@extends('layouts.layout')

@section('title')
    SIRUS | Link Portal
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Link Portal
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Setting</a></li>
        <li class="active"><a href="{{ route('portal.link') }}">Portal</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Link</h3>
                        <a href="{{ route('portal.create') }}" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Tambah Link
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">#</th>
                                    <th class="text-center">ICON</th>
                                    <th class="text-center">NAMA LINK</th>
                                    <th class="text-center">SUBTITLE</th>
                                    <th class="text-center">LINK</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @forelse($portal as $row)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('assets/portal/img/link/').'/'.$row->icon}}" width="30px" height="30px" >
                                        </td>
                                        <td>{{ $row->nama_aplikasi }}</td>
                                        <td>{{ $row->subtitle }}</td>
                                        <td>{{ $row->link }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('portal.edit', $row->id) }}" class="btn btn-info btn-xs">
                                                <i class="fa fa-edit"></i> Edit
                                            </a> 
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusLink{{ $row->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>   
                                        </td>
                                    </tr>

                                    <!-- modal hapus -->
                                    <div class="modal fade" id="hapusLink{{ $row->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus Link : <strong>{{ $row->nama_aplikasi }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('portal.destroy', $row->id) }}" method="post">
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
