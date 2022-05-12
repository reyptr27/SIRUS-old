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
           

            body {
                border: 1px solid black;
                /* margin-left:-25px; */
                /* margin-right:-25px; */
                font-size: 16px;
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
        <table align="right" style="margin-top:-30px; padding-right:-35px">
            <tr>
                <td>F-SRU-C-SBY-27</td>
            </tr>
        </table>
        
        <p align="center" style="font-size:24px; padding-top:10px; margin-bottom:-5px">
            <b>BERITA ACARA KALIBRASI MESIN</b>
            <hr>
        </p>
        <p align="center" style="font-size:24px; margin-top:10px; margin-bottom:0px"> NO. 02.{{$ba->nomor}} </p>
        <br>
        <p style="font-size:16px; text-align:left; margin-left:20px; margin-right:20px; line-height: 1.5" >
            Pada hari ini 
            <b>
                
                {{ hari_ini(date('D', strtotime($ba->tanggal) )) }}
                
            </b>
            tanggal 
            <b>
                
                {{ terbilang(date('d', strtotime($ba->tanggal) )) }} 
                
            </b> 
            bulan 
            <b>
                
                {{ getBulan(date('m', strtotime($ba->tanggal) )) }} 
                
            </b>
            tahun
            <b>
                    
                {{ terbilang(date('Y', strtotime($ba->tanggal) ) )}} 
                &nbsp;({{date('d-m-Y', strtotime($ba->tanggal))}}),
            </b>

            dengan ini telah dilakukan kalibrasi serta preventive maintenance 
            pada mesin-meisn Hemodialisa
            di <b>{{$ba->nama_rs}}</b>, sebagai berikut :
        </p>
        <table width="100%" align="center" style="border: 1px solid black; padding-left:0px; padding-right:15px;margin-left:30px;" 
        border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr style="border-collapse:collapse; background-color:#e8e8e8; margin-left:0px;border: 1px solid black;" >
                <td  width="5%" align="center" style="height:20px;border: 1px solid black;">NO.</td>
                <td  width="40%" align="center" style="border: 1px black;height:20px">NAMA BARANG</td>
                <td width="30%" align="center" style="border: 1px black;"> MERK / TYPE</td>
                <td width="25%" align="center" style="border: 1px black;"> NO SERI</td>
            </tr>
            <br><br><br>
            @php $i=1; @endphp
            @foreach ($barang as $brg)
            <tr style="border: 1px solid black;">
                <td width="5%" align="center" style="border: 1px black;padding-left:15px; padding-right:15px;" > 
                {{$i}}</td>
                <td width="40%" align="center" style="border: 1px black;"> MESIN HEMODIALISA </td>
                <td width="30%" align="center" style="border: 1px black;">
                        @if($brg->merk == 1 )
                                SURDIAL
                        @elseif($brg->merk == 2 )
                                SURDIAL 55
                        @else
                                SURDIAL 55 PLUS
                        @endif
                </td>
                <td width="25%" align="center" style="border: 1px black;height:20px"> {{$brg->no_seri}} </td>
                
            </tr>
             
              
            @php $i++; @endphp
            @endforeach        
        </table> 
            <br>
        <p style="font-size:16px; text-align:left; margin-left:20px; margin-right:20px">
           Hasil Pengujian / Kalibrasi menyatakan bahwa <b>MESIN HEMODIALISA LAYAK PAKAI</b>.
        </p>
        <p style="font-size:16px; text-align:left; margin-left:20px; margin-right:20px;line-height: 1.5">
            Demikian Berita Acara ini kami buat sebagai bentuk pelayanan perawatan kualitas dari unit 
            Hemodialisa dan sebagai pendukung pelayanan dialysis.
        </p> <br>
        <table width=100% border=0 style="font-size:16px; margin-left:-5px;margin-right:0px; margin-top:-25px;
         padding-top:10px; padding-left:0px; padding-right:0px;">
        <th>
            <td>
            
        <p style="font-size:16px; text-align:left; margin-left:20px; margin-right:20px; padding-buttom:15px">
            Surabaya,  {{date('d', strtotime($ba->created_at))}} 
            &nbsp;{{ getBulan(date('m', strtotime($ba->created_at) )) }}
            &nbsp;{{date('Y', strtotime($ba->created_at))}} 
        </p> <br>
        <table width=100% style="font-size:16px; margin-left:-5px;margin-right:0px; margin-top:-25px; border-collapse:collapse; padding-left:10px;">
            <tr style="border: 1px solid black;">
                <td colspan="3"  align="center" style="border: 1px solid black;height:30px">
                    <b>PT. SINAR RODA UTAMA</b>
                </td>
                <td colspan="2"  align="center" style="border: 1px solid black;"><b>{{$ba->nama_rs}}</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid black;height:100px"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
            </tr>
            <tr>
                <td width="20%"  align="center"style="border: 1px solid black;"><u>........................</u> <br> KA. TAM Area</td>
                <td width="21%"  align="center"style="border: 1px solid black;"><u>{{$ba->katek}}</u> <br> KA. TEKNISI</td>
                <td width="21%"  align="center" style="border: 1px solid black;font-size:15px"><u>{{$ba->teknisi}}</u> <br>Teknisi Pelaksana</td>
                <td width="19%"  align="center"style="border: 1px solid black;"><u>.........................</u> <br><br></td>
                <td width="19%"  align="center"style="border: 1px solid black;"><u>.........................</u> <br><br></td>
            </tr>
        </table>
            </td>
        </th>
        </table>




    </body>
</html>
