@extends('layouts.layout')

@section('title')
    SIRUS | Ganti Password
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Ganti Password
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('profile.update', $user->id) }}">Update Profile</a></li>
        <li class="active"><a href="#">Ganti Password</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-info">
                    <div class="box-header with-border text-center bg-blue">
                        <h3 class="box-title">Ganti password user <strong>{{ $user->name }}</strong></h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('profile.password.update', $user->id) }}" method="post">
                            @csrf
                            {{ method_field('PATCH') }}

                            <div class="col-md-12">
                                <div class="col-sm-6 text-right">
                                    <label for="">Password Lama</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="current_password" class="form-control {{ $errors->has('current_password') ? 'is-invalid':'' }}" placeholder="Password">
                                    <p class="text-danger">{{ $errors->first('current_password') }}</p>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <label for="">Password Baru</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Password">
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <label for="">Ketik Ulang Password Baru</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Konfirmasi Password">
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                </div>            
                            
                            </div>
                            
                            
                            <div class="col-md-12 text-center">
                                
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="fa fa-send"></i>  UPDATE
                                </button>
                                <a href="{{ route('profile.edit',$user->id) }}" class="btn btn-danger btn-sm">
                                    <i class="fa fa-close"></i>  BATAL
                                </a>
                            </div>
                            
                        </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection

