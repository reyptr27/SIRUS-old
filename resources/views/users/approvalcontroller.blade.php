@extends('layouts.layout')

@section('title')
    SIRUS | Approval Controller
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        List Permintaan Approval User
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ route('approvalpic') }}">Approval Controller</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Data Users</h3>                        
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" id="datatable">
                                <thead>
                                    <th class="text-center">#</th>
                                    <th class="text-center">NAMA USER</th>
                                    <th class="text-center">NIK</th>
                                    <th class="text-center">JABATAN</th>                        
                                    <th class="text-center">CABANG</th>
                                    <th class="text-center">DEPT</th>
                                    <th class="text-center">STATUS</th>                                    
                                    <th class="text-center">ACTION</th>
                                    <th class="text-center">APPROVAL</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->nik }}</td>
                                        <td>
                                        @if(!empty($user->jabatan))
                                            {{ $user->jabatan }}
                                        @else
                                            <label class="label label-warning">Belum Diset</label>
                                        @endif
                                        </td>
                                        
                                        <td class="text-center">
                                        @if(!empty($user->cabang_id))
                                            {{ $user->cabang->nama_cabang }}
                                        @else
                                            <label class="label label-warning">Belum Diset</label>
                                        @endif
                                        </td>
                                        <td class="text-center">
                                        @if(!empty($user->dept_id))
                                            {{ $user->dept->kode_departemen }}
                                        @else
                                            <label class="label label-warning">Belum Diset</label>
                                        @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($user->active == 4)
                                                <label class="label label-success">Aktif</label>
                                            @elseif($user->active == 5)
                                                <label for="" class="label label-danger">Non-Aktif</label>
                                            @elseif($user->active == 3)
                                                <label for="" class="label label-warning">Diapprove Controller</label>
                                            @elseif($user->active == 2)
                                                <label for="" class="label label-warning">telah diapprove atasan</label>
                                            @elseif($user->active == 1)
                                                <label for="" class="label label-danger">belum diapprove atasan</label>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-xs" title="Lihat" data-toggle="modal"
                                                data-target="#showApproval{{$user->id}}">
                                                <i class="fa fa-eye"> Lihat</i> 
                                            </button>  
                                                                                                                                     
                                        </td>
                                        <td class="text-center">
                                            @if($user->active == 2)
                                                <button type="button" class="btn btn-success btn-xs" title="Approve" data-toggle="modal"
                                                    data-target="#approve{{$user->id}}">
                                                    <i class="">Approve</i> 
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Lihat -->
                                    <div class="modal fade " id="showApproval{{ $user->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center
                                                            @if($user->active == 4) bg-green @endif
                                                            @if($user->active == 3) bg-orange @endif
                                                            @if($user->active == 2) bg-orange @endif
                                                            @if($user->active == 1) bg-red @endif                                    
                                                            @if($user->active == 5) bg-red @endif                                    
                                                
                                                ">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Data Permohonan Approval User <strong>{{$user->name}}</strong> </h4>
                                                </div> 
                                                <div class="modal-body">
                                                    <div class="row">
                                                    <div class="col-md-6">
                                
                                                        <div class="col-sm-4">
                                                            <label for="">Nama</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : {{ $user->name }}
                                                            <p class="text-danger"></p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="">NIK</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : {{ $user->nik }}
                                                            <p class="text-danger"></p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="">Username</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : {{$user->username}}
                                                            <p class="text-danger"></p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="">Email</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : {{$user->email}}
                                                            <p class="text-danger"></p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="">No. Telp / HP</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                           : {{$user->no_telp}}
                                                           <p class="text-danger"></p>
                                                           <p class="text-danger"></p>
                                                           <p class="text-danger"></p>
                                                           <p class="text-danger"></p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="">Tanggal Pengajuan</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                           : {{$user->created_at}}
                                                           <p class="text-danger"></p>
                                                        </div>                                                               
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                
                                                        <div class="col-sm-4">
                                                            <label for="">Status</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            @if($user->active == 4) : <label for="" class="label label-success">Aktif</label> @endif
                                                            @if($user->active == 3) : <label for="" class="label label-info">Menunggu approval IT</label> @endif
                                                            @if($user->active == 2) : <label for="" class="label label-warning">Telah Diapprove oleh atasan</label> @endif
                                                            @if($user->active == 1) : <label for="" class="label label-danger">Menunggu approval atasan</label> @endif                                    
                                                            @if($user->active == 5) : <label for="" class="label label-danger">Non Aktif</label> @endif                                    
                                                            
                                                            <p class="text-danger"></p>
                                                        </div>      
                                                                            
                                                        <div class="col-sm-4">
                                                            <label for="">Jabatan</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : {{$user->jabatan}}
                                                            <p class="text-danger"></p>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label for="">Atasan</label>
                                                        </div>
                                                        <div class="col-sm-8"> @if($user->atasan_id != null)                                                     
                                                                : {{ $user->atasan->name}} @else - @endif                                                           
                                                            <p class="text-danger"></p>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label for="">Cabang</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : {{ $user->cabang->nama_cabang}}
                                                            <p class="text-danger"></p>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label for="">Departemen</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : {{ $user->dept->nama_departemen}}
                                                            <p class="text-danger"></p>
                                                        </div>                                                                                                           
                                                        <div class="col-sm-4">
                                                            @if(!empty($user->image))
                                                                <img src="{{ asset('images/profile').'/'.$user->image }}" width="100px" height="100px">
                                                            @else
                                                                <img src="{{ asset('images/profile/default-profile.jpg') }}" width="100px" height="100px">
                                                            @endif                                      
                                                            
                                                        </div>
                                                        <div class="col-sm-8">
                                                            
                                                        </div>
                                                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                                    </div>           
                                                    </div>                                                
                                                       
                                                </div>
                                                <div class="modal-footer 
                                                @if($user->active == 4) bg-green @endif
                                                            @if($user->active == 3) bg-orange @endif
                                                            @if($user->active == 2) bg-orange @endif
                                                            @if($user->active == 1) bg-red @endif                                    
                                                            @if($user->active == 5) bg-red @endif
                                                " >                                                                                   
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <!-- modal approve -->
                                    <div class="modal fade" id="approve{{ $user->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin approve user <strong>{{ $user->name }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('approvalcontroller.approve', $user->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PATCH') }}
                                                    <div class="modal-footer">
                                                        <center>
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> APPROVE</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> BATAL</button>
                                                        </center>
                                                    </div>
                                                </form> 
                                                    
                                            </div>                                         
                                        </div>
                                    </div> 
                                    
                                    
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                               
                            </div>
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
                { "width": "3%", "targets": 0}
            ],
            });
        });
    </script>
@endsection