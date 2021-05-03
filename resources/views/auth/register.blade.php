<!doctype html>
<html class="fixed">
  <head>
    <title>SIRUS | Registrasi</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png')}}">
    <!-- Basic -->
    <meta charset="UTF-8">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/bootstrap-select.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/bootstrap-select.min.css')}}" >
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/login/theme.css')}}" />
    <!-- Theme Custom -->
    <link rel="stylesheet" href="{{asset('assets/login/theme-custom.css')}}" />
    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('assets/login/skins/default.css')}}" />\
    <style>
        body{
            background: url("{{asset('assets/images/nipro.jpg')}}");
            background-size:cover;
            background-attachment: fixed;
        }
    </style>
  </head>
  <body>
    <!-- start: page -->
    <section class="body-sign">
      <div class="center-sign">
        <a href="{{ url('/') }}" class="logo pull-left">
          <img src="{{asset('assets/images/sru-logo.png')}}" height="54" />
        </a>

        <div class="panel panel-sign panel-xl">
          <div class="panel-title-sign mt-xl text-right">
            <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Registrasi</h2>
          </div>
          <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info" role="alert">
                        <div class="text-center"><strong>STEP REGISTRASI :</strong></div>
                        <p>
                            1. Lengkapi semua isian form di bawah ini.<br>
                            2. Setelah semua form sudah terisi silahkan centang persetujuan tanggung jawab. <br>
                            3. Tekan tombol register untuk meregistrasi akun Anda. <br>
                            4. Silahkan menginfokan ke atasan Anda untuk melakukan approval agar akun Anda dapat diaktivasi.  
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('register') }}" method="post">
                {{ csrf_field() }}
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} mb-lg">
                                <label>Nama Lengkap</label>
                                <div class="input-group input-group-icon">
                                <input name="name" placeholder="Nama Lengkap" type="text" class="form-control input-lg" value="{{ old('name') }}"/>
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                    <i class="fa fa-id-card"></i>
                                    </span>
                                </span>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} mb-lg">
                                <label>Username</label>
                                <div class="input-group input-group-icon">
                                <input name="username" placeholder="Username" type="text" class="form-control input-lg" value="{{ old('username') }}"/>
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                    <i class="fa fa-user"></i>
                                    </span>
                                </span>
                                </div>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mb-lg">
                                <div class="clearfix">
                                <label class="pull-left">Email</label>
                                </div>
                                <div class="input-group input-group-icon">
                                <input name="email" type="email" placeholder="Email" class="form-control input-lg" value="{{ old('email') }}"/>
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                    <i class="fa fa-envelope"></i>
                                    </span>
                                </span>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} mb-lg">
                                <div class="clearfix">
                                <label class="pull-left">Password</label>
                                </div>
                                <div class="input-group input-group-icon">
                                <input name="password" type="password" placeholder="Password" class="form-control input-lg"/>
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                    <i class="fa fa-lock"></i>
                                    </span>
                                </span>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                <label class="pull-left">Konfirmasi Password</label>
                                </div>
                                <div class="input-group input-group-icon">
                                <input name="password_confirmation" id="password-confirm" type="password" placeholder="Password" class="form-control input-lg"/>
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                    <i class="fa fa-lock"></i>
                                    </span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- /col-md-6 -->
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }} mb-lg">
                                <label>NIK</label>
                                <div class="input-group input-group-icon">
                                <input name="nik" placeholder="NIK" type="text" class="form-control input-lg" value="{{ old('nik') }}"/>
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                    <i class="fa fa-address-book-o"></i>
                                    </span>
                                </span>
                                </div>
                                @if ($errors->has('nik'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nik') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <div class="form-group{{ $errors->has('no_telp') ? ' has-error' : '' }} mb-lg">
                                <label>No. Telepon / HP</label>
                                <div class="input-group input-group-icon">
                                <input name="no_telp" placeholder="Nomor Telepon / Handphone" type="text" class="form-control input-lg" value="{{ old('no_telp') }}"/>
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                    <i class="fa fa-phone"></i>
                                    </span>
                                </span>
                                </div>
                                @if ($errors->has('no_telp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('no_telp') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group{{ $errors->has('jabatan') ? ' has-error' : '' }} mb-lg">
                                <label>Jabatan</label>
                                <div class="input-group input-group-icon">
                                <input name="jabatan" placeholder="Jabatan" type="text" class="form-control input-lg" value="{{ old('jabatan') }}"/>
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                    <i class="fa fa-briefcase"></i>
                                    </span>
                                </span>
                                </div>
                                @if ($errors->has('jabatan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jabatan') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('dept_id') ? ' has-error' : '' }} mb-lg">
                                <label>Departemen</label>
                                <select name="dept_id" class="form-control input-lg" style="font-size:12px;">
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departemen as $dept)
                                        <option value="{{ $dept->id }}" style="font-size:12px;">{{ $dept->nama_departemen }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('dept_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dept_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('atasan_id') ? ' has-error' : '' }} mb-lg">
                                <label>Atasan Langsung</label>
                                <select name="atasan_id" class="form-control input-lg" style="font-size:12px;">
                                <option value="" disabled selected>Pilih Atasan</option>
                                    @foreach($atasan as $ats)
                                        <option value="{{ $ats->id }}" style="font-size:12px;">{{ $ats->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('atasan_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('atasan_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /col-md-6 -->
                    </div>
                    <!-- /col-md-12 -->
                </div>
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <input type="checkbox" id="toggle"/>
                        <span style="font-size:14px;">Saya menyetujui dan akan bertanggung jawab atas akun ini sesuai dengan ketentuan perusahaan.</span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" id="submit_button" class="btn btn-primary hidden-xs" disabled>Register</button>
                        <button type="submit" id="submit_button" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Register</button>
                    </div>
                </div>          
            </form>
            <br>
            <p class="text-center">Sudah memiliki Akun? <a href="{{ route('login') }}">Login!</a>
            </p>
          </div>
        </div>

        <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2020. All rights reserved. Design by <a href="#">ITS SRU SBY</a>.</p>
      </div>
    </section>
    <!-- end: page -->

    <!-- Vendor -->
    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/bootstrap-select.js')}}"></script>
    <script src="{{ asset('assets/dist/js/bootstrap-select.min.js')}}"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="{{asset('assets/login/theme.js')}}"></script>
    
    <!-- Theme Initialization Files -->
    <script src="{{asset('assets/login/theme.init.js')}}"></script>
    <script type="text/javascript">
        $('#toggle').click(function () {
            if ($(this).is(':checked')) {
                $('#submit_button').removeAttr('disabled');
            } else {
                $('#submit_button').attr('disabled', true); //disable input
            }
        });
    </script>
  </body>
</html>