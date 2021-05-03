<?php Use App\User; Use App\Models\Departemen; ?>
@extends('layouts.layout')

@section('title')
    SIRUS | Log Absensi Event
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Event
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('event.index') }}">Event</a></li>
        <li class="active"><a href="{{ route('event.log', $event->id) }}">View Log Absensi</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('event.index') }}" class="btn btn-danger" style="margin-bottom:15px;"><i class="fa fa-backward"></i> Kembali</a>
            </div>
            <div class="col-md-12">
                <div class="box box-info">
                <div class="box-body">
                <table width="100%">
                    <tr>
                        <td width="25%"><strong>Tanggal</strong></td>
                        <td>:</td>
                        <td>{{ date('d-m-Y', strtotime($event->tanggal)) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Event</strong></td>
                        <td>:</td>
                        <td>{{ $event->nama_event }}</td>
                    </tr>
                    <tr>
                        <td><strong>Keterangan</strong></td>
                        <td>:</td>
                        <td>{{ $event->keterangan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Event</strong></td>
                        <td>:</td>
                        <td>
                            @if($event->jenis_event == 1)
                                Briefing
                            @elseif($event->jenis_event == 2)
                                Meeting
                            @elseif($event->jenis_event == 3)
                                Training
                            @else
                                Lain-lain
                            @endif 
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Lokasi</strong></td>
                        <td>:</td>
                        <td>{{ $event->lokasi }}</td>
                    </tr>
                </table>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Log Absensi
                        </h3>
                    </div>
                    <div class="box-body">
                        <div style="margin-bottom:10px;">
                            Export to : 
                            <a href="{{ route('event.log.excel',$event->id) }}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Excel</a>
                            <a href="{{ route('event.log.pdf',$event->id) }}" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i> PDF</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="datatable" width="100%">
                                <thead>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama Karyawan</th>
                                    <th class="text-center">Dept</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Jam Keluar</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($pesertas as $peserta)
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>
                                                <?php   
                                                    $karyawan = User::where(['id' => $peserta->karyawan_id])->first();
                                                    echo $karyawan->name;
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php   
                                                    $dept = Departemen::where(['id' => $karyawan->dept_id])->first();
                                                    echo $dept->kode_departemen;
                                                ?>
                                            </td>
                                            <td class="text-center">{{ date('H:i', strtotime($peserta->in)) }}</td>
                                            <td class="text-center">
                                                @if($peserta->out != null)
                                                    {{ date('H:i', strtotime($peserta->out)) }}
                                                @else
                                                    -
                                                @endif
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
    <script>
         $(document).ready( function(){
            $('#datatable').DataTable({
                columnDefs: [
                    { "width": "5%", "targets": 0},
                ],
            });
        });
    </script>
@endsection