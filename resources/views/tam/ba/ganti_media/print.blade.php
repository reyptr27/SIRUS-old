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
                height : 20px;
                padding-left:15px;                 
                padding-right:15px; 
            }
            table1, th1, td1 {
                
                border-collapse: collapse;
                height : 20px;
                padding-left:10px;                 
                padding-right:10px; 
            }

            body {
                border: 1px solid black;
                /* margin-left:-25px; */
                /* margin-right:-25px; */
                font-size: 16px;
            }

        </style>
        <table align="right" style="margin-top:-30px; padding-right:0px">
            <tr>
                <td>F-SRU-C-SBY-29</td>
            </tr>
        </table>
        
        <p align="center" style="font-size:24px; padding-top:10px; margin-bottom:-5px">
            <b>BERITA ACARA PENGGANTIAN MEDIA PRE-TREATMENT</b>
            <hr>
        </p>
        <p align="center" style="font-size:24px; margin-top:10px; margin-bottom:0px"> NO. 02.{{$ba->nomor}} </p>
        <br>
        <p style="font-size:16px; text-align:left; margin-left:20px; margin-right:20px" >
            Pada hari 
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

            dengan ini telah dilakukan penggantian Media Pre-Treatment dari <b>PT. SINAR RODA UTAMA</b> (Pihak Pertama)
            kepada <b>{{$ba->nama_rs}}</b> (Pihak Kedua), sebagai berikut :
        </p>
        <table width="95%" align="center" style="padding-left:0px">
            <tr style="background-color:#e8e8e8; margin-left:0px" >
                <td  width="8%" align="center" style="height:30px">NO.</td>
                <td  width="27%" align="center" style="height:30px">NAMA BARANG</td>
                <td width="17%" align="center"> JUMLAH</td>
                <td width="48%" align="center"> KETERANGAN</td>
            </tr>
            {{$i=1}}{{$j=0}}
            @if($ba->jumlah_carbon != 0)
            {{$j++}}
            @endif
            @if($ba->jumlah_resin != 0)
            {{$j++}}
            @endif
            @if($ba->jumlah_sand != 0)
            {{$j++}}
            @endif
            @if($ba->jumlah_pyrolox != 0)
            {{$j++}}
            @endif

            @if($ba->jumlah_carbon != 0)
            <tr>
                <td align="center" > {{$i}}</td>
                <td align="center" style="height:50px"> Carbon Active </td>
                <td align="center"> {{$ba->jumlah_carbon}} Sak </td>
                <td rowspan="{{$j}}" align="center" >{{$ba->keterangan}}</td>
            </tr>
            
            {{$i++}}
            @endif
            @if($ba->jumlah_resin != 0)
            <tr>
                <td align="center" > {{$i}}</td>
                <td align="center" style="height:50px"> Resin Cation </td>
                <td align="center"> {{$ba->jumlah_resin}} Sak </td>
                <!-- <td align="center" style="height:50px">{{$ba->keterangan}}</td> -->
            </tr>
            {{$i++}}
            @endif
            @if($ba->jumlah_sand != 0)
            <tr>
                <td align="center"> {{$i}}</td>
                <td align="center" style="height:50px"> Sand Filter </td>
                <td align="center"> {{$ba->jumlah_sand}} Sak </td>
                <!-- <td align="center" style="height:50px">{{$ba->keterangan}}</td> -->
            </tr>
            {{$i++}}
            @endif
            @if($ba->jumlah_pyrolox != 0)
            <tr>
                <td align="center" > {{$i}}</td>
                <td align="center" style="height:50px"> Pyrolox </td>
                <td align="center"> {{$ba->jumlah_pyrolox}} Sak </td>
                <!-- <td row-span="{{$i}}" align="center" style="height:50px">{{$ba->keterangan}}</td> -->
            </tr>
            {{$i++}}
            @endif
        </table>
        <p style="font-size:14px; text-align:left; margin-left:20px; margin-right:20px; margin-top:0px" >
            <i>
            * dalam keadaan berfungsi baik & normal
            </i>
        </p>
        <p style="font-size:16px; text-align:left; margin-left:20px; margin-right:20px">
            Demikian Berita Acara ini kami buat sebagai bentuk pelayanan perawatan kualitas dari unit 
            Water Treatment Reverse Osmosis System sebagai pendukung pelayanan dialysis.
        </p>
        <br><br>

        <p style="font-size:16px; text-align:left; margin-left:20px; margin-right:20px;">
            Surabaya,  {{date('d', strtotime($ba->created_at))}} 
            &nbsp;{{ getBulan(date('m', strtotime($ba->created_at) )) }}
            &nbsp;{{date('Y', strtotime($ba->created_at))}} 
        </p> <br>
        <table width=100% style="font-size:16px; margin-left:-5px;margin-right:0px; margin-top:-25px">
            <tr>
                <td colspan="3"  align="center" style="height:30px">
                    <b>PT. SINAR RODA UTAMA</b>
                </td>
                <td colspan="2"  align="center"><b>{{$ba->nama_rs}}</b></td>
            </tr>
            <tr>
                <td style="height:100px"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td width="20%"  align="center"><u>{{$ba->katam}}</u> <br> KA. TAM Area</td>
                <td width="21%"  align="center"><u>{{$ba->katek}}</u> <br> KA. TEKNISI</td>
                <td width="21%"  align="center" style="font-size:15px"><u>{{$ba->teknisi}}</u> <br>Teknisi Pelaksana</td>
                <td width="19%"  align="center"><u>.........................</u> <br><br></td>
                <td width="19%"  align="center"><u>.........................</u> <br><br></td>
            </tr>
        </table>




    </body>
</html>
