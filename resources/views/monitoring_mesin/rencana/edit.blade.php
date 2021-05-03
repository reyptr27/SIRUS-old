@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('css-extra')
    <link rel="stylesheet" href="{{asset('assets/vendors/select2/css/select2.min.css')}}"/>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Rencana Pengiriman dan Instalasi Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.rencanapengiriman.edit', $header->id) }}">Update Rencana Pengiriman dan Instalasi Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Rencana Pengiriman dan Instalasi Mesin {{ $header->nomor }}</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('monitoringmesin.rencanapengiriman.update', $header->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Tanggal Rencana Pengiriman</label>
                                <input type="date" name="tgl_plan_kirim" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Rencana Instalasi</label>
                                <input type="date" name="tgl_plan_instalasi" class="form-control" required>
                            </div>
                        </div>
                        <div class="box-footer">                           
                            <button type="submit" title="Submit" class="btn btn-primary">
                                <i class="fa fa-send"></i> UPDATE
                            </button>
                            <a href="{{ route('monitoringmesin.rencanapengiriman.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
