<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekapitulasi CAPA </title>
</head>
<body>
    <table width="100%" style="font-size:10px" border="1" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2" rowspan="3" align="center"><img src="../public/assets/images/sru-logo.png" alt="logo-sru" width="150px"></td>
            <td colspan="4" rowspan="3" align="center">
                <u>FORMULIR</u><br>
                <b>REKAPITULASI TINDAKAN KOREKSI DAN PENCEGAHAN</b>
            </td>
            <td colspan="3">Nomor Dokumen:</td>
        </tr>
        <tr>
            <td colspan="3" rowspan="2" align="center"><b>F-SRU-QSE-011</b></td>
        </tr>
        <tr>
            
        </tr>
        <tr>
            <td align="center" width="5%"><strong>NO. PTKP</strong></td>
            <td align="center" width="15%"><strong>POTENSI KETIDAKSESUAIAN</strong></td>
            <td align="center" width="5%"><strong>LOKASI SUMBER</strong></td>
            <td align="center" width="5%"><strong>TANGGAL TERJADI</strong></td>
            <td align="center" width="20%"><strong>PENYEBAB MUNCUL</strong></td>
            <td align="center" width="23%"><strong>RENCANA TINDAKAN</strong></td>
            <td align="center" width="12%"><strong>HASIL TINDAKAN</strong></td>
            <td align="center" width="5%"><strong>TANGGAL SELESAI</strong></td>
            <td align="center" width="10%"><strong>KETERANGAN</strong></td>
        </tr>

        @foreach($model as $row)
            @php 
                $lokasi = DB::table('capa_lokasi')->select(['capa_lokasi.lokasi'])->where('capa_lokasi.id',$row->lokasi_id)->first();
            @endphp
            <tr>
                <td valign="top" align="center">{{ $row->nomor }}</td>
                <td valign="top" align="justify">@php echo nl2br(htmlspecialchars($row->inti_masalah)); @endphp</td>
                <td valign="top" align="center">{{ $lokasi->lokasi }}</td>
                <td valign="top" align="center">{{ date('d-m-Y', strtotime($row->tgl_terjadi)) }}</td>
                <td valign="top" align="justify">@php echo nl2br(htmlspecialchars($row->penyebab_masalah)); @endphp</td> 
                <td valign="top" align="justify">
                    <b>Koreksi :</b> @php echo nl2br(htmlspecialchars($row->koreksi)); @endphp <br><br>
                    <b>Preventif :</b> @php echo nl2br(htmlspecialchars($row->pencegahan)); @endphp
                    
                </td>
                <td valign="top" align="justify">@php echo nl2br(htmlspecialchars($row->hasil_tindakan)); @endphp</td>
                <td valign="top" align="center">{{ date('d-m-Y', strtotime($row->tgl_selesai)) }}</td>
                <td valign="top" align="justify">@php echo nl2br(htmlspecialchars($row->catatan)); @endphp</td>
            </tr>
        @endforeach
       
    </table>
</body>
</html>