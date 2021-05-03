<!DOCTYPE html>
<?php Use App\User; Use App\Models\Departemen; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log Absensi {{ $event->nama_event }} - {{ $event->id }}</title>
</head>
<body>
<?php
    function tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
	    $pecahkan = explode('-', $tanggal);
        // variabel pecahkan 0 = tahun
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tanggal
	    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    $hari = array ( 1 =>    'Senin',
                            'Selasa',
                            'Rabu',
                            'Kamis',
                            'Jumat',
                            'Sabtu',
                            'Minggu'
    );
?>
    <center><h3>Absensi Event</h3></center>
    <table border="1" width="100%" cellspacing="4" cellpadding="4" style="border-collapse: collapse;">
        <tr>
            <td width="20%"><strong>Nama Event</strong></td>
            <td>{{ $event->nama_event }}</td>
        </tr>
        <tr>
            <td><strong>Keterangan</strong></td>
            <td>{{ $event->keterangan }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Event</strong></td>
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
            <td>{{ $event->lokasi }}</td>
        </tr>
        <tr>
            <td><strong>Hari/Tanggal</strong></td>
            <td>{{ $hari[date('N', strtotime($event->tanggal))] }}, {{ tgl_indo(date('Y-m-d', strtotime($event->tanggal))) }}</td>
        </tr>
    </table>

    <br>

    <table border="1" width="100%" cellspacing="2" cellpadding="2" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Nama Karyawan</th>
                <th align="center">Departemen</th>
                <th align="center">Masuk</th>
                <th align="center">Keluar</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($pesertas as $peserta)
                <tr>
                    <td align="center">{{ $i }}</td>
                    <td>
                        <?php   
                            $karyawan = User::where(['id' => $peserta->karyawan_id])->first();
                            echo $karyawan->name;
                        ?>
                    </td>
                    <td align="center">
                        <?php   
                            $dept = Departemen::where(['id' => $karyawan->dept_id])->first();
                            echo $dept->kode_departemen;
                        ?>
                    </td>
                    <td align="center">{{ date('H:i', strtotime($peserta->in)) }}</td>
                    <td align="center">
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
</body>
</html>
