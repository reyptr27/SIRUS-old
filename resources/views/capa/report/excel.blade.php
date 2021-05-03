<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekapitulasi CAPA</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th><strong>TANGGAL PEMBUATAN</strong></th>
                <th><strong>NO. PTKP</strong></th>
                <th><strong>POTENSI KETIDAKSESUAIAN</strong></th>
                <th><strong>LOKASI SUMBER</strong></th>
                <th><strong>TANGGAL TERJADI</strong></th>
                <th><strong>PENYEBAB MUNCUL</strong></th>
                <th><strong>RENCANA TINDAKAN</strong></th>
                <th><strong>HASIL TINDAKAN</strong></th>
                <th><strong>TANGGAL SELESAI</strong></th>
                <th><strong>KETERANGAN</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach($model as $row)
                @php 
                    $lokasi = DB::table('capa_lokasi')->select(['capa_lokasi.lokasi'])->where('capa_lokasi.id',$row->lokasi_id)->first();
                @endphp
                <tr>
                    <td>{{ date('Y-m-d', strtotime($row->created_at)) }}</td>
                    <td>{{ $row->nomor }}</td>
                    <td>@php echo nl2br(htmlspecialchars($row->inti_masalah)); @endphp</td>
                    <td>{{ $lokasi->lokasi }}</td>
                    <td>{{ date('Y-m-d', strtotime($row->tgl_terjadi)) }}</td>
                    <td>@php echo nl2br(htmlspecialchars($row->penyebab_masalah)); @endphp</td> 
                    <td>Koreksi : <br>@php echo nl2br(htmlspecialchars($row->koreksi)); @endphp <br><br>
                        Preventif : <br>@php echo nl2br(htmlspecialchars($row->pencegahan)); @endphp
                    </td>
                    <td>@php echo nl2br(htmlspecialchars($row->hasil_tindakan)); @endphp</td>
                    <td>{{ date('Y-m-d', strtotime($row->tgl_verifikasi)) }}</td>
                    <td>@php echo nl2br(htmlspecialchars($row->catatan)); @endphp</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
