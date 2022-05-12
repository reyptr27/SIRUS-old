@extends('layouts.layout')

@section('title')
    SIRUS | Surat Internal HD
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Surat Internal HD
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Surat Keluar</a></li>
        <li><a href="#">Surat Internal HD</a></li>
        <li class="active"><a href="{{ route('surat.hd.index', $surat->id) }}">Update Surat Internal HD</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Surat {{ $surat->no_surat }}</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('surat.hd.update', $surat->id) }}" method="post">
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
                                <label for="">Kategori</label>
                                <select name="kategori_id" class="form-control selectpicker {{ $errors->has('kategori_id') ? 'is-invalid':'' }}" data-live-search="true">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" @if($kategori->id == $surat->kategori_id) selected @endif>{{ $kategori->kategori }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('kategori_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan">{{ $surat->keterangan }}</textarea>
                            </div>
                            <?php $user = Auth()->user(); ?>
                            <input type="hidden" name="created_by" value="{{ $user->id }}">
                        </div>
                        <div class="modal-footer">                                            
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('surat.hd.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
