@extends('layouts.layout')

@section('title')
    SIRUS | Berita Acara Penggantian Filter Endotoxin
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Berita Acara Penggantian Filter Endotoxin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href=" {{ route('gantifilter.index') }} ">Berita Acara</a></li>
        <li class="active"><a href="{{ route('gantifilter.edit', $ba->id) }}">Edit Penggantian Filter Endotoxin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Berita Acara Penggantian Filter Endotoxin</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('gantifilter.update', $ba->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
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
                                        <option 
                                        @if ($teknisi->id == $ba->teknisi_id ) selected @endif
                                        value="{{ $teknisi->id }}">{{ $teknisi->name }}</option>
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
                                        <option value="" disabled selected>Pilih Teknisi</option>
                                        @foreach ($kateks as $katek)
                                        <option 
                                        @if ($katek->id == $ba->katek_id ) selected @endif
                                        value="{{ $katek->id }}">{{ $katek->name }}</option>
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
                                        <option 
                                        @if ($katam->id == $ba->katam_id ) selected @endif
                                        value="{{ $katam->id }}">{{ $katam->name }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Nama Rumah Sakit</label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="rs_id" id="rs_id" 
                                    class="form-control {{ $errors->has('rs_id') ? 'is-invalid':'' }}
                                     selectpicker" data-live-search="true" required>
                                        @foreach ($rumah_sakit as $rs)
                                        <option 
                                        @if ($rs->id == $ba->rs_id ) selected @endif
                                        value="{{ $rs->id }}">{{ $rs->nama_rs }}</option>
                                        @endforeach
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Tanggal Pengerjaan</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                    placeholder="Tanggal Pelaksanaan"  value="{{ $ba->tanggal }}"required>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4"><label for="">Nama Barang :</label></div>
                                <div class="col-sm-8">
                                    <select name="nama_barang" id="nama_barang" 
                                        class="form-control 
                                        selectpicker" data-live-search="true" required>
                                        <option value="" disabled selected>Pilih Nama Barang</option>                                        
                                        <option value="FG0_2A20C2S" @if($ba->nama_barang == 'FG0_2A20C2S' ) selected @endif>FG0_2A20C2S</option>
                                        <option value="FG0_2A30C2S" @if($ba->nama_barang == 'FG0_2A30C2S' ) selected @endif>FG0_2A30C2S</option>
                                        
                                    </select>                                    
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Jumlah Barang</label>
                                </div>
                                <div class="col-sm-8">
                                <input type="number" min="1" name="jumlah" id="jumlah" class="form-control" 
                                placeholder="Jumlah Barang" value="{{ $ba->jumlah }}" required>
                                    <p class="text-danger"></p>
                                </div>

                                <div class="col-sm-4"><label for="">Ketertangan :</label></div>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="keterangan" 
                                    id="keterangan" cols="60" rows="3" required>{{ $ba->keterangan}}</textarea>
                                </div>                     
                              
                                                                                   
                            </div>  
                            
                            <div class="col-md-12">
                            <br>
                                <div class="col-sm-5"></div>
                                
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"> SUBMIT</i>  
                                    </button>
                                    <a href="{{ route('gantifilter.index') }}" class="btn btn-danger btn-sm">
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

