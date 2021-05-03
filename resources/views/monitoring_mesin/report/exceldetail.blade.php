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
    use App\Models\Monitoring_Mesin\Tipe_Mesin;
    use App\Models\Monitoring_Mesin\Jenis_Mesin;
    use App\Models\Monitoring_Mesin\Stock_Mesin;
    use App\Models\Beritaacara\Ba_Gudang_Alamat;

    $customer = RS::where('id',$model->customer_id)->first();
@endphp
    <table>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Nomor</strong></td>
            <td>: {{ $model->nomor }}</td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Customer</strong></td>
            <td>: {{ $customer->nama_rs }}</td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Kategori</strong></td>
            <td> :
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

    <table>
        <thead>
            <tr>
                <th><strong>No</strong></th>
                <th><strong>Jenis</strong></th>
                <th><strong>Tipe</strong></th>
                <th><strong>Serial</strong></th>
                <th><strong>Kondisi</strong></th>
                <th><strong>Gudang</strong></th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($detail as $row)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $row->jenis }}</td>
                    <td>{{ $row->tipe }}</td>
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
                    <td>
                        {{ $row->nama_gudang }}
                    </td>
                </tr>
                @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
