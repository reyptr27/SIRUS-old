<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulir Unpaid Leave {{ $form->id }}</title>
    <style type="text/css">
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
            font-size: 9pt;
            font-family: Tahoma, serif;
        }
    </style>
</head>
<body>
    <?php
        use App\User; use App\Models\Departemen; use App\Models\Cabang;
        $karyawan = User::where(['id' => $form->karyawan_id])->first();
        $dept = Departemen::where(['id' => $karyawan->dept_id])->first();
        $cab = Cabang::where(['id' => $karyawan->cabang_id])->first();
        $atasan = User::where(['id' => $form->atasan_id])->first();
    ?>
    <br>
    <p>Surabaya, {{ date('d-m-Y', strtotime($form->created_at)) }}</p>
    <p>Kepada Yth.<br>HRD<br>di Tempat</p>
    <p>Dengan Hormat,</p>
    <p>Saya yang bertanda tangan di bawah ini:</p>
    <table style="margin-left:50px;" width="100%">
        <tr>
            <td width="15%">Nama</td>
            <td width="2%">:</td>
            <td>{{ $karyawan->name }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $karyawan->nik }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $karyawan->jabatan }}</td>
        </tr>
        <tr>
            <td>Tgl. Masuk</td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($form->tanggal_masuk)) }}</td>
        </tr>
        <tr>
            <td>Divisi</td>
            <td>:</td>
            <td>{{ $form->divisi }}</td>
        </tr>
        <tr>
            <td>Department</td>
            <td>:</td>
            <td>{{ $dept->nama_departemen }}</td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td>:</td>
            <td>{{ $cab->nama_cabang }}</td>
        </tr>
    </table>
    <p>
        Tidak masuk kantor pada tanggal <u>@if($form->tanggal_awal == $form->tanggal_akhir){{ date('d-m-Y', strtotime($form->tanggal_awal)) }}@else {{ date('d-m-Y', strtotime($form->tanggal_awal)) }}</u> s/d <u>{{ date('d-m-Y', strtotime($form->tanggal_akhir)) }}@endif</u> karena
        <u>{{ $form->alasan }}</u>, belum memiliki hak cuti/ tidak memiliki hak cuti 
    </p>
    <p>Sehubungan dengan ketidakhadiran saya tersebut diatas saya bersedia dipotong gaji (unpaid leave).<br>
        Bila sewaktu - waktu ada perubahan ketentuan dari internal /eksternal, sehubungan dengan cuti karyawan,<br>
        saya tetap menyetujui unpaid leave yang sudah saya tanda tangani ini.
    </p><br>
    <p>Mohon dapat dimaklumi, atas perhatian dan kerjasamanya diucapkan terima kasih.</p>
    <br><br>
    <table width="100%">
        <tr>
            <td align="center">Hormat saya,</td>
            <td align="center">Mengetahui,</td>
            {{-- <td align="center">Menyetujui,</td> --}}
        </tr>
        <tr>
            <td colspan="2"><br><br><br><br><br></td>
        </tr>
        <tr>
            <td align="center">( {{ $karyawan->name }} )</td>
            <td align="center">( {{ $atasan->name }} )</td>
            {{-- <td align="center">( HRD )</td> --}}
        </tr>
    </table>
</body>
</html>