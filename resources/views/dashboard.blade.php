@extends('layouts.layout')

@section('title')
    SIRUS | Dashboard
@endsection
    
@section('content')
<div class="content-wrapper">
    <!-- header -->
    <section class="content-header">
    <h1>
        Dashboard <small>Sinar Roda Utama Surabaya</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Dashboard</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">     
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $jumlah_surat_eksternal }}</h3>

                    <p>Surat External</p>
                </div>
                <div class="icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <a href="{{ route('surat.eksternal.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $jumlah_capa }}</h3>

                    <p>CAPA</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-archive-o"></i>
                </div>
                <a href="{{ route('capa.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $jumlah_arsip }}</h3>

                    <p>E - Arsip</p>
                </div>
                <div class="icon">
                    <i class="fa fa-archive"></i>
                </div>
                <a href="{{ route('arsip.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $jumlah_event }}</h3>
                    <p>Event</p>
                </div>
                <div class="icon">
                    <i class="fa fa-newspaper-o"></i>
                </div>
                <a href="{{ route('event.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

         <div class="row">
           <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">User <b style="color: #0088CC;">SIRUS</b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body" style="padding-bottom: 10px">
                        <div class="chart">
                            <canvas class="canvas-chart" id="pieChart"></canvas>
                        </div>

                        <h4 class="pull-right" style="color: #939694;">Total : {{ $totaluser }} user</h4>
                    </div>

                </div>
           </div>

           <div class="col-md-6">
                <div class="box box-primary">
                    
                    <div class="box-header with-border">
                        <h3 class="box-title"> Permintaan <b style="color: #0088CC;">ITS</b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="chart">
                            <canvas class="canvas-chart" id="areaChart"></canvas>
                        </div>
                        <h4 class="pull-left" style="color: #939694;">Periode : {{ $periode->year }}</h4>
                        <h4 class="pull-right" style="color: #939694;">Total : {{ $totalpermintaanit  }} data</h4>

                    </div>
                </div>
                
           </div>
        </div>

       <!-- <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="{{asset('images/sru-putih.png')}}" alt="user image">
                            <span class="username">
                                <a href="#">ITS</a>
                            </span>
                            <span class="description">Sinar Roda Utama Surabaya</span>
                        </div>
                
                        <p align="justify">
                           <strong>Informasi : </strong> Nama aplikasi <strong>Nomor Surat</strong> sekarang berganti menjadi <strong>Surat Keluar</strong>
                        </p><br>
                        
                        <p>Best Regards</p>
                        <p><b style="color: #0088CC;">ITS SRU Surabaya</b></p>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div> -->

        <!-- row -->
        <div class="row">
        <div class="col-md-9">
            <div class="box box-info">
            <div class="box-body" style="min-height: 20vh;">
                <div class="post">
                <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="{{asset('images/sru-putih.png')}}" alt="user image">
                    <span class="username">
                        <a href="#">ITS</a>
                    </span>
                    <span class="description">Sinar Roda Utama Surabaya</span>
                </div>
                <!-- /userblock -->
                <p>
                    Selamat datang sistem informasi SIRUS (Sinar Roda Utama Surabaya).
                </p>
                <p align="justify">SIRUS adalah Sistem Informasi Manajemen (SIM) yang dikembangkan oleh Tim <b>ITS SRU Surabaya</b>. 
                Sistem informasi manajemen ini berisikan berbagai aplikasi yang menunjang otomasi dan manajemen dalam berbagai aspek di PT. Sinar Roda Utama Surabaya. 
                
                </p><br>
                
                <p>Best Regards</p>
                <p><b style="color: #0088CC;">ITS SRU Surabaya</b></p>
                </div>
            </div>
            <!-- /boxbody -->
            </div>
            <!-- /box -->
        </div>
        <!-- col -->
        <div class="col-md-3">
            <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><i style="margin-right: 10px; color: #00A65A;" class="fa fa-phone-square"></i><b>SIRUS</b> Support</h3>
            </div>
            <div class="box-body" style="min-height: 20vh;">
                <div class="user-block">
                <img class="img-circle img-bordered-sm" src="{{asset('images/profile/support.svg')}}" alt="user image">
                <span class="username">
                    <a href="#">Kristia Budi Utomo</a>
                </span>
                <span class="description"><h4 style="margin-top: 0px;">+62 856-4956-3312</h4></span>
                </div>
               
                <!-- /userblock -->
                <div class="user-block">
                <img class="img-circle img-bordered-sm" src="{{asset('images/profile/support.svg')}}" alt="user image">
                <span class="username">
                    <a href="https://reynaldo.netlify.app" target="_blank">Reynaldo Putra Koesmyta</a>
                </span>
                    <a class="description" href="https://wa.me/6287855400002" target="_blank"><h4 style="margin-top: 0px;">+62 878-5540-0002</h4></a>
                </div>
                <!-- /userblock -->
            </div>
            </div>
        </div>

            <div class="col-md-9">
                <div class="box box-danger">
                <div class="box-body" style="min-height: 30vh;">
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="{{asset('images/sru-putih.png')}}" alt="user image">
                            <span class="username">
                                <a href="#">Berita & Info</a>
                            </span>
                            <span class="description">Sinar Roda Utama Surabaya</span>
                        </div>
                    <!-- /userblock --> <hr>
                        <span>
                            <br>
                            <p align="justify">
                            <strong>1. Informasi : </strong> Nama aplikasi <strong>Nomor Surat</strong> sekarang berganti menjadi <strong>Surat Keluar</strong>
                            </p><br>
                        </span>  
                        <br>  
                        <br>
                        <br>             
                        <p>Best Regards</p>
                        <p><b style="color: #0088CC;">ITS SRU Surabaya</b></p>
                    </div>
                </div>
                <!-- /boxbody -->
                </div>
                <!-- /box -->
            </div>

            <div class="col-md-3">
            <div class="box box-success">
            <div class="box-body" style="min-height: 30vh;">
                <div class="post">
                    <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{asset('images/sru-putih.png')}}" alt="user image">
                        <span class="username">
                            <a href="#">Panduan SIRUS</a>
                        </span>
                        <span class="description">Sinar Roda Utama Surabaya</span>
                    </div>
                <!-- /userblock --> <hr>
                    <span>
                        <a href="{{ route('dashboard.downloadpanduanregister') }}">
                            <i class=" fa fa-file-pdf-o"></i>
                            Panduan Registrasi User Baru 
                            <i class=" fa fa-download"></i>
                        </a>
                    </span>                 
                    <hr>                
                    <span>
                        <a href="{{ route('dashboard.downloadpanduanapprove') }}">
                            <i class=" fa fa-file-pdf-o"></i> 
                            Panduan Approval User (registrasi user baru) 
                            <i class=" fa fa-download"></i>
                        </a>
                    </span>
                    <hr>
                    <p>Best Regards</p>
                    <p><b style="color: #0088CC;">ITS SRU Surabaya</b></p>
                </div>
            </div>
            <!-- /boxbody -->
            </div>
            <!-- /box -->
        </div>

        </div>

        <!-- Berita     -->
    </section>
</div>
@endsection

@section('js-extra')
    <script>
        //pie chart
        const labels = {!! json_encode($dept) !!};
        const yValues = {!! json_encode($usercount) !!};
        let countlength = yValues.length;
        
        //console.log(yValues)

        function getRandomColor() { //generates random colours and puts them in string
            var colors = [];
            for (var i = 0; i < countlength; i++) {
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var x = 0; x < 6; x++) {
                color += letters[Math.floor(Math.random() * 16)];
                }
                colors.push(color);
            }
            return colors;
        }
        //console.log(yValues);

        var barColors = getRandomColor();

        new Chart("pieChart", {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: false,
                    text: "User SIRUS"
                },

                segmentShowStroke    : true,
                segmentStrokeColor   : '#fff',
                segmentStrokeWidth   : 2,
                percentageInnerCutout: 50, 
                animationSteps       : 100,
                animationEasing      : 'easeOutBounce',
                animateRotate        : true,
                animateScale         : false,
                responsive           : true,
            }
        });
        //end pie chart

        //area chart
        var ctx = document.getElementById("areaChart").getContext('2d');
        const perbaikan = {!! json_encode($dataperbaikan) !!}; 
        const pengadaan = {!! json_encode($datapengadaan) !!}; 
        const program = {!! json_encode($dataprogram) !!}; 

        //console.log(program)

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Januari",	"Februari",	"Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                datasets: [{
                        label: 'Perbaikan', // Name the series
                        data: perbaikan, // Specify the data values array
                        fill: false,
                        borderColor: '#f56954', // Add custom color border (Line)
                        backgroundColor: '#f56954', // Add custom color background (Points and Fill)
                        borderWidth: 1 // Specify bar border width
                    },

                    {
                        label: 'Pengadaan', // Name the series
                        data: pengadaan, // Specify the data values array
                        fill: false,
                        borderColor: '#00a65a', // Add custom color border (Line)
                        backgroundColor: '#00a65a', // Add custom color background (Points and Fill)
                        borderWidth: 1 // Specify bar border width
                    },

                    {
                        label: 'Program', // Name the series
                        data: program, // Specify the data values array
                        fill: false,
                        borderColor: '#3c8dbc', // Add custom color border (Line)
                        backgroundColor: '#3c8dbc', // Add custom color background (Points and Fill)
                        borderWidth: 1 // Specify bar border width
                    },
                
                ]
            },
            options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
            }
        });
        //end area chart

    </script>
@endsection
