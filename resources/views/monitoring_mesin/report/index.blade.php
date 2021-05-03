@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('css-extra')
<style>
    th { font-size: 13px; }
    td { font-size: 12px; }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Report Monitoring Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.report.index') }}">Report Monitoring Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Report Monitoring Mesin</h3>
                    </div>
                    <form action="{{ route('monitoringmesin.report.filter') }}" method="GET">
                    <div class="box-body">
                        <div class="row">                         
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label for="">Tgl Rekomendasi Awal</label>
                                    <input type="date" name="tgl_awal" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Tgl Rekomendasi Akhir</label>
                                    <input type="date" name="tgl_akhir" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Kategori</label>
                                    <select name="kategori" class="form-control">
                                        <option value="">All</option>
                                        <option value="1">Penambahan</option>
                                        <option value="2">Penggantian</option>
                                        <option value="3">Peminjaman</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Customer</label>
                                    <select name="customer_id" class="form-control selectpicker" data-live-search="true">
                                        <option value="">All</option>
                                        @foreach ($customer as $row)
                                            <option value="{{ $row->id }}">{{ $row->nama_rs }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <button type="submit" name="action" value="filter" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                                    <button type="submit" name="action" value="export" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>   
            </div>
        </div>
    </section>
</div>
@endsection