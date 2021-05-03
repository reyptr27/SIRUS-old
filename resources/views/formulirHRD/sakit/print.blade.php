<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulir Sakit {{ $form->id }}</title>
    <style type="text/css">
        @font-face {
            font-family: "Tahoma";
            src: url("{{ asset('assets/fonts/tahoma.ttf') }}")  format('truetype');
            font-style: normal;
        }
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
            font-size: 9pt;
            font-family: Tahoma, sans-serif;
        }
        .tabel{
            padding: 5px 5px 5px;
        }
        .tabel2{
            border-collapse: collapse;
            padding-left:15px;
            padding-right:20px;
        }
        .judul{
            font-size: 14pt;
            font-weight: bold;
            border: black 2px solid;
            padding: 5px 5px 5px;
            text-align: center;
            font-family: Tahoma, sans-serif;
        }
        .top {
            border-top: thin solid;
            border-color: black;
        }
        .bottom {
            border-bottom: thin solid;
            border-color: black;
        }
        .bottom-strip {
            border-bottom: thin dashed;
            border-color: black;
        }
        .left {
            border-left: thin solid;
            border-color: black;
        }
        .right {
            border-right: thin solid;
            border-color: black;
        }
    </style>
</head>
<body>
    <?php
        use App\User; use App\Models\Departemen; use App\Models\Cabang;
        $karyawan = User::where(['id' => $form->karyawan_id])->first();
        $dept = Departemen::where(['id' => $karyawan->dept_id])->first();
        $cab = Cabang::where(['id' => $karyawan->cabang_id])->first();
    ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="margin-left:30px;">
        <tr>
            <td align="left" valign="top" rowspan="2">
                <img src="../public/assets/images/logo-form-izin-hrd2.jpg" alt="logo-hrd" width="180px" height="auto">
            </td>
            <td></td>
            <td align="right" colspan="3">
                F-SRU-HRD-001-R0
            </td>
        </tr>
        <tr>
            <td></td>
            <td width="15%" align="center" style="border:solid 1px black;" colspan="3"><div style="color:red;font-weight:bold;">Diisi oleh HRD</div></td>
        </tr>
        <tr>
            <td width="50%" rowspan="2">
                <div class="judul">Form Pemberitahuan Sakit</div>
            </td>
            <td width="20%"></td>
            <td class="left">&nbsp;LV No</td>
            <td>: </td>
            <td class="right bottom-strip" width="10%"></td>
        </tr>
        <tr>
            <td></td>
            <td class="left bottom">&nbsp;Valid</td>
            <td class="bottom">: </td>
            <td class="right bottom"></td>
        </tr>
    </table>
    <br>
    <table border="0" width="100%" cellpadding="4" style="padding-right:20px;">
    <tr>
        <td width="13%" align="right">Nama</td>
        <td width="1%">:</td>
        <td width="32%" class="bottom">{{ $karyawan->name }}</td>
        <td width="5%"></td>
        <td width="17%" align="right">Dept.</td>
        <td width="1%">:</td>
        <td width="31%" class="bottom">{{ $dept->nama_departemen }}</td>
    </tr>
    <tr>
        <td align="right">NIK</td>
        <td>:</td>
        <td class="bottom">{{ $karyawan->nik }}</td>
        <td></td>
        <td align="right">Jabatan</td>
        <td>:</td>
        <td class="bottom">{{ $karyawan->jabatan }}</td>
    </tr>
    <tr>
        <td align="right">Tanggal</td>
        <td>:</td>
        <td class="bottom">{{ date('d-m-Y',strtotime($form->created_at)) }}</td>
        <td></td>
        <td align="right">Lokasi / Cabang</td>
        <td>:</td>
        <td class="bottom">{{ $cab->nama_cabang }}</td>
    </tr>
    </table>
    <br>
    <p style="margin-left:45px;">Tidak masuk bekerja tanggal <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ date('d-m-Y',strtotime($form->tanggal_awal)) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> s/d <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ date('d-m-Y',strtotime($form->tanggal_akhir)) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> dikarenakan sakit</p>
    <p style="margin-left:45px;">Tanggal mulai masuk kerja kembali <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ date('d-m-Y',strtotime($form->tanggal_masuk)) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> (<i>lampirkan surat istirahat dari dokter</i>)</p>

        

    <br>
    <table border="0" width="100%" cellpadding="4" cellspacing="0" style="margin-left:60px;margin-right:100px;">
        <tr>
            <td class="left top bottom" align="center" width="25%">Pemohon</td>
            <td class="left top bottom" align="center" width="25%">KaCab/KaDept</td>
            <td class="left top bottom" align="center" width="25%">KaDiv</td>
            <td class="left top bottom right" align="center" width="25%">Tembusan</td>
        </tr>
        <tr>
            <td class="left bottom">
                <br><br><br><br><br><br>
            </td>
            <td class="left bottom">
                <br><br><br><br><br><br>
            </td>
            <td class="left bottom">
                <br><br><br><br><br><br>
            </td>
            <td class="left bottom right">
                <br><br><br><br><br><br>
            </td>
        </tr>
        <tr>
            <td class="left bottom" align="center"><font size="8pt">{{ $karyawan->name }}</font></td>
            <td class="left bottom"><font size="7pt">Nama:</font></td>
            <td class="left bottom"><font size="7pt">Nama:</font></td>
            <td class="left bottom right"><font size="7pt">Tanggal:</font></td>
        </tr>
        <tr>
            <td class="left bottom" align="center"><font size="8pt">{{ date('d-m-Y',strtotime($form->created_at)) }}</font></td>
            <td class="left bottom"><font size="7pt">Tanggal:</font></td>
            <td class="left bottom"><font size="7pt">Tanggal:</font></td>
            <td class="left bottom right"><font size="7pt">Absensi / HRIS</font></td>
        </tr>
    </table>
    <p style="margin-left:85px;">CC : Yth Pimpinan / Manajemen</p>
    
</body>
</html>