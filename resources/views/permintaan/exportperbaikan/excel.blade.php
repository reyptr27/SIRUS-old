<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
    <title>Rekapitulasi Perbaikan IT</title>

    
    
</head>
<body>
    <table>
        <thead>            
            <tr style="border:1px solid black" text-align="center">
                <th rowspan="2" style="width:5px; border:1px solid black" valign="center">
                    <strong>NO.</strong>
                </th>
                <th rowspan="2" style="width:13px; border:1px solid black" valign="center" align="center"><strong>Tgl Pengajuan</strong></th>                
                <th rowspan="2" style="width:22px; border:1px solid black" valign="center" align="center"><strong>No. Form Perbaikan</strong></th>
                <th rowspan="2" style="width:22px; border:1px solid black" valign="center" align="center"><strong>Pemohon</strong></th>
                <th rowspan="2" style="width:45px; border:1px solid black" valign="center" align="center"><strong>Penanganan</strong></th>
                <th colspan="2" style="border:1px solid black; border-right:1px solid black" align="center">
                <strong>Status</strong></th>  
                          
            </tr>
            <tr>
                <td style="width:7px; border:1px solid black">OK</td>
                <td style="width:7px; border:1px solid black">N/OK</td>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($perbaikan as $data)                
                <tr>
                    <td style="border:1px solid black" valign="top">{{$i}}</td>
                    <td style="border:1px solid black" valign="top">{{ date('Y-m-d', strtotime($data->created_at)) }}</td>
                    <td style="border:1px solid black" valign="top">{{ $data->no_document }}</td>
                    <td style="border:1px solid black" valign="top">{{ $data->pemohon }}</td>
                    <td style="border:1px solid black" valign="top">{{ $data->deskripsi }}</td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>                    
                </tr>
                @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
