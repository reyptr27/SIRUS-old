@extends('layouts.layout')

@section('title')
    SIRUS | Surat Masuk
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Surat Masuk
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Nomor Surat</a></li>
        <li><a href="#">Surat Masuk</a></li>
        <li class="active"><a href="{{ route('surat.masuk.create') }}">Tambah Surat Masuk</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Surat Masuk</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('surat.masuk.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Tanggal Terima</label>
                                <input type="date" name="tgl_terima" class="form-control {{ $errors->has('tgl_terima') ? 'is-invalid':'' }}" value="{{ old('tgl_terima') }}" required>
                                <p class="text-danger">{{ $errors->first('tgl_terima') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="">Customer</label>
                                <input type="text" name="customer" placeholder="Nama Customer / Pengirim Surat" class="form-control {{ $errors->has('customer') ? 'is-invalid':'' }}" value="{{ old('customer') }}" required>
                                <p class="text-danger">{{ $errors->first('customer') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="">Nomor Surat Eksternal</label>
                                <input type="text" name="nomor_eksternal" placeholder="Nomor Surat Eksternal" class="form-control {{ $errors->has('nomor_eksternal') ? 'is-invalid':'' }}" value="{{ old('nomor_eksternal') }}" required>
                                <p class="text-danger">{{ $errors->first('nomor_eksternal') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="">Tanggal Surat Eksternal</label>
                                <input type="date" name="tgl_eksternal" class="form-control {{ $errors->has('tgl_eksternal') ? 'is-invalid':'' }}" value="{{ old('tgl_eksternal') }}" required>
                                <p class="text-danger">{{ $errors->first('tgl_eksternal') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="">Hal</label>
                                <input type="text" name="hal" placeholder="Hal" class="form-control {{ $errors->has('hal') ? 'is-invalid':'' }}" value="{{ old('hal') }}" required>
                                <p class="text-danger">{{ $errors->first('hal') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="">Tujuan / Up</label>
                                <select name="up_id" class="form-control selectpicker {{ $errors->has('up_id') ? 'is-invalid':'' }}" data-live-search="true" required>
                                    <option value="" disabled selected>Pilih Tujuan / Up</option>
                                    @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}">{{ $karyawan->name }} - {{ $karyawan->nik }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('up_id') }}</p>
                            </div>
                           
                            <div class="form-group">
                                <label for="">Departemen</label>
                                <select name="dept_id" class="form-control selectpicker {{ $errors->has('dept_id') ? 'is-invalid':'' }}" data-live-search="true" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departemens as $departemen)
                                        <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('dept_id') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="">Perlu Balasan ?</label>
                                <select name="perlu_balasan" class="form-control {{ $errors->has('perlu_balasan') ? 'is-invalid':'' }}" required>
                                    <option value="1">Ya</option>
                                    <option value="2">Tidak</option>
                                </select>
                                <p class="text-danger">{{ $errors->first('perlu_balasan') }}</p>
                            </div>

                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan">{{ old('keterangan') }}</textarea>
                            </div>
                           
                        </div>
                        <div class="modal-footer">                                            
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('surat.masuk.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
