<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png')}}">
    <title>Absensi Event {{ $event->nama_event }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/toastr/css/toast.css')}}" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        .tombol{
            text-align: center;
            font-weight: bold;
            padding: 2% 0;
            margin: 5px 5px 5px;
            font-size: 20px;
            border-radius: 50%;
            box-shadow: 1px 1px 1px 1px #222;
	        height: 20%;
            width: 20%;
        }
        .screen{
            text-align: right;
        }
        
    </style>
</head>

<body style="background-color:#ecf0f5;">
    <?php 
        $daftar_hari = array(
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        );
        $namahari = date('l', strtotime($event->tanggal));
    ?>
    <section class="content-header">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-2 col-md-offset-3">
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <a href="{{ route('event.index') }}" class="btn btn-danger" title="Back"><i class="fa fa-backward"></i> Kembali</a>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <button onClick="refresh()" class="btn btn-info pull-right" title="Refresh"><i class="fa fa-refresh"></i> Refresh</button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border text-center">
                        <h1 class="box-title"><strong>{{ $event->nama_event }}</strong></h1>
                    </div>
                    <div class="box-body">
                        <table width="100%" style="margin-left:25px;">
                            <tr>
                                <td width="30%"><b>Hari / Tanggal</b></td>
                                <td>:</td>
                                <td>{{ $daftar_hari[$namahari] }}, {{ date('d-m-Y',strtotime($event->tanggal)) }}</td>
                            </tr>
                            <tr>
                                <td><b>Jenis Event</b></td>
                                <td>:</td>
                                <td>
                                    @if($event->jenis_event == 1)
                                        Briefing
                                    @elseif($event->jenis_event == 2)
                                        Meeting
                                    @elseif($event->jenis_event == 3)
                                        Training
                                    @else
                                        Lain-lain
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b>Lokasi</b></td>
                                <td>:</td>
                                <td>{{ $event->lokasi }}</td>
                            </tr>
                        </table>
                        
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div class="input-group margin">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default">NIK</button>
                                </div>
                                <input type="text" name="nik" class="form-control screen" id="viewer" style="font-size:20px" readonly>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-2 col-md-2 text-center">
                            <button type="button" class="btn btn-primary" id="submit-btn" style="margin-top:10px;">SUBMIT</button>
                        </div>
                        
                        <div class="col-xs-8 col-sm-8 col-md-8 text-center">
                            <input type="button" class="btn btn-default tombol" value="7" onClick="view('7')">
                            <input type="button" class="btn btn-default tombol" value="8" onClick="view('8')">
                            <input type="button" class="btn btn-default tombol" value="9" onClick="view('9')">
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8 text-center">
                            <input type="button" class="btn btn-default tombol" value="4" onClick="view('4')">
                            <input type="button" class="btn btn-default tombol" value="5" onClick="view('5')">
                            <input type="button" class="btn btn-default tombol" value="6" onClick="view('6')">
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8 text-center">
                            <input type="button" class="btn btn-default tombol" value="1" onClick="view('1')">
                            <input type="button" class="btn btn-default tombol" value="2" onClick="view('2')">
                            <input type="button" class="btn btn-default tombol" value="3" onClick="view('3')">
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8 text-center">
                            <input type="button" class="btn btn-default tombol" value="C" onClick="hapus()">
                            <input type="button" class="btn btn-default tombol" value="0" onClick="view('0')">
                            <button class="btn btn-default tombol" onClick="backspace()"><i class="fa fa-arrow-left"></i></button>
                        </div>

                        <div class="col-md-12 col-xs-12 col-sm-12 text-center" style="margin-top:50px;"><strong>Copyright &copy; 2020 <a href="#">ITS-SRU-SBY</a>.</strong> All rights reserved.</div>
                    </div>
                </div>   
            </div>
        </div>     
    </section>

    <div class="modal fade" id="modalAbsensiCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Absensi Event</h4>
                </div>
                <form action="{{ route('absensi.store', $event->id) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="input" id="nama" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">NIK</label>
                            <input type="input" id="nik" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Departemen</label>
                            <input type="input" id="dept" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <center>                                     
                        <button type="submit" class="btn btn-success btn-lg">MASUK</button>
                        </center>    
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalAbsensiUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Absensi Event</h4>
                </div>
                <form action="{{route('absensi.update', $event->id)}}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="modal-body">
                        <input type="hidden" id="log_id" name="log_id">
                        <input type="hidden" id="update_user_id" name="user_id">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="input" id="update_nama" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">NIK</label>
                            <input type="input" id="update_nik" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Departemen</label>
                            <input type="input" id="update_dept" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Waktu Masuk / Login</label>
                            <input type="input" id="in" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <center>                                     
                        <button type="submit" class="btn btn-danger btn-lg">KELUAR</button>
                        </center>    
                    </div>
                </form>
            </div>
        </div>
    </div>
  

  <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
  <!-- <script src="{{ asset('assets/moment/moment.js') }}"></script> -->
  <script type="text/javascript" src="{{ asset('assets/vendors/toastr/js/toast.js')}}"></script>
  <script type="text/javascript">
    toastr.options = {
        "debug": false,
        "positionClass": "toast-bottom-full-width",
        "onclick": null,
        "fadeIn": 300,
        "fadeOut": 1000,
        "timeOut": 2000,
        "extendedTimeOut": 1000
    }
    @if(Session::has('danger'))
      toastr.error("{{ Session::get('danger') }}");
    @elseif(Session::has('warning'))
      toastr.warning("{{ Session::get('warning') }}");
    @elseif(Session::has('success'))
      toastr.success("{{ Session::get('success') }}");
    @endif
  </script>
    <script>
        function view(val) {
            document.getElementById("viewer").value += val;
        }

        function hapus(){
            document.getElementById("viewer").value = "";
        }

        function refresh(){
            document.getElementById("viewer").value = "";
            window.location.reload();
        }

        function backspace(){
            var value = document.getElementById("viewer").value;
            document.getElementById("viewer").value = value.substr(0, value.length - 1);
        }

        $(function () {
            $('#submit-btn').click(function(){
                var nik = $('#viewer').val();
                var token = $("input[name='_token']").val();                          
                console.log(nik);
                console.log(token);
                $.ajax({
                    url: "{{ route('event.absensi.getKaryawan',$event->id)}}",
                    method: 'POST',
                    data: {nik:nik, _token:token},
                    success: function(data) {
                        if ($.isEmptyObject(data.user)){
                            toastr.error("NIK tidak aktif / belum terdaftar");
                        }else{   
                            console.log(data);
                            if ($.isEmptyObject(data.log)){
                                $('#modalAbsensiCreate').modal('show');
                                $('#user_id').val(data.user.id);
                                $('#nama').val(data.user.nama);
                                $('#nik').val(data.user.nik);
                                $('#dept').val(data.user.dept);
                            }else{
                                if(data.log.out == null){
                                    $('#modalAbsensiUpdate').modal('show');
                                    $('#log_id').val(data.log.id);
                                    $('#update_user_id').val(data.user.id);
                                    $('#update_nama').val(data.user.nama);
                                    $('#update_nik').val(data.user.nik);
                                    $('#update_dept').val(data.user.dept);
                                    $('#in').val(data.log.in);
                                }else{
                                    toastr.warning("Anda sudah keluar / logout dari event"); 
                                }
                            }
                        }
                    },error:function(){
                        toastr.error("NIK tidak aktif / belum terdaftar");
                    }
                });
            }); 
        });
        
    </script>
</body>
</html>
