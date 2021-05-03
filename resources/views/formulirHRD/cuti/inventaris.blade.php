@extends('layouts.layout')

@section('title')
    SIRUS | Formulir Cuti
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Formulir Cuti
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Formulir HRD</a></li>
        <li><a href="{{ route('hrd.cuti.index') }}">Formulir Cuti</a></li>
        <li class="active"><a href="{{ route('hrd.cuti.inventaris', $form->id) }}">Serah Terima Inventaris</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Formulir Serah Terima Inventaris <strong>{{ $form->id }}</strong></h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('hrd.cuti.inventarisstore', $form->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Jenis Kendaraan</label>
                            <input type="text" name="jenis_kendaraan" id="jenis_kendaraan" class="form-control" placeholder="Jenis Kendaraan" @if(!empty($inventaris)) value="{{ $inventaris->jenis_kendaraan }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Kendaraan</label>
                                <input type="text" name="nomor_kendaraan" id="nik" class="form-control" placeholder="Nomor Kendaraan" @if(!empty($inventaris)) value="{{ $inventaris->nomor_kendaraan }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="">Kunci & STNK <i>(Ada / Tidak)</i></label>
                                <select name="kunci_stnk" class="form-control" required>
                                    <option value="" disabled selected>Pilih ...</option>
                                    <option value="1" @if(!empty($inventaris)) @if($inventaris->kunci_stnk == 1) selected @endif @endif>Ada</option>
                                    <option value="2" @if(!empty($inventaris)) @if($inventaris->kunci_stnk == 2) selected @endif @endif>Tidak ada</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Rencana Diserahkan Tanggal</label>
                                <input type="date" name="tgl_serah" class="form-control" @if(!empty($inventaris)) value="{{ $inventaris->tgl_serah }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="">Rencana Lokasi Penyerahan</label>
                                <input type="text" name="lokasi_serah" class="form-control" placeholder="Rencana Lokasi Penyerahan" @if(!empty($inventaris)) value="{{ $inventaris->lokasi_serah }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="">Rencana Diterima Kembali Tanggal</label>
                                <input type="date" name="tgl_kembali" class="form-control" @if(!empty($inventaris)) value="{{ $inventaris->tgl_kembali }}" @endif required>
                            </div>
                        </div>
                        <div class="modal-footer">                           
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> SIMPAN</button>
                            <a href="{{ route('hrd.cuti.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
