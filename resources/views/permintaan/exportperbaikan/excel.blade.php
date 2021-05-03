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
                <th style="width:5px; border:1px solid black" valign="center">
                    <strong>NO.</strong>
                </th>
                <th style="width:15px; border:1px solid black" valign="center" align="center"><strong>TANGGAL</strong></th>                
                <th style="width:26px; border:1px solid black" valign="center" align="center"><strong>No. Form Perbaikan</strong></th>
                <th style="width:50px; border:1px solid black" valign="center" align="center"><strong>Penanganan</strong></th>
                <th style="border:1px solid black; border-right:1px solid black" align="center">
                <strong>Status</strong></th>  
                <th style="border:1px solid black"></th>            
            </tr>
            <tr>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black"></td>
                <td style="border:1px solid black">OK</td>
                <td style="border:1px solid black">N/OK</td>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($perbaikan as $data)                
                <tr>
                    <td style="border:1px solid black">{{$i}}</td>
                    <td style="border:1px solid black">{{ date('Y-m-d', strtotime($data->created_at)) }}</td>
                    <td style="border:1px solid black">{{ $data->no_document }}</td>
                    <td style="border:1px solid black">{{ $data->deskripsi }}</td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>                    
                </tr>
                @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
