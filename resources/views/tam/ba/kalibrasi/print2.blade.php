<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $ba->nomor }}</title> 

        <style>
            /* border  */
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
    
        <table width="100%" border="0" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
            <tr>
                <td align="right">F-SRU-C-SBY-27</td>
            </tr>
            <tr>
                <td class="left top right bottom" align="center" style="font-size:24px;  padding-top:10px; padding-bottom:5px; font-weight:bold">
                    BERITA ACARA KALIBRASI MESIN
                </td>
            </tr>
            <tr>
                <td class="left right" align="center" style="font-size:24px; padding-top:10px; padding-bottom:0px">
                    NO. 02.{{$ba->nomor}}
                </td>
            </tr>
            <tr>
                <td class="left right" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td style="line-height: 1.5">
                    Pada hari ini <b>{{ hari_ini(date('D', strtotime($ba->tanggal) )) }}</b> tanggal <b>{{ terbilang(date('d', strtotime($ba->tanggal) )) }}</b> bulan 
                    <b>{{ getBulan(date('m', strtotime($ba->tanggal) )) }}</b> tahun <b>{{ terbilang(date('Y', strtotime($ba->tanggal) ) )}}&nbsp;({{date('d-m-Y', strtotime($ba->tanggal))}}),</b>
                    dengan ini telah dilakukan kalibrasi serta preventive maintenance pada mesin-meisn Hemodialisa di <b>{{$ba->nama_rs}}</b>, sebagai berikut :
                </td>
            </tr>
        </table>
    </body>
</html>
