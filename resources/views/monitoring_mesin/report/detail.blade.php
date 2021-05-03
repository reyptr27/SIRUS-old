@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('content')
@php 
    use App\Models\TAM\BA\RS;
    use App\Models\Monitoring_Mesin\Tipe_Mesin;
    use App\Models\Monitoring_Mesin\Jenis_Mesin;
    use App\Models\Monitoring_Mesin\Stock_Mesin;
    use App\Models\Beritaacara\Ba_Gudang_Alamat;

    $customer = RS::where('id',$model->customer_id)->first();
@endphp
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Report Monitoring Mesin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Monitoring Mesin</a></li>
        <li><a href="{{ route('monitoringmesin.report.index') }}">Report Monitoring Mesin</a></li>
        <li class="active"><a href="{{ route('monitoringmesin.report.detail', $model->id) }}">Detail Monitoring Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <a href="{{ url()->previous() }}" title="Kembali" class="btn btn-danger">
                            <i class="fa fa-backward"></i> Kembali
                        </a>
                        <a href="{{ route('monitoringmesin.report.detailexcel',$model->id) }}" title="Export" class="btn btn-success">
                            <i class="fa fa-file-excel-o"></i> Export
                        </a>
                    </div>
                    <div class="box-body">
                        <table class="table" width="100%" style="font-size:14px;">
                            <tr>
                                <td width="10%"><strong>Nomor</strong></td>
                                <td width="1%"><strong>:</strong></td>
                                <td>{{ $model->nomor }}</td>
                            </tr>
                            <tr>
                                <td><strong>Customer</strong></td>
                                <td><strong>:</strong></td>
                                <td>{{ $customer->nama_rs }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kategori</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    @if($model->kategori == 1)
                                        Penambahan
                                    @elseif($model->kategori == 2)
                                        Penggantian
                                    @elseif($model->kategori == 3)
                                        Peminjaman
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Tipe</th>
                                    <th class="text-center">Serial</th>
                                    <th class="text-center">Kondisi</th>
                                    <th class="text-center">Gudang</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($detail as $row)
                                        @php 
                                            $tipe = Tipe_Mesin::where(['id' => $row->tipe_id])->first(); 
                                            $jm = Jenis_Mesin::where(['id' => $row->jenis_id])->first();
                                            $gudang = Ba_Gudang_Alamat::where(['id' => $row->gudang_id])->first();
                                            $customer = RS::where(['id' => $row->customer_id])->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $jm->jenis }}</td>
                                            <td>{{ $tipe->tipe }}</td>
                                            <td>{{ $row->nomor }}</td>
                                            <td>
                                                @if($row->kondisi == 1)
                                                    Baru
                                                @elseif($row->kondisi == 2)
                                                    Bekas
                                                @elseif($row->kondisi == 3)
                                                    Rekondisi
                                                @endif
                                            </td>
                                            <td>{{ $gudang->nama_gudang }}</td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </section>
</div>
@endsection

@section('js-extra')
    <script>
        $(document).ready( function(){
            $('#datatable').DataTable({
                'iDisplayLength': 25,
                columnDefs: [
                    { "width": "5%", "targets": 0}
                ],
            });
        });
    </script>
@endsection