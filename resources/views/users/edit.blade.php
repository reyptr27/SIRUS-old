@extends('layouts.layout')

@section('title')
    SIRUS | Update User
@endsection

@section('css-extra')
    <link rel="stylesheet" href="{{ asset('assets/vendors/croppie/css/croppie.css') }}">
@endsection
  
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Update User
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li><a href="{{ route('users.index') }}">Users</a></li>
        <li class="active"><a href="#">Update User</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update User <strong>{{ $user->name }}</strong></h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="col-md-6">
                                
                                <div class="col-sm-4">
                                    <label for="">Nama</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" placeholder="Nama">
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">NIK</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="nik" value="{{ $user->nik }}" class="form-control {{ $errors->has('nik') ? 'is-invalid':'' }}" placeholder="NIK">
                                    <p class="text-danger">{{ $errors->first('nik') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Username</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="username" value="{{ $user->username }}"class="form-control {{ $errors->has('username') ? 'is-invalid':'' }}" placeholder="Username">
                                    <p class="text-danger">{{ $errors->first('username') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Email</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" placeholder="Email">
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">No. Telp / Handphone</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="no_telp" value="{{ $user->no_telp }}" class="form-control {{ $errors->has('no_telp') ? 'is-invalid':'' }}" placeholder="Nomor Telepon / Handphone">
                                    <p class="text-danger">{{ $errors->first('no_telp') }}</p>
                                    <br>
                                </div>
                                
                                <div class="col-sm-4">
                                    <label for="">Password</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Password">
                                    <p class="text-warning">Kosongkan jika tidak ingin mengubah password</p>
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Ketik Ulang Password</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Konfirmasi Password">
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                </div>               
                                
                            </div>
                            <div class="col-md-6">
        
                                <div class="col-sm-4">
                                    <label for="">Status</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="active" class="form-control {{ $errors->has('active') ? 'is-invalid':'' }}">
                                        <option value="4" @if($user->active == 4) selected @endif>Aktif</option>                                     
                                        <option value="5" @if($user->active != 4) selected @endif>Tidak Aktif</option>                                      
                                    </select>
                                    <p class="text-danger">{{ $errors->first('active') }}</p>
                                </div>      
                                                     
                                <div class="col-sm-4">
                                    <label for="">Jabatan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="jabatan" value="{{ $user->jabatan }}" class="form-control {{ $errors->has('jabatan') ? 'is-invalid':'' }}" placeholder="Jabatan">
                                    <p class="text-danger">{{ $errors->first('jabatan') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Atasan</label>
                                </div>
                                <div class="col-sm-8">
                                <select name="atasan_id" class="form-control {{ $errors->has('atasan_id') ? 'is-invalid':'' }} selectpicker" data-live-search="true">
                                        <option value="" disabled selected>Pilih Atasan</option>
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
                                    <select name="cabang_id" class="form-control {{ $errors->has('cabang_id') ? 'is-invalid':'' }} selectpicker" data-live-search="true">
                                        <option value="" disabled selected>Pilih Cabang</option>
                                        @foreach ($cabangs as $cabang)
                                        <option value="{{ $cabang->id }}" @if($cabang->id == $user->cabang_id) selected @endif>{{ $cabang->nama_cabang }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Departemen</label>
                                </div>
                                <div class="col-sm-8">
                                <select name="departemen_id" class="form-control {{ $errors->has('departemen_id') ? 'is-invalid':'' }} selectpicker" data-live-search="true">
                                        <option value="" disabled selected>Pilih Departemen</option>
                                        @foreach ($departemens as $departemen)
                                        <option value="{{ $departemen->id }}" @if($departemen->id == $user->dept_id) selected @endif>{{ $departemen->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger"></p>
                                </div>
                                
                                <div class="col-sm-4 col-md-4">                                      
                                    <label for="">Upload Foto (jpg/png)</label>                                    
                                    <input type="file" class="form-control" name="upload_image" id="upload_image" accept="image/png, image/jpeg" >
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <div id="exist_image">
                                        @if(!empty($user->image))
                                            <img src="{{ asset('images/profile').'/'.$user->image }}" width="150px" height="150px">
                                        @else
                                            <img src="{{ asset('images/profile/default-profile.jpg') }}" width="150px" height="150px">
                                        @endif
                                    </div>
                                    <div id="uploaded_image"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-sm-5"></div>
                            
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="fa fa-send"></i>  UPDATE
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>  BATAL
                                    </a>
                                </div>

                            </div>
                            
                        </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>

<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload & Crop Foto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <center>
                        <div id="image_demo" style="width:350px; margin-top:30px"></div>
                        </center>
                        <button class="btn btn-success crop_image">Crop & Upload Foto</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </center>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-extra')
<script src="{{ asset('assets/vendors/croppie/js/croppie.js') }}"></script>
<script>  
    $(document).ready(function(){

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width:200,
            height:200,
            type:'square' //circle
        },
        boundary:{
            width:300,
            height:300
        }
    });

    $('#upload_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('.crop_image').click(function(event){
        console.log("click");
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response){
            var _token = $('input[name=_token]').val();
            $.ajax({
                url:"{{ route('profile.imageUpload', $user->id) }}",
                type:"POST",
                data:{ "image": response, _token:_token },
                dateType: "json",
                success:function(data){
                    console.log(data)
                    $('#uploadimageModal').modal('hide');
                    $('#exist_image').remove();
                    var crop_image = `<img src="{{ asset('${data.path}') }}" width="150px" height="150px"/>`;
                    $('#uploaded_image').html(crop_image);
                }, error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        })
    });

    });  
</script>
@endsection
