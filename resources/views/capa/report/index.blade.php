@extends('layouts.layout')

@section('title')
    SIRUS | CAPA
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
        CAPA (Corrective Action Preventive Action)
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">CAPA</a></li>
        <li class="active"><a href="{{ route('capa.report.index') }}">Report</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Report CAPA</h3>
                    </div>
                    <form action="{{ route('capa.report.filter') }}" method="GET">
                    <div class="box-body">
                        <div class="row">                         
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" name="tgl_awal" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" name="tgl_akhir" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Lokasi</label>
                                    <select name="lokasi_id" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($lokasi as $row)
                                            <option value="{{ $row->id }}">{{ $row->lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Departemen</label>
                                    <select name="dept_id" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($dept as $row)
                                            <option value="{{ $row->id }}">{{ $row->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <button type="submit" name="action" value="filter" class="btn btn-primary"><i class="fa fa-filter"></i> Filter Data</button>
                                    <button type="submit" name="action" value="excel" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                                    <button type="submit" name="action" value="pdf" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export to PDF</button>
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