@extends('layouts.layout')

@section('title')
    SIRUS | Surat Eksternal
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Surat Eksternal
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Surat Keluar</a></li>
        <li><a href="#">Surat Eksternal</a></li>
        <li class="active"><a href="{{ route('surat.eksternal.edit', $surat->id) }}">Update Surat Eksternal</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Surat Eksternal <strong>{{ $surat->no_surat }}</strong></h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('surat.eksternal.update', $surat->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Tujuan</label>
                                <select name="tujuan_id" class="form-control selectpicker {{ $errors->has('tujuan_id') ? 'is-invalid':'' }}" data-live-search="true">
                                    <option value="" disabled selected>Pilih Tujuan / UP</option>
                                    @foreach($tujuans as $tujuan)
                                        <option value="{{ $tujuan->id }}" @if($tujuan->id == $surat->tujuan_id) selected @endif>{{ $tujuan->nama_tujuan }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('tujuan_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Cabang</label>
                                <select name="cabang_id" class="form-control selectpicker {{ $errors->has('cabang_id') ? 'is-invalid':'' }}" data-live-search="true" disabled>
                                    <option value="" disabled selected>Pilih Cabang</option>
                                    @foreach($cabangs as $cabang)
                                        <option value="{{ $cabang->id }}" @if($cabang->id == $surat->cabang_id) selected @endif>{{ $cabang->nama_cabang }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('cabang_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <select name="dept_id" class="form-control selectpicker {{ $errors->has('dept_id') ? 'is-invalid':'' }}" data-live-search="true" disabled>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departemens as $departemen)
                                        <option value="{{ $departemen->id }}" @if($departemen->id == $surat->dept_id) selected @endif>{{ $departemen->nama_departemen }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('dept_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan">{{ $surat->keterangan }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">                                            
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <a href="{{ route('surat.eksternal.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
