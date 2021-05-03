<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulir Izin HRD {{ $form->id }}</title>
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
            font-size: 8pt;
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
            /* padding: 10px 10px 10px; */
            text-align: center;
            margin-left: 35px;
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
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="left" valign="top" rowspan="2">
                <img src="../public/assets/images/logo-form-izin-hrd2.jpg" alt="logo-hrd" width="200px" height="auto" style="margin-left:35px;">
            </td>
            <td width="12%"></td>
            <td align="right" colspan="3">
                F-SRU-HRD-004-R0
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center" style="border:solid 1px black;" colspan="3"><div style="color:red;font-weight:bold;">Diisi oleh HRD</div></td>
        </tr>
        <tr>
            <td width="65%" rowspan="2">
                <div class="judul">Form keluar kantor, lambat datang & pulang <br>awal</div>
            </td>
            <td></td>
            <td class="left">&nbsp;LV No</td>
            <td>: </td>
            <td class="right bottom-strip" width="15%"></td>
        </tr>
        <tr>
            <td></td>
            <td class="left bottom">&nbsp;Valid</td>
            <td class="bottom">: </td>
            <td class="right bottom"></td>
        </tr>
    </table><br>

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
        <td class="bottom">{{ date('d-m-Y',strtotime($form->tanggal)) }}</td>
        <td></td>
        <td align="right">Lokasi / Cabang</td>
        <td>:</td>
        <td class="bottom">{{ $cab->nama_cabang }}</td>
    </tr>
    </table>
    
    <p style="padding-left:20px;"><b>A. Beri tanda (v) sesuai keperluan</b></p>
    <table border="0" width="100%" cellpadding="4" cellspacing="0" style="padding-left:15px;">
        <tr style="background-color:#d3d6db;">
            <td align="center" class="left top bottom">V</td>
            <td align="center" class="left top bottom">Keperluan</td>
            <td align="center" class="left top bottom" colspan="4">Jam</td>
            <td align="center" class="left top right bottom">Keperluan</td>
        </tr>
        <tr>
            <td width="5%" align="center" rowspan="2" class="left bottom"><?php if($form->keperluan == 1){ echo "V";} ?></td>
            <td width="20%" rowspan="2" class="left bottom">Keluar kantor urusan pekerjaan</td>
            <td width="12%" class="left bottom">Jam Keluar</td>
            <td width="1%" class="bottom">:</td>
            <td width="10%" align="center" class="bottom"><?php if($form->keperluan == 1){ echo date('H:i',strtotime($form->jam_keluar));} ?></td>
            <td width="7%" align="center" class="bottom">WIB</td>
            <td width="45%" rowspan="2" align="center" class="left bottom right"><i>Lihat Point (B) di bawah</i></td>
        </tr>
        <tr>
            <td class="left bottom">Jam Masuk</td>
            <td class="bottom">:</td>
            <td class="bottom" align="center"><?php if($form->keperluan == 1){ echo date('H:i',strtotime($form->jam_masuk));} ?></td>
            <td class="bottom" align="center">WIB</td>
        </tr>
        <tr>
            <td class="left bottom" align="center" rowspan="2"><?php if($form->keperluan == 2){ echo "V";} ?></td>
            <td class="left bottom" rowspan="2">Keluar kantor urusan pribadi</td>
            <td class="left bottom">Jam Keluar</td>
            <td class="bottom">:</td>
            <td class="bottom" align="center"><?php if($form->keperluan == 2){ echo date('H:i',strtotime($form->jam_keluar));} ?></td>
            <td class="bottom" align="center">WIB</td>
            <td class="left bottom right" rowspan="2"><?php if($form->keperluan == 2){ echo $form->keterangan;}  ?></td>
        </tr>
        <tr>
            <td class="left bottom">Jam Masuk</td>
            <td class="bottom">:</td>
            <td class="bottom"align="center"><?php if($form->keperluan == 2){ echo date('H:i',strtotime($form->jam_masuk));} ?></td>
            <td class="bottom" align="center">WIB</td>
        </tr>
        <tr>
            <td class="left bottom" align="center"><?php if($form->keperluan == 3){ echo "V";} ?></td>
            <td class="left bottom" >Lambat datang</td>
            <td class="left bottom" >Jam Masuk</td>
            <td class="bottom">:</td>
            <td class="bottom" align="center"><?php if($form->keperluan == 3){ echo date('H:i',strtotime($form->jam_masuk));} ?></td>
            <td class="bottom" align="center">WIB</td>
            <td class="left bottom right"><?php if($form->keperluan == 3){ echo $form->keterangan;}  ?></td>
        </tr>
        <tr>
            <td class="left bottom"align="center"><?php if($form->keperluan == 4){ echo "V";} ?></td>
            <td class="left bottom">Pulang awal</td>
            <td class="left bottom">Jam Keluar</td>
            <td class="bottom">:</td>
            <td class="bottom" align="center"><?php if($form->keperluan == 4){ echo date('H:i',strtotime($form->jam_keluar));} ?></td>
            <td class="bottom" align="center">WIB</td>
            <td class="left bottom right"><?php if($form->keperluan == 4){ echo $form->keterangan;}  ?></td>
        </tr>
    </table>
    <br>
    <p style="padding-left:20px;"><b>B. Khusus keluar kantor urusan pekerjaan (<i><font color="red">wajib diisi</font></i> )</b></p>
    <table border="0" width="100%" cellpadding="8" cellspacing="0" style="padding-left:15px;">
    <tr>
        <td class="left top bottom" align="center" width="7%">1</td>
        <td class="left top bottom" align="center"  width="25%">Nama Pelanggan / RS / <br>Lainnya (*)</td>
        <td class="left top bottom right" width="68%" colspan="2"><?php if($form->keperluan == 1){ echo $form->nama_tujuan;}  ?></td>
    </tr>
    <tr>
        <td class="left bottom" align="center">2</td>
        <td class="left bottom" align="center">Bertemu dengan<br>(nama)</td>
        <td class="left bottom right" colspan="2"><?php if($form->keperluan == 1){ echo $form->up_tujuan;}  ?></td>

    </tr>
    <tr>
        <td class="left bottom" align="center">3</td>
        <td class="left bottom" align="center">Tujuan kunjungan</td>
        <td class="left bottom right" colspan="2"><?php if($form->keperluan == 1){ echo $form->tujuan_kunjungan;}  ?></td>
        
    </tr>
    <tr>
        <td class="left bottom" align="center">4</td>
        <td class="left bottom" align="center">Informasi lainnya yang <br>bisa disampaikan</td>
        <td class="left bottom right" colspan="2"><?php if($form->keperluan == 1){ echo $form->informasi_tambahan;}  ?></td>
    </tr>
    </table>
    <p style="padding-left:20px;"><i>(*) lingkari sesuai keperluan</i></p>
    <p style="padding-left:20px;"><b>C. Catatan</b></p>

    <table border="0" width="100%" cellpadding="2" cellspacing="0" style="padding-left:15px;font-size:8pt;">
    <tr>
        <td class="left top bottom" align="center" width="5%">1</td>
        <td class="left top bottom" align="right"  width="30%">Keluar kantor urusan pribadi :</td>
        <td class="left top bottom right" width="65%">Selain atasan harus ada ttd HRD & Security (form tinggal di security)</td>
    </tr>
    <tr>
        <td class="left bottom" align="center">2</td>
        <td class="left bottom" align="right">Keluar kantor urusan pribadi :</td>
        <td class="left bottom right">Japan 28, Dumer dan Area yang telah ditentukan, ttd HRD diwakilkan Operator Telp</td>
    </tr>
    <tr>
        <td class="left bottom" align="center">3</td>
        <td class="left bottom" align="right">Lambat datang & pulang awal :</td>
        <td class="left bottom right">Setelah mendapat ttd atasan, langsung diserahkan ke HRD</td>
    </tr>
    </table>

    <br>
    <table border="0" width="100%" cellpadding="4" cellspacing="0" style="padding-left:15px;">
        <tr>
            <td class="left top bottom" align="center" width="17%">Pemohon</td>
            <td class="left top bottom" align="center" width="17%">KaCab/KaDept</td>
            <td class="left top bottom" align="center" width="16%">KaDiv</td>
            <td class="left top bottom" align="center" width="16%">Security</td>
            <td class="left top bottom" align="center" width="17%">HRD</td>
            <td class="left top bottom right" align="center" width="17%">Tembusan</td>
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
            <td class="left bottom" align="center"><font size="7pt">{{ $karyawan->name }}</font></td>
            <td class="left bottom"><font size="7pt">Nama:</font></td>
            <td class="left bottom"><font size="7pt">Nama:</font></td>
            <td class="left bottom"><font size="7pt">Nama:</font></td>
            <td class="left bottom"><font size="7pt">Nama:</font></td>
            <td class="left bottom right" align="center"><font size="7pt">Absensi/HRIS</font></td>
        </tr>
    </table>
    <p style="padding-left:20px;">CC : Yth Pimpinan / Manajemen</p>
    
</body>
</html>