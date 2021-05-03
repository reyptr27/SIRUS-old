@extends('layouts.layout')

@section('title')
    SIRUS | Create User
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Create User
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li><a href="{{ route('users.index') }}">Users</a></li>
        <li class="active"><a href="{{ route('users.create') }}">Add User</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Menambahkan User Baru</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                
                                <div class="col-sm-4">
                                    <label for="">Nama</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" placeholder="Nama">
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">NIK</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="nik" value="{{ old('nik') }}" class="form-control {{ $errors->has('nik') ? 'is-invalid':'' }}" placeholder="NIK">
                                    <p class="text-danger">{{ $errors->first('nik') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Username</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="username" value="{{ old('username') }}"class="form-control {{ $errors->has('username') ? 'is-invalid':'' }}" placeholder="Username">
                                    <p class="text-danger">{{ $errors->first('username') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Email</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" placeholder="Email">
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">No. Telp / Handphone</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="form-control {{ $errors->has('no_telp') ? 'is-invalid':'' }}" placeholder="Nomor Telepon / Handphone">
                                    <p class="text-danger">{{ $errors->first('no_telp') }}</p>
                                    <br>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Password</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Password">
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
                                        <option value="4">Aktif</option>                                     
                                        <option value="5" selected>Tidak Aktif</option>                                      
                                    </select>
                                    <p class="text-danger">{{ $errors->first('active') }}</p>
                                </div>      
                                                     

                                <div class="col-sm-4">
                                    <label for="">Jabatan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="jabatan" class="form-control {{ $errors->has('jabatan') ? 'is-invalid':'' }}" placeholder="Jabatan">
                                    <p class="text-danger">{{ $errors->first('jabatan') }}</p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Atasan</label>
                                </div>
                                <div class="col-sm-8">
                                <select name="atasan_id" class="form-control {{ $errors->has('atasan_id') ? 'is-invalid':'' }} selectpicker" data-live-search="true">
                                        <option value="" disabled selected>Pilih Atasan</option>
                                        @foreach ($users as $atasan)
                                        <option value="{{ $atasan->id }}">{{ $atasan->name }}</option>
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
                                        <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
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
                                        <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger"></p>
                                </div>
                                
                                <div class="col-sm-4">                                      
                                    <label for="">Upload Foto (jpg/png)</label>                                    
                                    <input type="file" class="form-control" name="file" accept="image/png, image/jpeg" >
                                </div>
                                <div class="col-sm-8">
                                    <img src="{{ asset('images/profile/default-profile.jpg') }}" width="100px" height="100px">
                                </div>
                            </div>

                            <div class="col-md-12">

                                <div class="col-sm-5"></div>
                                
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"></i>  SIMPAN
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
@endsection
