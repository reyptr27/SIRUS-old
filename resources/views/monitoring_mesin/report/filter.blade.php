@extends('layouts.layout')

@section('title')
    SIRUS | Monitoring Mesin
@endsection

@section('css-extra')
<style>
    th { font-size: 13px; }
    td { font-size: 12px; }
</style>
@endsection

@section('content')

@php 
    use App\Models\TAM\BA\RS;
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
        <li class="active"><a href="{{ route('monitoringmesin.report.index') }}">Report Monitoring Mesin</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Report Monitoring Mesin</h3>
                    </div>
                    <form action="{{ route('monitoringmesin.report.filter') }}" method="GET">
                    <div class="box-body">
                        <div class="row">                         
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label for="">Tgl Rekomendasi Awal</label>
                                    <input type="date" name="tgl_awal" value="{{$stgl_awal}}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Tgl Rekomendasi Akhir</label>
                                    <input type="date" name="tgl_akhir" value="{{$stgl_akhir}}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Kategori</label>
                                    <select name="kategori" class="form-control">
                                        <option value="">All</option>
                                        <option value="1" @if($skategori == 1) selected @endif>Penambahan</option>
                                        <option value="2" @if($skategori == 2) selected @endif>Penggantian</option>
                                        <option value="3" @if($skategori == 3) selected @endif>Peminjaman</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Customer</label>
                                    <select name="customer_id" class="form-control selectpicker" data-live-search="true">
                                        <option value="">All</option>
                                        @foreach ($customer as $row)
                                            <option value="{{ $row->id }}" @if($scustomer_id == $row->id) selected @endif>{{ $row->nama_rs }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <button type="submit" name="action" value="filter" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                                    <button type="submit" name="action" value="export" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>   
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <!-- DONUT CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Prosentase Status Realisasi Mesin</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="PieChart" style="height:200px"></canvas>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-md-6">
                    <!-- BAR CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Grafik Realisasi Pengiriman dan Instalasi Mesin</h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="BarChart" style="height:390px"></canvas>
                            </div>
                        </div>
                    <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
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
                                    <th class="text-center">Tgl Approval</th>
                                    <th class="text-center">Nomor</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Rencana Kirim</th>
                                    <th class="text-center">Rencana Instalasi</th>
                                    <th class="text-center">Realisasi Kirim</th>
                                    <th class="text-center">Realisasi Instalasi</th>
                                    <th class="text-center">Tgl BAST</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($model as $row)
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>{{ date('d-m-Y', strtotime($row->tgl_approval)) }}</td>
                                            <td>{{ $row->nomor }}</td>
                                            <td>
                                                @if($row->kategori == 1)
                                                    Penambahan
                                                @elseif($row->kategori == 2)
                                                    Penggantian
                                                @else 
                                                    Peminjaman
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $customer = RS::where('id',$row->customer_id)->first();
                                                    if(!empty($customer)){
                                                        echo $customer->nama_rs;
                                                    }
                                                    else {
                                                        echo "<center>-</center>";
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                @if($row->tgl_plan_kirim != null)
                                                    {{ date('d-m-Y', strtotime($row->tgl_plan_kirim)) }}
                                                @else 
                                                    <center>-</center>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->tgl_plan_instalasi != null)
                                                    {{ date('d-m-Y', strtotime($row->tgl_plan_instalasi)) }}
                                                @else 
                                                    <center>-</center>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->tgl_kirim != null)
                                                    {{ date('d-m-Y', strtotime($row->tgl_kirim)) }}
                                                @else 
                                                    <center>-</center>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->tgl_instalasi != null)
                                                    {{ date('d-m-Y', strtotime($row->tgl_instalasi)) }}
                                                @else 
                                                    <center>-</center>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->tgl_bast != null)
                                                    {{ date('d-m-Y', strtotime($row->tgl_bast)) }}
                                                @else 
                                                    <center>-</center>
                                                @endif
                                            </td>
                                            <td class="text-center"> 
                                                @if($row->status == 1)
                                                    <label class="label label-primary">Rekomendasi</label>
                                                @elseif($row->status == 2)
                                                    <label class="label label-primary">Rencana Pengiriman</label>
                                                @elseif($row->status == 3)
                                                    <label class="label label-primary">Pengiriman dan Instalasi</label>
                                                @elseif($row->status == 4)
                                                    <label class="label label-success">Selesai</label>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('monitoringmesin.report.detail', $row->id) }}" title="Show Detail" class="btn btn-info btn-xs">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
                                            </td>
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
    <script src="{{ asset('assets/vendors/chart.js/Chart.bundle.min.js')}}"></script>
    <script>
        $(document).ready( function(){
            $('#datatable').DataTable({
                'iDisplayLength': 25,
                columnDefs: [
                    {
                        targets: 11,
                        orderable: false
                    },
                    { "width": "5%", "targets": 0}
                ]
            });
            function PieChart(){
                var ctx = document.getElementById("PieChart").getContext('2d');
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: [
                            "Rekomendasi",
                            "Rencana Pengiriman",
                            "Pengiriman dan Instalasi",
                            "Relisasi Selesai"
                        ],
                        datasets: [
                            {
                                data: [{!! $pieRekomendasi !!}, {!! $pieRencana !!}, {!! $pieRealisasi !!}, {!! $pieSelesai !!}],
                                backgroundColor: [
                                    'rgba(252, 124, 177, 1)',
                                    'rgba(255, 213, 77, 1)',
                                    'rgba(109, 188, 252, 1)',
                                    'rgba(103, 204, 49, 1)'
                                ]
                            }
                        ]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            
            PieChart();

            var tooltipsLabel = @json($month_data);
            function BarChart() {
                var ctx = document.getElementById("BarChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($month_data),
                        datasets: [
                            {
                                label: ["Rekomendasi"],
                                data: @json($barRekomendasi),
                                backgroundColor: [
                                    'rgba(252, 124, 177, 1)',
                                    'rgba(252, 124, 177, 1)',
                                    'rgba(252, 124, 177, 1)',
                                    'rgba(252, 124, 177, 1)',
                                ]
                                ,
                                borderColor: [
                                    'rgba(252, 124, 177, 1)',
                                    'rgba(252, 124, 177, 1)',
                                    'rgba(252, 124, 177, 1)',
                                    'rgba(252, 124, 177, 1)',
                                ],
                                borderWidth: 1
                            },
                            {
                                label: ["Pengiriman"],
                                data: @json($barPengiriman),
                                backgroundColor: [
                                    'rgba(255, 213, 77, 1)',
                                    'rgba(255, 213, 77, 1)',
                                    'rgba(255, 213, 77, 1)',
                                    'rgba(255, 213, 77, 1)',
                                ],
                                borderColor: [
                                    'rgba(255, 213, 77,1)',
                                    'rgba(255, 213, 77,1)',
                                    'rgba(255, 213, 77,1)',
                                    'rgba(255, 213, 77,1)',
                                ],
                                borderWidth: 1
                            },
                            {
                                label: ["Instalasi"],
                                data: @json($barInstalasi),
                                backgroundColor: [
                                    'rgba(109, 188, 252, 1)',
                                    'rgba(109, 188, 252, 1)',
                                    'rgba(109, 188, 252, 1)',
                                    'rgba(109, 188, 252, 1)',
                                ],
                                borderColor: [
                                    'rgba(109, 188, 252,1)',
                                    'rgba(109, 188, 252,1)',
                                    'rgba(109, 188, 252,1)',
                                    'rgba(109, 188, 252,1)',
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                    scales: {
                        yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true,
                        callbacks: {
                        title: function(tooltipItem, data) {
                            console.log(tooltipItem);
                            return tooltipsLabel[tooltipItem[0].index];
                        }
                        }
                    }
                    }
                });
            }
            BarChart();
        });
    </script>
@endsection