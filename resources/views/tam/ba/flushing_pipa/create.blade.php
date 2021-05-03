@extends('layouts.layout')

@section('title')
    SIRUS | Berita Acara Flushing Pipa
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Berita Acara Flushing Pipa
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#">Berita Acara</a></li>
        <li class="active"><a href="{{ route('flushing.create') }}">Tambah BA Flushing Pipa</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Berita Acara Flushing Pipa</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('flushing.store')}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">

                        <div class="col-md-12">
                                
                                <div class="col-sm-4">
                                    <label for="">Nama Teknisi</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="teknisi_id" id="teknisi_id" 
                                    class="form-control {{ $errors->has('teknisi_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Teknisi</option>
                                        @foreach ($teknisis as $teknisi)
                                        <option value="{{ $teknisi->id }}">{{ $teknisi->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Kepala Teknisi</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="katek_id" id="katek_id" 
                                    class="form-control {{ $errors->has('katek_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Kepala Teknisi</option>
                                        @foreach ($kateks as $katek)
                                        <option value="{{ $katek->id }}">{{ $katek->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Kepala TAM</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="katam_id" id="katam_id" 
                                    class="form-control {{ $errors->has('katam_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        
                                        @foreach ($katams as $katam)
                                        <option value="{{ $katam->id }}">{{ $katam->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4"><label for="">Nama Rumah Sakit :</label></div>
                                <div class="col-sm-8">
                                    <select name="rs_id" id="rs_id" 
                                        class="form-control {{ $errors->has('rs_id') ? 'is-invalid':'' }}
                                        selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Rumah Sakit</option>
                                        @foreach ($rumah_sakit as $rs)
                                        <option value="{{ $rs->id }}">{{ $rs->nama_rs }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Tanggal Pengerjaan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal Pelaksanaan" required>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4"><label for="">Jenis Pekerjaan :</label></div>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="jenis_pekerjaan" 
                                    id="jenis_pekerjaan" cols="60" rows="3" required>Flushing Instalasi Pipa Distribusi ke ruang Hemodialisa</textarea>
                                </div>                                 
                                                                                   
                            </div>

                            
                            <div class="col-md-12">
                            <br>
                                <div class="col-sm-5"></div>
                                
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"> SUBMIT</i>  
                                    </button>
                                    <a href="{{ route('flushing.index') }}" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>  BATAL
                                    </a>
                                </div>

                            </div>                            
                        
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection

@section('js-extra')


@endsection

