<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $ba->nomor }}</title> 
    </head>
    <body>
        <?php          

            function bulanIndo($tgl){
                $tanggal = substr($tgl,8,2);
                $bulan = getBulan(substr($tgl,5,2));
                $tahun = substr($tgl,0,4);
                return $tanggal.' '.$bulan.' '.$tahun;		 
            }	
    
            function getBulan($bln){
                switch ($bln){
                    case 1: 
                        return "Januari";
                        break;
                    case 2:
                        return "Februari";
                        break;
                    case 3:
                        return "Maret";
                        break;
                    case 4:
                        return "April";
                        break;
                    case 5:
                        return "Mei";
                        break;
                    case 6:
                        return "Juni";
                        break;
                    case 7:
                        return "Juli";
                        break;
                    case 8:
                        return "Agustus";
                        break;
                    case 9:
                        return "September";
                        break;
                    case 10:
                        return "Oktober";
                        break;
                    case 11:
                        return "November";
                        break;
                    case 12:
                        return "Desember";
                        break;
                }
            }

            function hari_ini($hari){
                             
                switch($hari){
                    case 'Sun':
                        $hari_ini = "Minggu";
                    break;
             
                    case 'Mon':			
                        $hari_ini = "Senin";
                    break;
             
                    case 'Tue':
                        $hari_ini = "Selasa";
                    break;
             
                    case 'Wed':
                        $hari_ini = "Rabu";
                    break;
             
                    case 'Thu':
                        $hari_ini = "Kamis";
                    break;
             
                    case 'Fri':
                        $hari_ini = "Jumat";
                    break;
             
                    case 'Sat':
                        $hari_ini = "Sabtu";
                    break;
                    
                    default:
                        $hari_ini = "Tidak di ketahui";		
                    break;
                }
             
                return $hari_ini;
             
            }

            function penyebut($nilai) {
                $nilai = abs($nilai);
                $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                $temp = "";
                if ($nilai < 12) {
                    $temp = " ". $huruf[$nilai];
                } else if ($nilai <20) {
                    $temp = penyebut($nilai - 10). " Belas";
                } else if ($nilai < 100) {
                    $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
                } else if ($nilai < 200) {
                    $temp = " Seratus" . penyebut($nilai - 100);
                } else if ($nilai < 1000) {
                    $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
                } else if ($nilai < 2000) {
                    $temp = " Seribu" . penyebut($nilai - 1000);
                } else if ($nilai < 1000000) {
                    $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
                } else if ($nilai < 1000000000) {
                    $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
                } else if ($nilai < 1000000000000) {
                    $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
                } else if ($nilai < 1000000000000000) {
                    $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
                }     
                return $temp;
            }
         
            function terbilang($nilai) {
                if($nilai<0) {
                    $hasil = "minus ". trim(penyebut($nilai));
                } else {
                    $hasil = trim(penyebut($nilai));
                }     		
                return $hasil;
            }
        ?>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                height : 25px;
                padding-left:10px;                 
                padding-right:10px; 
            }
            table1, th1, td1 {
                
                border-collapse: collapse;
                height : 25px;
                padding-left:10px;                 
                padding-right:10px; 
            }

            body {
                /* border: 1px solid black; */
                /* margin-left:-25px; */
                /* margin-right:-25px; */
                font-size: 14px;
            }

        </style>
        <table align="right" style="margin-top:-30px; padding-right:-35px; font-size:12px">
            <tr>
                <td widt>F-SRU-C-SBY-33</td>
            </tr>
        </table>
        <center><img src="../public/assets/images/kop-surat.png"></center>
        <hr>
        
        <p align="center" style="font-size:18px; padding-top:10px; margin-bottom:-5px">
            <b>FORM PERMINTAAN PEMERIKSAAN CEK LAB</b>
        </p>
        <br>
        <p align="left" style="font-size:16px; margin-top:10px; margin-bottom:0px"> NO. 02.{{$ba->nomor}} </p>
        
        
        <table width="100%" align="center" style="padding-left:0px">
            <tr style="margin-left:0px" >
                <td  width="23%" align="left">Nama Pemohon</td>
                <td  width="36%" align="left">{{$ba->pemohon}}</td>
                <td width="23%" align="left"> Tanggal Permohonan</td>
                <td width="18%" align="left"> 
                    {{date('d', strtotime($ba->created_at))}} 
                    &nbsp;{{ getBulan(date('m', strtotime($ba->created_at) )) }}
                    &nbsp;{{date('Y', strtotime($ba->created_at))}} 
                </td>
            </tr>
            <tr>
                <td align="left"> Customer / Rumah Sakit</td>
                <td align="left"> {{$ba->nama_rs}} </td>
                <td align="left"> Kontak Person Customer / Rumah Sakit</td>
                <td align="left"></td>

            </tr>
            <tr>
                <td align="left"> Type Mesin / No Seri</td>
                <td align="left" colspan="3"> {{$ba->type}} </td>
            </tr>
            <tr>
                <td align="left"> Alamat Customer</td>
                <td align="left" colspan="3"> {{$ba->alamat}} </td>
            </tr>
            <tr>
                <td align="left" rowspan="6"> Pemeriksaan</td>
                <td align="left" colspan="3"> Tes / Pemeriksaan. Beri Tanda <img src="../public/assets/images/centang.jpg"height="15"> untuk tes yang diperlukan </td>
            </tr>
            <tr>

                <td align="left" colspan="2"> <label @if ($ba->pemeriksaan == 1 ) style="background-color: yellow;" @endif> 1. Tes Na dan K </label> </td>
                <td align="center"> @if ($ba->pemeriksaan == 1 ) <img src="../public/assets/images/centang.jpg"height="15"> @endif</td>
            </tr>
            <tr>
                <td align="left" colspan="2"> <label @if ($ba->pemeriksaan == 2 ) style="background-color: yellow;" @endif> 2. Tes air RO standar AAMI (lengkap) </label> </td>
                <td align="center">@if ($ba->pemeriksaan == 2 ) <img src="../public/assets/images/centang.jpg"height="15"> @endif</td>
            </tr>
            <tr>
                <td align="left" colspan="2"> <label @if ($ba->pemeriksaan == 3 ) style="background-color: yellow;" @endif>3. Lainnya : Mikrobiologi (TPC) </label</td>
                <td align="center">@if ($ba->pemeriksaan == 3 ) <img src="../public/assets/images/centang.jpg"height="15"> @endif</td>
            </tr>
            <tr>
                <td align="left" colspan="2"> <label @if ($ba->pemeriksaan == 4 ) style="background-color: yellow;" @endif> 4. Lainnya : Air Bersih (Kimia Kesehatan)</label></td>
                <td align="center">@if ($ba->pemeriksaan == 4 ) <img src="../public/assets/images/centang.jpg"height="15"> @endif</td>
            </tr>
            <tr>
                <td align="left" colspan="2" > <label @if ($ba->pemeriksaan == 5 ) style="background-color: yellow;" @endif> 5. Lainnya : @if ($ba->pemeriksaan == 5 ) {{$ba->lainnya}} @endif</label></td>
                <td align="center">
                
                
                @if ($ba->pemeriksaan == 5 ) <img src="../public/assets/images/centang.jpg"height="15"> @endif
                
                </td>
            </tr>
            <tr>
                <td align="left"> Nama Penerima Sampel</td>
                <td align="left">  </td>
                <td align="left"> Tanggal Terima</td>
                <td align="left"></td>
            </tr>
            <tr>
                <td align="left" rowspan="2"> Di test oleh (tulis pihak yang melakukan test)</td>
                <td align="left" colspan="2">
                    1. Pihak Ketiga : 
                    <b>
                        @if ($ba->pihak_ketiga == 1 ) PT. SUCOFINDO - Laboratory Surabaya @endif
                        @if ($ba->pihak_ketiga == 2 ) PERSADA LABORATORY - Mojokerto @endif
                        @if ($ba->pihak_ketiga == 3 ) Balai Besar Laboratorium Kesehatan(BBLK) - Surabaya @endif
                        @if ($ba->pihak_ketiga == 4 ) PT. CITO DIAGNOSTIKA UTAMA - Semarang @endif
                    </b>
                </td>
                <td align="left" valign="top" rowspan="2"> Tgl Selesai tes : </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    2. Pihak Internal : 
                    .................................................................................
                </td>
            </tr>
            
        </table>
        <table width="100%" align="center" style="padding-left:0px;padding-top:-2px">
            <tr style="margin-left:0px" >
                <td  width="25%" align="left">Nama Penerima Hasil Tes (Customer / Rumah Sakit)</td>
                <td  width="34%" align="left"></td>
                <td width="23%" align="left"> Tanggal terima hasil tes</td>
                <td width="18%" align="left"></td>
            </tr>    
        </table>
        <table width="100%" align="center" style="padding-left:0px;padding-top:-2px">
            <tr style="margin-left:0px" >
                <td  width="27%" align="center">
                    Pemohon <br><br><br><br><br>
                    ( {{$ba->pemohon}} ) <br>
                    Admin TAM
                </td>
                <td  width="27%" align="center">
                    Penerima Sampel <br><br><br><br><br>
                    (.................................)
                    ...................................
                </td>
                <td width="28%" align="center">
                    Penerima Hasil Tes <br><br><br><br><br>
                    (.................................)
                    ...................................
                </td>
                <td width="18%" align="center" valign="top" rowspan="2" height="9px"> Tembusan / Arsip PT. SRU
                </td>
            </tr>
            <tr>
                <td style="font-size:10px; padding-top:-10px; padding-bottom:-10px" align="center"> Tulis nama lengkap & jabatan</td>
                <td style="font-size:10px; padding-top:-10px; padding-bottom:-10px" align="center"> Tulis nama lengkap & jabatan</td>
                <td style="font-size:10px; padding-top:-10px; padding-bottom:-10px" align="center"> Tulis nama lengkap & jabatan</td>
            </tr>    
        </table>
        



    </body>
</html>
