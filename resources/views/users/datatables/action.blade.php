<center>
<a href="{{ route('users.role.list', $id) }}" title="Role" class="btn btn-success btn-xs">
    <i class="fa fa-user"></i> 
</a>
<a href="{{ route('users.permission.list', $id) }}" title="Permission" class="btn btn-warning btn-xs">
    <i class="fa fa-key"></i> 
</a>
<button type="button" class="btn btn-info btn-xs" title="Lihat" data-toggle="modal"
    data-target="#lihatUser{{ $id }}">
    <i class="fa fa-eye"></i> 
</button>
<a href="{{ route('users.edit', $id) }}" title="Edit" class="btn btn-primary btn-xs">
    <i class="fa fa-edit"></i> 
</a>
<button type="button" class="btn btn-danger btn-xs" title="Hapus" data-toggle="modal"
    data-target="#hapusUser{{ $id }}">
    <i class="fa fa-trash"></i> 
</button>
</center>

<div class="modal fade" id="hapusUser{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus user milik <strong>{{ $name }}</strong> ?</h4>
            </div>
            
            <form action="{{ route('users.destroy', $id) }}" method="post">
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

<!-- Modal Lihat -->
<div class="modal fade " id="lihatUser{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail User <strong>{{$name}}</strong> </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-sm-4">
                            <label for="">Nama</label>
                        </div>
                        <div class="col-sm-8">
                            : {{ $name }}
                            <p class="text-danger"></p>
                        </div>

                        <div class="col-sm-4">
                            <label for="">NIK</label>
                        </div>
                        <div class="col-sm-8">
                            : {{ $nik }}
                            <p class="text-danger"></p>
                        </div>

                        <div class="col-sm-4">
                            <label for="">Username</label>
                        </div>
                        <div class="col-sm-8">
                            : {{$username}}
                            <p class="text-danger"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Email</label>
                        </div>
                        <div class="col-sm-8">
                            : {{$email}}
                            <p class="text-danger"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Jabatan</label>
                        </div>
                        <div class="col-sm-8">
                            : {{$jabatan}}
                            <p class="text-danger"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">No. Telp / HP</label>
                        </div>
                        <div class="col-sm-8">
                            : {{$no_telp}}
                            <p class="text-danger"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Tgl Dibuat</label>
                        </div>
                        <div class="col-sm-8">
                            : {{ date('d-m-Y', strtotime($created_at)) }}
                            <p class="text-danger"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-sm-4">
                            <label for="">Status</label>
                        </div>
                        <div class="col-sm-8">
                        @if($active == 5) : <label for="" class="label label-danger">Non-Aktif</label> @endif
                        @if($active == 4) : <label for="" class="label label-success">Aktif</label> @endif
                        @if($active == 3) : <label for="" class="label label-info">Menunggu approval IT</label> @endif
                        @if($active == 2) : <label for="" class="label label-warning">Menunggu approval Controller</label> @endif
                        @if($active == 1) : <label for="" class="label label-warning">Menunggu approval atasan</label> @endif                                    
                            <p class="text-danger"></p>
                        </div>      
                        <div class="col-sm-4">
                            <label for="">Atasan</label>
                        </div>
                        <div class="col-sm-8">
                            : {{ $nama_atasan }}                                                         
                            <p class="text-danger"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Cabang</label>
                        </div>
                        <div class="col-sm-8">
                            : {{ $nama_cabang }}                                                         
                            <p class="text-danger"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Departemen</label>
                        </div>
                        <div class="col-sm-8">
                            : {{ $kode_departemen }} ({{ $nama_departemen }})                                                        
                            <p class="text-danger"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Foto / Gambar</label>                                  
                        </div>
                        <div class="col-sm-8">
                            @if(!empty($image))
                                <img src="{{ asset('images/profile').'/'.$image }}" width="100px" height="100px">
                            @else
                                <img src="{{ asset('images/profile/default-profile.jpg') }}" width="100px" height="100px">
                            @endif 
                        </div>
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                    </div>    
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
            
        
        </div>
    </div>
</div>