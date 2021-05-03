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
                <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>4734</h3>

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
                    <h3>160</h3>

                    <p>CAPA</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-archive-o"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                <div class="small-box bg-red">
                <div class="inner">
                    <h3>292</h3>
                    <p>News</p>
                </div>
                <div class="icon">
                    <i class="fa fa-newspaper-o"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <!-- row -->
        <div class="row">
        <div class="col-md-9">
            <div class="box box-info">
            <div class="box-body">
                <div class="post">
                <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="{{asset('images/sru-putih.png')}}" alt="user image">
                    <span class="username">
                        <a href="#">IT Support</a>
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
                <p><b>ITS SRU Surabaya</b></p>
                </div>
            </div>
            <!-- /boxbody -->
            </div>
            <!-- /box -->
        </div>
        <!-- col -->
        <div class="col-md-3">
            <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Contact IT Support</h3>
            </div>
            <div class="box-body">
                <div class="user-block">
                <img class="img-circle img-bordered-sm" src="{{asset('images/profile/default-profile.jpg')}}" alt="user image">
                <span class="username">
                    <a href="#">Kristia Budi Utomo</a>
                </span>
                <span class="description"><h4>+62 856-4956-3312</h4></span>
                </div>
                <!-- /userblock -->
                <div class="user-block">
                <img class="img-circle img-bordered-sm" src="{{asset('images/profile/default-profile.jpg')}}" alt="user image">
                <span class="username">
                    <a href="#">Liztrianto Pujo Hardhiko</a>
                </span>
                <span class="description"><h4>+62 822-3553-3312</h4></span>
                </div>
                <!-- /userblock -->
                <div class="user-block">
                <img class="img-circle img-bordered-sm" src="{{asset('images/profile/default-profile.jpg')}}" alt="user image">
                <span class="username">
                    <a href="#">Nuzulul Mas'ud</a>
                </span>
                <span class="description"><h4>+62 857-8440-6018</h4></span>
                </div>
                <!-- /userblock -->
            </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="box box-info">
            <div class="box-body">
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
                <p><b>ITS SRU Surabaya</b></p>
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
