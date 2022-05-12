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
        <table align="right" style="margin-top:-30px; padding-right:50px">
            <tr>
                <td>F-SRU-C-SBY-30</td>
            </tr>
        </table>
        
        <table width="100%" class="table table-bordered" style="padding-bottom:0px">
            <tbody>
                <tr>
                    <td align="center"><b style="font-size:24px; margin-top:10px; margin-bottom:0px">BERITA ACARA FLUSHING PIPA</b></td>
                </tr>
                <tr>
                    <td> <p align="center" style="font-size:24px; margin-top:0px; margin-bottom:0px"> NO. 02.{{$ba->nomor}} </p><br>
                        <table1 class="table1" style="margin-top:0px">
                            <tr1>
                                <td1 align="left">
                                    <p style="font-size:16px; text-align:left">
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
                                            &nbsp;({{date('d-m-Y', strtotime($ba->tanggal))}}).
                                        </b>

                                        Dengan ini kami sampaikan bahwa telah dilakukan maintenance pada instalasi System RO
                                         ( Reverses Osmosis) & Hemodialisa untuk <b>{{$ba->nama_rs}}</b>.
                                    </p>
                                    
                                </td1>
                            </tr1>
                        </table1>
                        <p>
                            <table width="80%" align="center" style="padding-left:0px">
                                <tr style="background-color:#e8e8e8; margin-left:0px" >
                                    <td  width="10%" align="center" style="height:30px">No.</td>
                                    <td align="center"> Jenis Pekerjaan</td>
                                </tr>
                                <tr>
                                    <td align="center" > 1</td>
                                    <td align="center" style="height:50px">{{$ba->jenis_pekerjaan}}</td>
                                </tr>
                            </table>
                        </p>
                        <br>
                        <p style="font-size:16px; margin-top:0px; margin-bottom:120px">
                            Demikian kami sampaikan bahwa pekerjaan pada point di atas telah kami laksanakan dengan baik.
                        </p>
                        <p style="font-size:16px; margin-top:0px;">
                           Surabaya,  {{date('d', strtotime($ba->tanggal))}} 
                           &nbsp;{{ getBulan(date('m', strtotime($ba->tanggal) )) }}
                           &nbsp;{{date('Y', strtotime($ba->tanggal))}} 
                        </p>
                        
                        <table width=100% style="font-size:16px; padding-bottom:300px; margin-left:-15px;margin-right:-20px">
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
                                <td width="20%"  align="center"><u>{{$ba->katek}}</u> <br> KA. TEKNISI</td>
                                <td width="22%"  align="center"><u>{{$ba->teknisi}}</u> <br>Teknisi Pelaksana</td>
                                <td width="19%"  align="center"><u>.........................</u> <br><br></td>
                                <td width="19%"  align="center"><u>.........................</u> <br><br></td>
                            </tr>
                        </table>



                    </td>
                </tr>
                
            </tbody>
        </table>





    </body>
</html>
