@extends('layouts.layout')

@section('title')
    SIRUS | Manajemen Arsip
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Manajemen Arsip
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Arsip</a></li>
        <li class="active"><a href="{{ route('arsip.create') }}">Tambah Arsip</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Arsip</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('arsip.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Jenis Arsip</label>
                                <select name="jenis_id" class="form-control selectpicker {{ $errors->has('jenis_id') ? 'is-invalid':'' }}" data-live-search="true">
                                    <option value="" disabled selected>Pilih Jenis Arsip</option>
                                    @foreach($jenis as $row)
                                        <option value="{{ $row->id }}">{{ $row->jenis_arsip }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('jenis_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor</label>
                                <input type="text" name="nomor" class="form-control {{ $errors->has('nomor') ? 'is-invalid':'' }}" value="{{ old('nomor') }}" placeholder="Nomor Arsip">
                                <p class="text-danger">{{ $errors->first('nomor') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Arsip</label>
                                <input type="date" name="tgl_arsip" class="form-control {{ $errors->has('tgl_arsip') ? 'is-invalid':'' }}" value="{{ old('tgl_arsip') }}">
                                <p class="text-danger">{{ $errors->first('tgl_arsip') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Arsip</label>
                                <input type="text" name="nama_arsip" class="form-control {{ $errors->has('nama_arsip') ? 'is-invalid':'' }}" value="{{ old('nama_arsip') }}" placeholder="Nama Arsip">
                                <p class="text-danger">{{ $errors->first('nama_arsip') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" placeholder="Deskripsi">{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">File Arsip</label>
                                <input type="file" name="upload_file" class="form-control {{ $errors->has('upload_file') ? 'is-invalid':'' }}" value="{{ old('upload_file') }}" 
                                accept="image/png, image/jpeg, application/pdf, application/msword, application/vnd.ms-powerpoint,application/vnd.ms-excel,
                                        application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation
                                ">
                                <p class="text-danger">{{ $errors->first('upload_file') }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">                                            
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('arsip.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
