@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Tipe Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.tipe.edit', $model->id) }}">Update Tipe Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Tipe Mesin {{ $model->tipe }}</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('monitoringmesin.tipe.update', $model->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Jenis Mesin</label>
                                <select name="jenis_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jenis Mesin</option>
                                    @foreach ($jenis as $row)
                                        <option value="{{ $row->id }}" @if($row->id == $model->jenis_id) selected @endif>{{ $row->jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Mesin</label>
                                <input type="text" name="tipe" class="form-control" placeholder="Tipe Mesin" value="{{ $model->tipe }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('monitoringmesin.tipe.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
