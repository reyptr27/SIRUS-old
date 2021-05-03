<!-- untuk notifikasi  -->
<?php
    use App\User; use App\Models\Surattugas\Surat_Tugas;
    use App\Models\CAPA\CAPA;

    $auth = Auth::user();
    $a = User::where(['atasan_id' => $auth->id, 'active' => 1])->get();
    $jumlah_user = count($a);

    $b = User::where(['active' => 2])->get();
    $jumlah_approve = count($b);

    $c = User::where(['active' => 3])->get();
    $jumlah_controller = count($c);

    $st = Surat_Tugas::where(['approval' => 1])->get();
    $jml_st = count($st);

    $capa = CAPA::where(['verifikator_id' => $auth->id, 'status' => 1])->get();
    $jumlah_capa = count($capa);
?> 
<!-- end untuk notifikasi -->

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
        <div class="pull-left image">
            <?php $image = Auth::user()->image; ?>
            @if(!empty($image))
                <img src="{{ asset('images/profile').'/'.$image }}" class="img-circle" alt="User Image">
            @else
                <img src="{{ asset('images/profile/default-profile.jpg') }}" class="img-circle" alt="User Image">
            @endif
        </div>
        <div class="pull-left info">
            <p>{{ Auth()->user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ set_active('dashboard') }}">
                <a href="{{ url('/')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                    <small class="label pull-right bg-green">Hot</small>
                    </span>
                </a>
            </li>

            @include('layouts.sidebar.berita-acara')
            @include('layouts.sidebar.capa')
            @include('layouts.sidebar.nomorsurat')
            @include('layouts.sidebar.formulirhrd')
            @include('layouts.sidebar.surattugas')
            @include('layouts.sidebar.earsip')    
            @include('layouts.sidebar.event') 
            @include('layouts.sidebar.monitoring-mesin')
            @include('layouts.sidebar.maintenance-cctv') 
            @include('layouts.sidebar.permintaan-it')
            @include('layouts.sidebar.telegram')
            @include('layouts.sidebar.manualbook')
            
            <!-- DATA MASTER -->
            @include('layouts.sidebar.data-master') 
            @include('layouts.sidebar.approval-pic') 
            @include('layouts.sidebar.approval-controller')            
        
        
        </ul>
        <!-- /sidebar menu -->
    </section>
    <!-- /.sidebar -->
</aside>