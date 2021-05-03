<!doctype html>
<html class="fixed">
  <head>
    <title>SIRUS | Login</title>
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
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/toastr/css/toast.css')}}" >
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/login/theme.css')}}" />
    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('assets/login/skins/default.css')}}" />
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

        <div class="panel panel-sign">
          <div class="panel-title-sign mt-xl text-right">
            <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Login</h2>
          </div>
          <div class="panel-body">
            <form action="{{ route('login') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} mb-lg">
                <label>Username</label>
                <div class="input-group input-group-icon">
                  <input name="username" placeholder="Username" type="text" class="form-control input-lg" value="{{ old('username') }}" autocomplete="username" autofocus/>
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


              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} mb-lg">
                <div class="clearfix">
                  <label class="pull-left">Password</label>
                </div>
                <div class="input-group input-group-icon">
                  <input name="password" type="password" placeholder="Password" class="form-control input-lg" autocomplete="current-password"/>
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

              <div class="row">
                <div class="col-sm-8">
                  <div class="checkbox-custom checkbox-default">
                    <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Remember Me</label>
                  </div>
                </div>
                <div class="col-sm-4 text-right">
                  <button type="submit" class="btn btn-primary hidden-xs">Login</button>
                  <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Login</button>
                </div>
              </div>          
            </form>
            <br>
            <p class="text-center">Belum mempunyai Akun? <a href="{{ route('register') }}">Daftar!</a>
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
    <script src="{{ asset('assets/vendors/toastr/js/toast.js')}}"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="{{asset('assets/login/theme.js')}}"></script>
    
    <!-- Theme Initialization Files -->
    <script src="{{asset('assets/login/theme.init.js')}}"></script>
    <script type="text/javascript">
      @if(Session::has('danger'))
        toastr.error("{{ Session::get('danger') }}");
      @elseif(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
      @elseif(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
      @endif
    </script>
  </body>
</html>