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
    <table>
        <tr>
            <td><strong>Nama Event</strong></td>
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
            <td><strong>Tanggal</strong></td>
            <td>{{ date('Y/m/d', strtotime($event->tanggal)) }}</td>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th><strong>No</strong></th>
                <th><strong>Nama Karyawan</strong></th>
                <th><strong>Departemen</strong></th>
                <th><strong>Masuk</strong></th>
                <th><strong>Keluar</strong></th>
            </tr>
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
</body>
</html>
