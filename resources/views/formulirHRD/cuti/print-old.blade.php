<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulir Cuti {{ $form->id }}</title>
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
            font-size: 7pt;
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
        .top-strip {
            border-top: thin dashed;
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
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <?php
        use App\User; use App\Models\Departemen; use App\Models\Cabang; use App\Models\Divisi;
        $karyawan = User::where(['id' => $form->karyawan_id])->first();
        $dept = Departemen::where(['id' => $karyawan->dept_id])->first();
        $cab = Cabang::where(['id' => $karyawan->cabang_id])->first();
        $this_pg = User::where(['id' => $form->pengganti_id])->first();
        $this_ct = User::where(['id' => $form->controller_id])->first();
    ?>
    <p align="right" style="margin-bottom:0px;font-size:9px;">F-SRU-HRD-002-R0</p>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="margin-left:0px;">
        <tr>
            <td align="center" valign="top" rowspan="3" width="15%">
                <img src="../public/assets/images/logo.png" alt="logo-hrd" height="50px"><br>
                <img src="../public/assets/images/tulisan-form-izin.jpg" alt="logo-hrd2" width="100px">
            </td>
            <td></td>
            <td rowspan="3" width="35%">
                <div class="judul">FORMULIR<br> PERMOHONAN CUTI</div>
            </td>
            <td></td>
            <td align="center" colspan="3" class="top bottom left right">
                <div style="color:red;font-weight:bold;">Diisi oleh HRD</div>
            </td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="20%"></td>
            <td align="right" width="7%" class="left">
                LV No
            </td>
            <td width="2%" align="right">
                :
            </td>
            <td width="16%" valign="bottom" class="right">
                &nbsp;..................................
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td align="right" class="left bottom">
                Valid
            </td>
            <td align="right" class="bottom">
                :
            </td>
            <td valign="bottom" class="bottom right">
                &nbsp;..................................
            </td>
        </tr>
       
    </table>
    <br>
    <hr>
    <br><br>
    <table border="0" width="100%" cellpadding="4" style="padding-right:20px;">
    <tr>
        <td width="13%" align="right">Nama</td>
        <td width="1%">:</td>
        <td width="32%" class="bottom">{{ $karyawan->name }}</td>
        <td width="5%"></td>
        <td width="17%" align="right">Divisi / Dept</td>
        <td width="1%">:</td>
        <td width="31%" class="bottom">{{ $dept->nama_departemen }}</td>
    </tr>
    <tr>
        <td align="right">NIK</td>
        <td>:</td>
        <td class="bottom">{{ $karyawan->nik }}</td>
        <td></td>
        <td align="right">Lokasi kerja</td>
        <td>:</td>
        <td class="bottom">{{ $cab->nama_cabang }}</td>
    </tr>
    <tr>
        <td align="right">Jabatan</td>
        <td>:</td>
        <td class="bottom">{{ $karyawan->jabatan }}</td>
        <td></td>
        <td align="right">Tanggal mulai bergabung</td>
        <td>:</td>
        <td class="bottom">{{ date('d-m-Y', strtotime($form->tanggal_bergabung)) }}</td>
    </tr>
    </table>
    <br>
    <?php 
        $begin = new DateTime($form->tanggal_awal);
        $end = new DateTime($form->tanggal_akhir);

        $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
        //mendapatkan range antara dua tanggal dan di looping
        $i  = 0;
        $x  = 0;
        $end= 1;

        foreach($daterange as $date){
            $daterange     = $date->format("Y-m-d");
            $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);
            //Convert tanggal untuk mendapatkan nama hari
            $day         = $datetime->format('D');
            //Check untuk menghitung yang bukan hari sabtu dan minggu
            if($day!="Sun") {
                $x += $end-$i; 
            }
            $end++;
            $i++;
        }
    ?>
    <table border="0" width="100%" cellpadding="4" style="padding-right:20px;">
        <tr>
            <td width="24%" align="right">Tanggal pengajuan cuti :</td>
            <td width="29%" class="bottom-strip" align="center">{{ date('d-m-Y',strtotime($form->tanggal_awal)) }}</td>
            <td width="5%" align="center">s/d</td>
            <td width="27%" class="bottom-strip" align="center">{{ date('d-m-Y',strtotime($form->tanggal_akhir)) }}</td>
            
            <td width="15%" align="right">(total : {{$x+1}} hari)</td>
        </tr>
        <tr>
            <td align="right">Alasan mengambil cuti :</td>
            <td colspan="4" class="bottom">{{ $form->alasan }}</td>
        </tr>
        <tr>
            <td align="right">Alamat selama cuti :</td>
            <td colspan="4" class="bottom">{{ $form->alamat }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4" class="bottom"></td>
        </tr>
        <tr>
            <td align="right">No. HP/ telp yg aktif :</td>
            <td colspan="4" class="bottom">{{ $form->no_telp }}</td>
        </tr>
        <tr>
            <td align="right">Jenis cuti yang diambil :</td>
            <td align="center"><span>
                @if($form->jenis_cuti == 1)
                    <img src="../public/assets/images/check.png" width="20px;" style="margin-top:3px;">Cuti biasa
                @else 
                    <img src="../public/assets/images/uncheck.png" width="20px;" style="margin-top:3px;">Cuti biasa
                @endif 
            </td>
            <td></td>
            <td>
                @if($form->jenis_cuti == 2)
                    <img src="../public/assets/images/check.png" width="20px;" style="margin-top:3px;">Pengganti tugas jaga
                @else 
                    <img src="../public/assets/images/uncheck.png" width="20px;" style="margin-top:3px;">Pengganti tugas jaga
                @endif 
            </td>
            <td>
                @if($form->jenis_cuti == 3)
                    <img src="../public/assets/images/check.png" width="20px;" style="margin-top:3px;">Cuti Khusus
                @else 
                    <img src="../public/assets/images/uncheck.png" width="20px;" style="margin-top:3px;">Cuti Khusus
                @endif 
            </td>
        </tr>
    </table>
    <p style="margin-left:50px;font-size:8pt;"><u>Catatan :</u></p>
    <p style="margin-left:50px;font-size:8pt;word-spacing:3px;"><i><b>1. Dokumen Pengajuan cuti yang sudah lengkap diterima HRD 1 (satu) bulan sebelum cuti dilaksanakan<br>
        &nbsp;&nbsp;&nbsp;(Bila belum lengkap akan dikembalikan ke ybs dan belum diperhitungkan tanggal terimanya oleh HRD)<br>
        2. Tandatangan, Nama & Tanggal wajib diisi pada kolom dibawah ini
    <b></i></p>


    <table border="0" width="100%" cellpadding="4" cellspacing="0" style="margin-left:75px;margin-right:120px;">
        <tr>
            <td class="left top bottom" align="center" width="20%">Pemohon</td>
            <td class="left top bottom" align="center" width="20%">KaCab/KaDept</td>
            <td class="left top bottom" align="center" width="20%">KaDiv</td>
            <td class="left top bottom" align="center" width="20%">Pengganti</td>
            <td class="left top bottom right" align="center" width="20%">HRD</td>
        </tr>
        <tr>
            <td class="left bottom" align="center">
                <br><br><br><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
            </td>
            <td class="left bottom" align="center">
                <br><br><br><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
            </td>
            <td class="left bottom" align="center">
                <br><br><br><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
            </td>
            <td class="left bottom" align="center">
                <br><br><br><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
            </td>
            <td class="left bottom right" align="center">
                <br><br><br><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
            </td>
        </tr>
        <tr>
            <td class="left bottom"><font size="7pt">Tgl: {{ date('d-m-Y',strtotime($form->created_at)) }}</font></td>
            <td class="left bottom"><font size="7pt">Tgl:</font></td>
            <td class="left bottom"><font size="7pt">Tgl:</font></td>
            <td class="left bottom"><font size="7pt">Tgl:</font></td>
            <td class="left bottom right"><font size="7pt">Tgl:</font></td>
        </tr>
    </table>
    <p style="margin-left:100px;">CC : Yth Pimpinan / Manajemen</p>
    <table border="0" width="100%" cellpadding="4" cellspacing="0" style="margin-left:75px;margin-right:120px;">
        <tr>
            <td colspan="3"><div style="color:red;font-weight:bold;" class="top-strip">Diisi oleh HRD</div></td>
        </tr>
        <tr>
            <td align="center" width="15%" bgcolor="#d7d9d7" class="top left bottom">No</td>
            <td bgcolor="#d7d9d7" class="top left bottom">Keterangan</td>
            <td width="18%" bgcolor="#d7d9d7" class="top left bottom right">Jumlah hari</td>
        </tr>
        <tr>
            <td align="center" class="left bottom">1</td>
            <td class="left bottom">Jumlah cuti tahun berjalan yg sudah diambil sebelumnya</td>
            <td class="left bottom right"></td>
        </tr>
        <tr>
            <td align="center" class="left bottom">2</td>
            <td class="left bottom">Jumlah sisa cuti tahunan berjalan</td>
            <td class="left bottom right"></td>
        </tr>
        <tr>
            <td align="center" class="left bottom">3</td>
            <td class="left bottom">Jumlah cuti bersama yang sudah terpotong</td>
            <td class="left bottom right"></td>
        </tr>
        <tr>
            <td align="center" class="left bottom">4</td>
            <td class="left bottom">Jumlah hari tidak masuk kerja alasan <b>sakit</b></td>
            <td class="left bottom right"></td>
        </tr>
        <tr>
            <td align="center" class="left bottom">5</td>
            <td class="left bottom">Jumlah hari tidak masuk kerja alasan <b>cuti khusus</b></td>
            <td class="left bottom right"></td>
        </tr>
        <tr>
            <td align="center" class="left bottom">6</td>
            <td class="left bottom">Jumlah <b>keterlambatan</b> masuk kerja</td>
            <td class="left bottom right"></td>
        </tr>
        <tr>
            <td align="center" class="left bottom">7</td>
            <td class="left bottom">Jumlah ijin <b>datang terlambat</b></td>
            <td class="left bottom right"></td>
        </tr>
        <tr>
            <td align="center" class="left bottom">8</td>
            <td class="left bottom">Jumlah ijin <b>pulang awal</b></td>
            <td class="left bottom right"></td>
        </tr>
    </table>
@if(!$cuti_detail->isEmpty())
    <div class="page-break"></div>
    <div style="font-size:11px;">
    <p align="right" style="font-size:9px;margin-bottom:0px;">F-SRU-HRD-003-R1</p>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="margin-left:0px;">
        <tr>
            <td align="center" valign="top" width="15%">
                <img src="../public/assets/images/logo.png" alt="logo-hrd" height="50px"><br>
                <img src="../public/assets/images/tulisan-form-izin.jpg" alt="logo-hrd2" width="100px">
            </td>
            <td>
                <div class="judul" style="margin-left:50px;margin-right:50px;">Form Serah Terima Pekerjaan Selama Cuti</div>
            </td>
            <td width="10%"></td>
        </tr>
    </table>
    <br>
    <hr>
    <?php
        $deskripsi = [];$pengganti = [];$controller = []; $ket = [];
        $i = 0;
        foreach($cuti_detail as $det)
        {
            $deskripsi[$i] = $det->deskripsi;
            $strpg = DB::table('users')->where(['id' => $det->pengganti_id])->first();
            $pengganti[$i] = $strpg->name;
            $strct = DB::table('users')->where(['id' => $det->controller_id])->first();
            $controller[$i] = $strct->name;
            $ket[$i] = $det->keterangan;
            $i++;
        }
        $length = count($deskripsi);
    ?>
    <br>
    <table border="1" width="100%" cellpadding="4" style="border-collapse: collapse;">
        <tr>
            <th align="center" width="8%">No</th>
            <th align="center" width="40%">Deskripsi Pekerjaan</th>
            <th align="center">Selama cuti<br>diback-up oleh</th>
            <th align="center">Controller</th>
            <th align="center">Keterangan</th>
        </tr>
        <?php for($i = 0 ; $i < $length ; $i++){ ?>
            <tr>
                <td height="20px" align="center"><?= $i+1; ?></td>
                <td><?= $deskripsi[$i]; ?></td>
                <td align="center"><?= $pengganti[$i]; ?></td>
                <td align="center"><?= $controller[$i]; ?></td>
                <td><?= $ket[$i]; ?></td>
            </tr>
        <?php $n = $i; } 
            $max = 8 - $length;
            $no = $n+2;
        ?>
        <?php for($i = 0 ; $i < $max ; $i++){ ?>
            <tr>
                <td height="20px" align="center"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php 
            $no++; } 
        ?>
    </table>
    <br>
    <table>
        <tr>
            <td>Jakarta,</td>
            <td class="bottom-strip" width="60px">{{date('d-m-Y', strtotime($form->created_at))}}</td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td>Yang menyerahkan tugas,</td>
            <td align="center">Yang menerima tugas pengganti,</td>
            <td align="center">Disetujui oleh Controller,</td>
        </tr>
        <tr>
            <td colspan="3">
                <br><br><br><br>
            </td>
        </tr>
        <tr>
            <td>({{ $karyawan->name }})</td>
            <td align="center">({{ $this_pg->name }})</td>
            <td align="center">({{ $this_ct->name }})</td>
        </tr>
    </table>
    <p>
        <b>PERNYATAAN</b><br>
        Kami yang bertandatangan diatas <br>
        1). Nama : <b><u>{{ $this_pg->name }}</u></b>, email kantor : <b><u>{{ $this_pg->email }}</u></b> <br>
        sebagai <b><u>karyawan yang menerima tugas</u></b> pengganti selama yang bersangkutan <br>
        melaksanakan cuti dan saya bersedia bertanggungjawab penuh untuk melaksanakan tugas yang dipercayakan kepada saya<br><br>
        2). Nama : <b><u>{{ $this_ct->name }}</u></b>, email kantor : <b><u>{{ $this_ct->email }}</u></b> <br>
        sebagai <b><u>karyawan Controller</u></b> yang bertanggungjawab untuk menjalankan control <br>
        kerja selama yang bersangkutan diatas melaksanakan cuti dan saya bersedia bertanggungjawab penuh untuk melakukan control <br>
        tugas yang dipercayakan kepada saya <br> <br>
        3). Nama : <b><u>{{ $karyawan->name }}</u></b>, email kantor : <b><u>{{ $karyawan->email }}</u></b> <br>
        sebagai <b><u>karyawan yang melaksanakan cuti</u></b>, maka saya wajib mengaktifkan HP dan wajib mengangkatnya, sehingga dapat <br>
        segera dihubungi guna membantu serta melancarkan tugas dan tanggungjawab saya di kantor selama menjalankan cuti <br> <br>
        4). Apabila ada terjadi masalah atau kendala akibat tindakan (kelalaian) kami, ataupun satu dari kami yang tidak dapat menjalankan <br>
        tugas dan tanggungjawab ini dengan baik maka kami siap untuk menerima sanksi tegas akibat kelalaian ini <br><br>
        5). Silahkan centang (<strong>V</strong>) status inventaris kendaraan : 
        <table width="100%" border="1" style="border-collapse: collapse;">
            <tr>
                <td width="10%" align="center">5.1</td>
                <td width="15%" align="center">@if($form->status_inventaris == 1) V @endif</td>
                <td>Kendaraan dari Perusahaan (<strong>selanjutnya silakan mengisi form F-SRU-HRD-046-R0</strong>)</td>
            </tr>
            <tr>
                <td align="center">5.2</td>
                <td align="center">@if($form->status_inventaris == 2) V @endif</td>
                <td>Kendaraan pribadi</td>
            </tr>
            <tr>
                <td align="center">5.3</td>
                <td align="center">@if($form->status_inventaris == 3) V @endif</td>
                <td>Tidak mendapatkan inventaris kendaraan</td>
            </tr>
        </table>
    </p>
    </div>
@endif

@if($inventaris != null)
    <div class="page-break"></div>
    <div style="font-size:12px;">
        <p align="right" style="font-size:9px;margin-bottom:0px;">F-SRU-HRD-047-R0</p>
        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="margin-left:0px;">
            <tr>
                <td align="center" valign="top" width="15%">
                    <img src="../public/assets/images/logo.png" alt="logo-hrd" height="50px"><br>
                    <img src="../public/assets/images/tulisan-form-izin.jpg" alt="logo-hrd2" width="100px">
                </td>
                <td>
                    <div class="judul" style="margin-left:50px;margin-right:50px;">Form Serah Terima Inventaris Selama Cuti</div>
                </td>
                <td width="10%"></td>
            </tr>
        </table>
        <br>
        <hr>
        <p>
            Bagi karyawan yang mendapatkan inventaris kendaraan dari Perusahaan, selama menjalankan cuti lebih dari 1 (satu) hari,<br>
            untuk menyerahkan kendaraan ke Dept GA sebagaimana dijelaskan dibawah ini :
        </p>

        <table width="100%" style="margin-right:20px">
            <tr>
                <td width="39%">1. Jenis kendaraan</td>
                <td width="1%"align="right">:</td>
                <td width="32%" class="bottom-strip">{{ $inventaris->jenis_kendaraan }}</td>
                <td width="28%"></td>
            </tr>
            <tr>
                <td>2. Nomor kendaraan</td>
                <td align="right">:</td>
                <td class="bottom-strip">{{ $inventaris->nomor_kendaraan }}</td>
                <td></td>
            </tr>
            <tr>
                <td>3. Kunci & STNK</td>
                <td align="right">:</td>
                <td class="bottom-strip">
                    @if($inventaris->kunci_stnk == 1)
                        Ada
                    @else 
                        Tidak
                    @endif
                </td>
                <td>(ada / tidak)</td>
            </tr>
            <tr>
                <td>4. Rencana diserahkan tanggal</td>
                <td align="right">:</td>
                <td class="bottom-strip">
                    {{ date('d-m-Y', strtotime($inventaris->tgl_serah)) }}
                </td>
                <td >(maksimal 1 hari sebelum cuti)</td>
            </tr>
            <tr>
                <td>5. Rencana lokasi penyerahan</td>
                <td align="right">:</td>
                <td class="bottom-strip">
                    {{ $inventaris->lokasi_serah }}
                </td>
                <td></td>
            </tr>
            <tr>
                <td>6. Rencana diterima kembali tanggal</td>
                <td align="right">:</td>
                <td class="bottom-strip">
                    {{ date('d-m-Y', strtotime($inventaris->tgl_kembali)) }}
                </td>
                <td >(setelah cuti)</td>
            </tr>
        </table>
        <br><br>
        <table>
            <tr>
                <td>Jakarta,</td>
                <td class="bottom-strip" width="60px">{{date('d-m-Y', strtotime($form->created_at))}}</td>
            </tr>
        </table>
        <br>
        <table border="0" width="100%" cellpadding="4" cellspacing="0" style="margin-left:60px;margin-right:100px;">
            <tr>
                <td class="left top bottom" align="center" width="25%">Pemohon</td>
                <td class="left top bottom" align="center" width="25%">Atasan</td>
                <td class="left top bottom" align="center" width="25%">Memeriksa - GA</td>
                <td class="left top bottom right" align="center" width="25%">Mengetahui - HRD</td>
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
                <td class="left bottom right"><font size="7pt">Nama:</font></td>
            </tr>
            <tr>
                <td class="left bottom" align="center"><font size="8pt">{{ date('d-m-Y',strtotime($form->created_at)) }}</font></td>
                <td class="left bottom"><font size="7pt">Tanggal:</font></td>
                <td class="left bottom"><font size="7pt">Tanggal:</font></td>
                <td class="left bottom right"><font size="7pt">Tanggal:</font></td>
            </tr>
        </table>
    </div>
@endif
    {{-- Form Deklarasi Covid-19  --}}
    <div class="page-break"></div>
    <div style="font-size: 9pt;">
        <h2 style="margin-bottom:0px;"><u><center>FORM DEKLARASI KESEHATAN<center></u></h2>
        <p style="margin-top:0px;"><center><font size="9pt">(Pencegahan Penyebaran Covid-19)</font></center></p>
        <br>
        <p style="margin-left: 40px;">Saya yang bertandatangan di bawah ini :</p>
        <table border="0" width="100%" cellpadding="4" cellspacing="0" style="margin-left:40px;margin-right:100px;">
            <tr>
                <td width="25%">Nama</td>
                <td width="1%">:</td>
                <td class="bottom" colspan="4">{{ $karyawan->name }}</td>
            </tr>
            <tr>
                <td>No.ID Karyawan</td>
                <td>:</td>
                <td class="bottom" colspan="4">{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td class="bottom" colspan="4">{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>:</td>
                <td class="bottom" colspan="4">
                    <?php 
                        $divisi = Divisi::where('id', $dept->divisi_id)->first();

                        if($divisi != null){
                            echo $divisi->nama_divisi;
                        }else {
                            echo "-";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td class="bottom" colspan="4">{{ $dept->nama_departemen }}</td>
            </tr>
            <tr>
                <td>Tanggal Mulai Bekerja</td>
                <td>:</td>
                <td class="bottom" colspan="4">{{ date('d-m-Y', strtotime($form->tanggal_bergabung)) }}</td>
            </tr>
            <tr>
                <td>Lokasi Kerja</td>
                <td>:</td>
                <td class="bottom" colspan="4">{{ $cab->nama_cabang }}</td>
            </tr>
            <tr>
                <td>Alamat Tinggal</td>
                <td>:</td>
                <td class="bottom" colspan="4">{{ $form->alamat }}</td>
            </tr>
            <tr>
                <td>Tanggal Cuti</td>
                <td>:</td>
                <td width="20%" class="bottom" align="center">{{ date('d-m-Y',strtotime($form->tanggal_awal)) }}</td>
                <td width="5%" align="center">s/d</td>
                <td width="20%" class="bottom" align="center">{{ date('d-m-Y',strtotime($form->tanggal_akhir)) }}</td>
                <td width="15%" align="right">({{$x+1}} Hari Kerja)</td>
            </tr>
        </table>
        <br>
        <p style="margin-left: 40px;margin-right:60px;" align="justify">
            Sehubungan dengan pengajuan cuti Saya kepada Perusahaan dengan mempertimbangkan kondisi pandemi 
            Covid-19 saat ini, maka dengan ini menyatakan bahwa Saya akan mengikuti dan mematuhi protokol 
            pencegahan COVID-19 selama Saya menjalankan cuti adalah sebagai berikut :
        </p>

        <table border="0" width="100%" cellpadding="4" cellspacing="0" style="margin-left:40px;margin-right:50px;">
            <tr>
                <td valign="top">1.</td>
                <td align="justify">
                    Menghindari tempat yang memiliki potensi penyebaran virus covid 19, 
                    seperti kerumunan orang atau tempat-tempat wisata, 
                    menghindari lokasi dengan ruangan tertutup dan minim cahaya matahari.
                </td>
            </tr>
            <tr>
                <td valign="top">2.</td>
                <td align="justify">
                    Selalu mematuhi protokol 5M yaitu <i>Mencuci tangan, Memakai masker, 
                    Menjaga jarak, Membatasi mobilitas dan interaksi dan Menjauhi kerumunan.</i>
                </td>
            </tr>
            <tr>
                <td valign="top">3.</td>
                <td align="justify">
                    Bersedia melakukan Rapid Test Swab Antigen (PCR Test jika diperlukan) 
                    secara mandiri setelah masa cuti dan melaporkan hasilnya berupa Surat 
                    Keterangan yang valid kepada HRD sebelum kembali bekerja.
                </td>
            </tr>
            <tr>
                <td valign="top">4.</td>
                <td align="justify">
                    Tidak memasuki lokasi bekerja sebelum mendapatkan konfirmasi dari HRD atas hasil test tersebut.
                </td>
            </tr>
            <tr>
                <td valign="top">5.</td>
                <td align="justify">
                    Melakukan isolasi ruang kerja selama 7 (tujuh) hari di ruangan yang telah disediakan oleh 
                    Perusahaan bagi Karyawan yang baru kembali bekerja dan telah melakukan 
                    Rapid Test Swab Antigen maupun PCR test.
                </td>
            </tr>
            <tr>
                <td valign="top">6.</td>
                <td align="justify">
                    Mengisi Form Self Assessment Resiko Covid-19 satu hari sebelum kembali bekerja.
                </td>
            </tr>
        </table>

        <p style="margin-left: 40px;margin-right:60px;" align="justify">
            Demikian pernyataan ini saya sampaikan dalam kondisi sehat, dan tanpa paksaan dari pihak manapun juga. <br><br>
            <u>Surabaya</u>, <u>{{ date('d-m-Y', strtotime($form->created_at)) }} </u> <br>
            Yang Menyatakan,
            <br>
            <br>
            <br>
            <i>Materai 10000</i>
            <br>
            <br>
            <br>
            <u>{{ $karyawan->name }}</u><br>
            Karyawan
        </p>
       
        
    </div>
</body>
</html>