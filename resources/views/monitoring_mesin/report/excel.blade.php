<!DOCTYPE html>
@php use App\User; @endphp
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Report Monitoring Mesin</title>
</head>
<body>
@php 
    use App\Models\TAM\BA\RS;
    use App\Models\Beritaacara\Ba_Gudang_Alamat;
@endphp
    <table>
        <thead>
            <tr>
                <th><strong>No</strong></th>
                <th><strong>Tgl Approval</strong></th>
                <th><strong>Nomor</strong></th>
                <th><strong>Kategori</strong></th>
                <th><strong>Customer</strong></th>
                <th><strong>Rencana Kirim</strong></th>
                <th><strong>Rencana Instalasi</strong></th>
                <th><strong>Realisasi Kirim</strong></th>
                <th><strong>Realisasi Instalasi</strong></th>
                <th><strong>Tgl BAST</strong></th>
                <th><strong>Status</strong></th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($model as $row)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->tgl_approval)) }}</td>
                    <td>{{ $row->nomor }}</td>
                    <td>
                        @if($row->kategori == 1)
                            Penambahan
                        @elseif($row->kategori == 2)
                            Penggantian
                        @elseif($row->kategori == 3)
                            Peminjaman
                        @endif
                    </td>
                    <td>
                        @php
                            $cust = RS::where('id', $row->customer_id)->first();
                            echo $cust->nama_rs;
                        @endphp
                    </td>
                    <td>{{ date('d/m/Y', strtotime($row->tgl_plan_kirim)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->tgl_plan_instalasi)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->tgl_kirim)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->tgl_instalasi)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->tgl_bast)) }}</td>
                    <td>
                        @if($row->status == 1)
                            Rekomendasi
                        @elseif($row->status == 2)
                            Rencana Pengiriman
                        @elseif($row->status == 3)
                            Pengiriman dan Instalasi
                        @elseif($row->status == 4)
                            Selesai
                        @endif
                    </td>
                </tr>
                @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
