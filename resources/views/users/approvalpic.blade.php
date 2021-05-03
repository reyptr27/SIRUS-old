@extends('layouts.layout')

@section('title')
    SIRUS | Approval PIC
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
        <li class="active"><a href="{{ route('approvalpic') }}">Approval PIC</a></li>
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
                                    <th class="text-center">EMAIL</th>
                                    <th class="text-center">CABANG</th>
                                    <th class="text-center">DEPT</th>                                    
                                    <th class="text-center">ACTION</th>
                                    <th class="text-center">APPROVAL</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @forelse($users as $user)
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
                                        <td>{{ $user->email }}</td>
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
                                        <td>
                                            <button type="button" class="btn btn-default btn-xs" title="Lihat" data-toggle="modal"
                                                data-target="#showApproval{{$user->id}}">
                                                <i class="fa fa-eye"> Lihat</i> 
                                            </button>  
                                            @if($user->active == 1)
                                            <button type="button" class="btn btn-primary btn-xs" title="Edit" data-toggle="modal"
                                                data-target="#updateApproval{{$user->id}}">
                                                <i class="fa fa-edit"> Edit</i> 
                                            </button>
                                            @endif
                                             
                                        </td>
                                        <td class="text-center">
                                           
                                            @if($user->active == 5)
                                                <label for="" class="label label-danger">Non-Aktif</label>
                                            @elseif ($user->active == 4)
                                                <label class="label label-info">Aktif</label>
                                            @elseif($user->active == 3)
                                                <label for="" class="label label-warning">Approved</label>
                                            @elseif($user->active == 2)
                                                <label for="" class="label label-primary">Approved</label>
                                            @elseif($user->active == 1)
                                                <button type="button" class="btn btn-success btn-xs" 
                                                title="Approve" data-toggle="modal"
                                                data-target="#approve{{$user->id}}">
                                                    <i class="fa fa-check"> Approve</i> 
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
                                                <div class="row">
                                                <div class="modal-body">
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
                                                            <label for="">No. Telp / Handphone</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                           : {{$user->no_telp}}
                                                           <p class="text-danger"></p>
                                                           <br>
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
                                                        @if($user->active == 5) : <label for="" class="label label-danger">Non-Aktif</label> @endif
                                                        @if($user->active == 4) : <label for="" class="label label-success">Aktif</label> @endif
                                                        @if($user->active == 3) : <label for="" class="label label-info">Menunggu approval IT</label> @endif
                                                        @if($user->active == 2) : <label for="" class="label label-warning">Menunggu approval controller</label> @endif
                                                        @if($user->active == 1) : <label for="" class="label label-danger">Menunggu approval atasan</label> @endif                                    
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
                                                        <div class="col-sm-8">                                                        
                                                                : {{ $user->atasan->name}}                                                            
                                                            <p class="text-danger"></p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="">Cabang</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : @if(!empty($user->cabang_id))
                                                                    {{ $user->cabang->nama_cabang }}
                                                                @else
                                                                    <label class="label label-warning">Belum Diset</label>
                                                                @endif
                                                            <p class="text-danger"></p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="">Departemen</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            : @if(!empty($user->dept_id))
                                                                {{ $user->dept->kode_departemen }}
                                                            @else
                                                                <label class="label label-warning">Belum Diset</label>
                                                            @endif
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
                                                ">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
                                                </div>
                                                
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="updateApproval{{ $user->id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit Data <strong>{{ $user->name }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('approvalpic.update', $user->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('patch') }}
                                                    <div class="modal-body">

                                                    <div class="col-md-6">
                                
                                                            <div class="col-sm-4">
                                                                <label for="">Nama</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Nama" required>
                                                                <p class="text-danger"></p>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="">NIK</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="nik" value="{{ $user->nik }}" class="form-control" placeholder="NIK" required>
                                                                <p class="text-danger"></p>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="">Username</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="username" value="{{ $user->username }}"class="form-control" placeholder="Username" required>
                                                                <p class="text-danger"></p>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="">Email</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email" required>
                                                                <p class="text-danger"></p>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label for="">No. Telp / Handphone</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="no_telp" value="{{ $user->no_telp }}" class="form-control" placeholder="Nomor Telepon / Handphone" required>
                                                                <p class="text-danger"></p>
                                                            </div>                                                        
                                                            
                                                        </div>
                                                        <div class="col-md-6">                                    
                                                                                                                                            
                                                            <div class="col-sm-4">
                                                                <label for="">Jabatan</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="jabatan" value="{{ $user->jabatan }}" class="form-control" placeholder="Jabatan" required>
                                                                <p class="text-danger"></p>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="">Atasan</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                            <select name="atasan_id" class="form-control" data-live-search="true" required>
                                                                    <option value="" disabled>Pilih Atasan</option>
                                                                    @foreach ($karyawan as $atasan)
                                                                    <option value="{{ $atasan->id }}" @if($atasan->id == $user->atasan_id) selected @endif>{{ $atasan->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p class="text-danger"></p>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="">Cabang</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <select name="cabang_id" class="form-control" data-live-search="true" required>
                                                                    <option value="" disabled>Pilih Cabang</option>
                                                                    @foreach ($cabangs as $cabang)
                                                                    <option value="{{ $cabang->id }}" @if($cabang->id == $user->cabang_id) selected @endif>
                                                                    {{ $cabang->nama_cabang }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p class="text-danger"></p>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="">Departemen</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                            <select name="departemen_id" class="form-control" data-live-search="true" required>
                                                                    <option value="" disabled>Pilih Departemen</option>
                                                                    @foreach ($departemens as $departemen)
                                                                    <option value="{{ $departemen->id }}" @if($departemen->id == $user->dept_id) selected @endif>{{ $departemen->nama_departemen }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p class="text-danger"></p>
                                                            </div>
                                                            
                                                            <div class="col-sm-4">                                      
                                                                <label for="">Foto (jpg/png)</label>                                    
                                                            </div>
                                                            <div class="col-sm-8">
                                                                @if(!empty($user->image))
                                                                    <img src="{{ asset('images/profile').'/'.$user->image }}" width="100px" height="100px">
                                                                @else
                                                                    <img src="{{ asset('images/profile/default-profile.jpg') }}" width="100px" height="100px">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                                            
                                                           
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">UPDATE</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                                                        
                                                    </div>
                                                </form>
                                            
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
                                                
                                                <form action="{{ route('approvalpic.approve', $user->id) }}" method="post">
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
                                    @empty
                                    <td colspan="9" class="text-center">
                                        Tidak Ada Permintaan User Akun.
                                    </td>
                                    @endforelse
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
                //untuk menghilangkan order
                { "width": "3%", "targets": 0}
            ],
            });
        });
    </script>
@endsection