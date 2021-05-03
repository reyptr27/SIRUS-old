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
        <li><a href="#">Nomor Surat</a></li>
        <li><a href="#">Surat Eksternal</a></li>
        <li class="active"><a href="{{ route('surat.eksternal.create') }}">Tambah Surat Eksternal</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Surat Eksternal</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('surat.eksternal.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Tujuan</label>
                                <select name="tujuan_id" class="form-control selectpicker {{ $errors->has('tujuan_id') ? 'is-invalid':'' }}" data-live-search="true">
                                    <option value="" disabled selected>Pilih Tujuan / UP</option>
                                    @foreach($tujuans as $tujuan)
                                        <option value="{{ $tujuan->id }}">{{ $tujuan->nama_tujuan }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('tujuan_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Cabang</label>
                                <select name="cabang_id" class="form-control selectpicker {{ $errors->has('cabang_id') ? 'is-invalid':'' }}" data-live-search="true">
                                    <option value="" disabled selected>Pilih Cabang</option>
                                    @foreach($cabangs as $cabang)
                                        <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('cabang_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <select name="dept_id" class="form-control selectpicker {{ $errors->has('dept_id') ? 'is-invalid':'' }}" data-live-search="true">
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departemens as $departemen)
                                        <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('dept_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan">{{ old('keterangan') }}</textarea>
                            </div>
                            <?php $user = Auth()->user(); ?>
                            <input type="hidden" name="created_by" value="{{ $user->id }}">
                        </div>
                        <div class="modal-footer">                                            
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
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
