@extends('layouts.layout')

@section('title')
    SIRUS | CAPA
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        CAPA (Corrective Action Preventive Action)
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">CAPA</a></li>
        <li><a href="{{ route('capa.report.index') }}">Report CAPA</a></li>
        <li class="active"><a href="{{ route('capa.report.detail', $model->id) }}">Detail CAPA</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <a href="{{ url()->previous() }}" title="Kembali" class="btn btn-danger">
                            <i class="fa fa-backward"></i> Kembali
                        </a>
                        <a href="{{ route('capa.print',$model->id) }}" target="_blank" title="Print" class="btn btn-success">
                            <i class="fa fa-print"></i> Print
                        </a>
                        <br>
                        <h3 class="box-title" style="margin-top:20px;">Detail Report <strong>{{ $model->nomor }}</strong></h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <tr>
                                    <td width="15%"><strong>Nomor Form PTKP</strong></td>
                                    <td>{{ $model->nomor }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dari</strong> <small>(Departemen yang menemukan)</small></td>
                                    <td>{{ $dari->nama_departemen }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kepada</strong> <small>(Departemen temuan)</small> </td>
                                    <td>{{ $kepada->nama_departemen }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Terjadi</strong></td>
                                    <td>{{ date('d-m-Y', strtotime($model->tgl_terjadi)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi Sumber</strong></td>
                                    <td>{{ $lokasi->lokasi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi Sumber</strong></td>
                                    <td>{{ $lokasi->lokasi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori</strong></td>
                                    <td>
                                        [@if($model->kategori_1 == 2) V @else &nbsp;&nbsp;&nbsp; @endif] Management Review
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        [@if($model->kategori_2 == 2) V @else &nbsp;&nbsp;&nbsp; @endif] Tindakan Pencegahan
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        [@if($model->kategori_3 == 2) V @else &nbsp;&nbsp;&nbsp; @endif] Tindakan Koreksi
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Potensi Ketidaksesuaian</strong></td>
                                    <td>
                                        @php echo nl2br(htmlspecialchars($model->inti_masalah)); @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Rincian Permasalahan</strong></td>
                                    <td>
                                        @php echo nl2br(htmlspecialchars($model->rincian_masalah)); @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Penyebab Permasalahan</strong></td>
                                    <td>
                                        @php echo nl2br(htmlspecialchars($model->penyebab_masalah)); @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tindakan Koreksi</strong></td>
                                    <td>
                                        @php echo nl2br(htmlspecialchars($model->koreksi)); @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tindakan Pencegahan</strong></td>
                                    <td>
                                        @php echo nl2br(htmlspecialchars($model->pencegahan)); @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Target Penyelesaian</strong></td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($model->tgl_target)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>PIC Penyelesaian</strong></td>
                                    <td>
                                        {{ $pic->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Verifikator</strong></td>
                                    <td>
                                        {{ $verifikator->name }}
                                    </td>
                                </tr>
                                @if($model->status == 2)
                                <tr>
                                    <td><strong>Pembuktian/Verifikasi</strong></td>
                                    <td>
                                        @if($model->hasil_tindakan != null)
                                            @php echo nl2br(htmlspecialchars($model->hasil_tindakan)); @endphp
                                        @else 
                                            <i>(kosong)</i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Verifikasi</strong></td>
                                    <td>
                                        @if($model->tgl_verifikasi != null)
                                            {{ date('d-m-Y', strtotime($model->tgl_verifikasi)) }}
                                        @else 
                                            <i>(kosong)</i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Catatan</strong></td>
                                    <td>
                                        @if($model->catatan != null)
                                            @php echo nl2br(htmlspecialchars($model->catatan)); @endphp
                                        @else 
                                            <i>(kosong)</i>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>
                                        @if($model->status == 1)
                                            <label class="label label-primary">Process</label>
                                        @elseif($model->status == 2)
                                            <label class="label label-success">Done</label>
                                        @else 
                                            <label class="label label-danger">Rejected</label>
                                        @endif
                                    </td>
                                </tr>
                                @if($model->status == 3)
                                    <tr>
                                        <td><strong>Feedback</strong></td>
                                        <td>
                                            @if($model->feedback != null)
                                                {{ $model->feedback}}
                                            @else 
                                                <i>(kosong)</i>
                                            @endif
                                            <br><br>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Dibuat Oleh</strong> </td>
                                    <td>
                                        {{ $creator->name }} ( {{ date('d-m-Y H:i', strtotime($model->created_at)) }} )
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate Oleh</strong></td>
                                    <td>
                                        {{ $updater->name }} ( {{ date('d-m-Y H:i', strtotime($model->updated_at)) }} )
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection
