<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png')}}">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/toastr/css/toast.css')}}" >
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/bootstrap-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/css/datepicker3.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendors/select2/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('css-extra')
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    @include('layouts.header')
    @include('layouts.sidebar')
    @yield('content')
    @include('layouts.footer')
  </div>

  <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
  <!-- <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script> -->
  <script type="text/javascript" src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>
  <script src="{{ asset('assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/fastclick/lib/fastclick.js') }}"></script>
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/vendors/toastr/js/toast.js')}}"></script>
  <script src="{{ asset('assets/dist/js/bootstrap-select.js')}}"></script>
  <script src="{{ asset('assets/vendors/select2/js/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/chart.js/Chart.bundle.min.js') }}"></script>

  <script type="text/javascript">
    @if(Session::has('danger'))
      toastr.error("{{ Session::get('danger') }}");
    @elseif(Session::has('warning'))
      toastr.warning("{{ Session::get('warning') }}");
    @elseif(Session::has('success'))
      toastr.success("{{ Session::get('success') }}");
    @endif
  </script>
  <script>
    $(document).ready(function () {
      $('.sidebar-menu').tree();
      $('.select2').select2();
    })

    $('img').attr('draggable', 'false');

    $('img').bind('contextmenu', function(e) {
      return false;
    });

    $('.canvas-chart').attr('draggable', 'false');

    $('.canvas-chart').bind('contextmenu', function(e) {
      return false;
    });
    
  </script>
  @yield('js-extra')
  @stack('stack-script')
</body>
</html>
