@extends('layouts.layout')

@section('title')
    SIRUS | CAPA
@endsection

@section('css-extra')
<style>
    th { font-size: 13px; }
    td { font-size: 12px; }
</style>
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
        <li class="active"><a href="{{ route('capa.report.index') }}">Report</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Report CAPA</h3>
                    </div>
                    <form action="{{ route('capa.report.filter') }}" method="GET">
                    <div class="box-body">
                        <div class="row">                         
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" name="tgl_awal" value="{{$stgl_awal}}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" name="tgl_akhir" value="{{$stgl_akhir}}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Lokasi</label>
                                    <select name="lokasi_id" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($lokasi as $row)
                                            <option value="{{ $row->id }}" @if($slokasi_id == $row->id) selected @endif>{{ $row->lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Departemen</label>
                                    <select name="dept_id" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($dept as $row)
                                            <option value="{{ $row->id }}" @if($sdept_id == $row->id) selected @endif>{{ $row->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <button type="submit" name="action" value="filter" class="btn btn-primary"><i class="fa fa-filter"></i> Filter Data</button>
                                    <button type="submit" name="action" value="excel" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                                    <button type="submit" name="action" value="pdf" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export to PDF</button>
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
                    {{-- PIE CHART  --}}
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Prosentase Status CAPA</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="PieChart" style="height:200px"></canvas>
                        </div>
                    </div>
                    {{-- /PIE CHART  --}}
                </div>
                <div class="col-md-6">
                    {{-- BAR CHART  --}}
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Grafik Jumlah CAPA</h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="BarChart" style="height:390px"></canvas>
                            </div>
                        </div>
                    </div>
                    {{-- /BARCHART  --}}
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
                                    <th class="text-center">Nomor</th>
                                    <th class="text-center">Dari</th>
                                    <th class="text-center">Kepada</th>
                                    <th class="text-center" width="20%">Potensi Ketidaksesuaian</th>
                                    <th class="text-center">Lokasi Sumber</th>
                                    <th class="text-center">Tgl Terjadi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created at</th>
                                    <th class="text-center">Action</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($model as $row)
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>{{ $row->nomor }}</td>
                                            <td>{{ $row->dari }}</td>
                                            <td>{{ $row->kepada }}</td>
                                            <td>{{ $row->inti_masalah }}</td>
                                            <td>{{ $row->lokasi }}</td>
                                            <td>
                                                @if($row->tgl_terjadi != null)
                                                    {{ date('d-m-Y',strtotime($row->tgl_terjadi)) }}
                                                @else 
                                                    <center>-</center>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->status == 1)
                                                    <label class="label label-primary">Process</label>
                                                @elseif($row->status == 2)
                                                    <label class="label label-success">Done</label>
                                                @else 
                                                    <label class="label label-danger">Rejected</label>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y',strtotime($row->created_at)) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('capa.report.detail', $row->id) }}" title="Show Detail" class="btn btn-info btn-xs">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
                                                <a href="{{ route('capa.print', $row->id) }}" target="_blank" title="Cetak" class="btn btn-success btn-xs">
                                                    <i class="fa fa-print"></i> Print
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
                        targets: 9,
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
                            "Process",
                            "Done",
                            "Rejected"
                        ],
                        datasets: [
                            {
                                data: [{!! $pieProcess !!}, {!! $pieVerif !!}, {!! $pieReject !!}],
                                backgroundColor: [
                                    'rgba(28, 152, 235, 1)',
                                    'rgba(97, 189, 4, 1)',
                                    'rgba(250, 90, 85, 1)'
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
                                label: ["CAPA"],
                                data: @json($barCAPA),
                                backgroundColor: [
                                    'rgba(28, 152, 235, 1)',
                                    'rgba(28, 152, 235, 1)',
                                    'rgba(28, 152, 235, 1)',
                                    'rgba(28, 152, 235, 1)',
                                ]
                                ,
                                borderColor: [
                                    'rgba(28, 152, 235, 1)',
                                    'rgba(28, 152, 235, 1)',
                                    'rgba(28, 152, 235, 1)',
                                    'rgba(28, 152, 235, 1)',
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