<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <title>PT. Sinar Roda Utama | Cabang Surabaya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- css -->
</head>

<body>
  <div class="container">
    <div class="row">
      <center>
        <img src="{{asset('assets/portal/img/logo.png')}}" alt="" width="600px" height="100px" style="margin-top:25px"/>
      </center>
    </div>
  </div>

  <div class="row">
    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top:50px">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
  
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
  
        <div class="item active">
          <img src="{{ asset('assets/portal/img/slides/nivo/bg-1.jpg')}}" alt="Los Angeles" style="width:100%;">
          <div class="carousel-caption">
            {{-- <h3>Los Angeles</h3>
            <p>LA is always so much fun!</p> --}}
          </div>
        </div>
  
        <div class="item">
          <img src="{{ asset('assets/portal/img/slides/nivo/bg-2.jpg')}}" alt="Chicago" style="width:100%;">
          <div class="carousel-caption">
            {{-- <h3>Chicago</h3>
            <p>Thank you, Chicago!</p> --}}
          </div>
        </div>
      
        <div class="item">
          <img src="{{ asset('assets/portal/img/slides/nivo/bg-3.jpg')}}" alt="New York" style="width:100%;">
          <div class="carousel-caption">
            {{-- <h3>New York</h3>
            <p>We love the Big Apple!</p> --}}
          </div>
        </div>
    
      </div>
  
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
  <br><br>
  <div class="row">
    <div class="col-sm-12 col-lg-12 col-md-12">
      @foreach($link as $row)
        <div class="col-sm-3 col-lg-3 col-md-3" style="margin-top:20px;margin-bottom:20px;">
          <center>
              <a href="{{ $row->link }}" target="blank" >
                <img src="{{ asset('assets/portal/img/link/').'/'.$row->icon}}" alt="{{ $row->icon }}" width="100px" height="100px">
                <h4>{{ $row->nama_aplikasi }}</h4>
                <p>{{ $row->subtitle }}</p>
              </a>
          </center>
        </div>
      @endforeach
    </div>
  </div>

  <footer class="footer" style="background-color: #d6d6d6; margin-top:50px;">
    <div class="container" style="padding-top:20px;padding-bottom:20px;">
      <div class="pull-right hidden-xs">
        Portal <b>SRU SBY</b>
      </div>
      <strong>Copyright © 2019 <a href="#">ITS-SRU-SBY</a>.</strong> All rights reserved.
    </div>
  </footer>
  

        
  <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
