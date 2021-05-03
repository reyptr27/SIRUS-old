@extends('layouts.layout')

@section('title')
    SIRUS | CAPA
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Verifikasi CAPA
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">CAPA</a></li>
        <li><a href="#">Verifikasi CAPA</a></li>
        <li class="active"><a href="{{ route('capa.verifikasi.edit', $model->id) }}">Update Verifikasi CAPA</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Verifikasi <strong>{{$model->nomor}}</strong></h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('capa.verifikasi.update',$model->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Tanggal Verifikasi</label>
                                <input name="tgl_verifikasi" type="date" class="form-control" value="{{ $model->tgl_verifikasi }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Pembuktian / Verifikasi</label><small><i> (Penjelasan mengenai penyelesaian masalah / ketidaksesuaian)</i></small>
                                <textarea name="hasil_tindakan" class="form-control" placeholder="Pembuktian / Verifikasi" required>{{ $model->hasil_tindakan }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Catatan</label><small><i> (Apabila terdapat catatan tambahan yang ingin disampaikan)</i></small>
                                <textarea name="catatan" class="form-control" placeholder="Catatan">{{ $model->catatan }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('capa.verifikasi.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection