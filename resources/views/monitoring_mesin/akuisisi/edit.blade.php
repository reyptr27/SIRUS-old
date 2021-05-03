@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Akuisisi Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.akuisisi.edit', $header->id) }}">Akuisisi Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Akuisisi untuk Realisasi Mesin {{ $header->nomor }}</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('monitoringmesin.akuisisi.update', $header->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nomor</label>
                                    <input type="text" value="{{ $header->nomor }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Customer</label>
                                    @php 
                                        use App\Models\TAM\BA\RS;
                                        use App\Models\Monitoring_Mesin\Stock_Mesin;
                                        use App\Models\Monitoring_Mesin\Jenis_Mesin;
                                        use App\Models\Monitoring_Mesin\Tipe_Mesin;
                                        use App\Models\Beritaacara\Ba_Gudang_Alamat;
                                        $cust = RS::where(['id'=> $header->customer_id])->first();
                                    @endphp
                                    <input type="text" value="{{ $cust->nama_rs }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal Pengiriman</label>
                                    <input type="date" value="{{ $header->tgl_kirim }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal Instalasi</label>
                                    <input type="date" value="{{ $header->tgl_instalasi }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal BAST</label>
                                    <input type="date" value="{{ $header->tgl_bast }}" class="form-control" readonly>
                                </div>
                            </div>
                            <p></p>
                            <div class="col-md-12" style="margin-top:20px;margin-bottom:20px;">
                                <div class="col-md-1 bg-light-blue">
                                    <label for="">Jenis</label>
                                </div> 
                                <div class="col-md-2 bg-light-blue">
                                    <label for="">Tipe</label>
                                </div>
                                <div class="col-md-2 bg-light-blue">
                                    <label for="">Nomor Seri</label>
                                </div>
                                <div class="col-md-1 bg-light-blue">
                                    <label for="">Kondisi</label>
                                </div>
                                <div class="col-md-2 bg-light-blue">
                                    <label for="">Gudang</label>
                                </div>
                                <div class="col-md-1 bg-light-blue">
                                    <label for="">Nomor FA</label>
                                </div>
                                <div class="col-md-2 bg-light-blue">
                                    <label for="">Akuisisi</label>
                                </div>
                            </div>
                            
                            @foreach($detail as $row)
                                <input type="hidden" name="id[]" value="{{ $row->id }}">

                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-12">
                                        <div class="col-md-1">
                                            @php 
                                                $jenis = Jenis_Mesin::where(['id' => $row->jenis_id])->first();
                                                $tipe = Tipe_Mesin::where(['id' => $row->tipe_id])->first();
                                                $gudang = Ba_Gudang_Alamat::where(['id' => $row->gudang_id])->first();
                                            @endphp
                                            <input type="text" value="{{ $jenis->jenis }}" class="form-control" readonly>
                                        </div> 
                                        <div class="col-md-2">
                                            <input type="text" value="{{ $tipe->tipe }}" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" value="{{ $row->nomor }}" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" 
                                            @if($row->kondisi == 1) value="Baru" @elseif($row->kondisi == 2) value="Bekas" @elseif($row->kondisi == 3) value="Rekondisi" @endif
                                            class="form-control" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" value="{{ $gudang->nama_gudang }}" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="fa_number[]" value="{{ $row->fa_number }}" class="form-control" placeholder="Nomor FA">
                                        </div>
                                        <div class="col-md-2">
                                            <select name="akuisisi[]" class="form-control">
                                                <option value="1" @if($row->akuisisi == 1) selected @endif>Process</option>
                                                <option value="2" @if($row->akuisisi == 2) selected @endif>Done</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
               
                        </div>
                        <div class="box-footer">                           
                            <button type="submit" title="Submit" class="btn btn-success" >
                                <i class="fa fa-send"></i> SIMPAN
                            </button>
                            <a href="{{ route('monitoringmesin.akuisisi.index') }}" class="btn btn-danger"><i class="fa fa-close"></i> BATAL</a>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
