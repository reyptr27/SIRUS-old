<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            <td colspan="4" align="right">F-SRU-C-SBY-27</td>
        </tr>
        <tr>
            <td colspan="4" class="left top right bottom" align="center" style="font-size:24px;  padding-top:10px; padding-bottom:5px; font-weight:bold;">
                BERITA ACARA KALIBRASI MESIN
            </td>
        </tr>
        <tr>
            <td colspan="4" class="left right" align="center" style="font-size:24px; padding-top:10px; padding-bottom:0px">
                NO. 02.{{$ba->nomor}}
            </td>
        </tr>
        <tr>
            <td colspan="4" class="left right">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" class="left right" align="justify" style="line-height: 1.5; padding-left:20px; padding-right: 20px;">
                Pada hari ini <b>{{ hari_ini(date('D', strtotime($ba->tanggal) )) }}</b> tanggal <b>{{ terbilang(date('d', strtotime($ba->tanggal) )) }}</b> bulan 
                <b>{{ getBulan(date('m', strtotime($ba->tanggal) )) }}</b> tahun <b>{{ terbilang(date('Y', strtotime($ba->tanggal) ) )}}&nbsp;({{date('d-m-Y', strtotime($ba->tanggal))}}),</b>
                dengan ini telah dilakukan kalibrasi serta preventive maintenance pada mesin-mesin Hemodialisis di <b>{{$ba->nama_rs}}</b>, sebagai berikut :
            </td>
        </tr>
        <tr>
            <td colspan="4" class="left right">&nbsp;</td>
        </tr>

        {{-- DATA MESIN  --}}
        <tr>   
            <th class="left top right bottom" bgcolor="#e8e8e8" width="5%">NO.</th>
            <th class="left top right bottom" bgcolor="#e8e8e8" width="40%">NAMA BARANG</th>
            <th class="left top right bottom" bgcolor="#e8e8e8" width="30%">MERK / TYPE</th>
            <th class="left top right bottom" bgcolor="#e8e8e8" width="25%">NO SERI</th>
        </tr>

        @php $i=1; @endphp
        @foreach ($barang as $brg)
        <tr>
            <td class="left top right bottom" align="center"> 
                {{$i}}
            </td>
            <td class="left top right bottom" align="center"> 
                MESIN HEMODIALISIS 
            </td>
            <td class="left top right bottom" align="center">
                @if($brg->merk == 1 )
                        SURDIAL
                @elseif($brg->merk == 2 )
                        SURDIAL 55
                @elseif($brg->merk == 3 )
                        SURDIAL 55 PLUS
                @else
                        NCU-18
                @endif
            </td>
            <td class="left top right bottom" align="center">
                {{$brg->no_seri}}
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
        
        <tr>
            <td class="left right" colspan="4" style="line-height: 1.5;padding-left:20px;padding-right:20px;">
                <br>
                Hasil Pengujian / Kalibrasi menyatakan bahwa <b>MESIN HEMODIALISIS LAYAK PAKAI</b>. <br><br>

                Demikian Berita Acara ini kami buat sebagai bentuk pelayanan perawatan kualitas dari unit 
                Hemodialisis dan sebagai pendukung pelayanan dialysis.
                <br><br>
                Surabaya,  {{date('d', strtotime($ba->created_at))}} 
                &nbsp;{{ getBulan(date('m', strtotime($ba->created_at) )) }}
                &nbsp;{{date('Y', strtotime($ba->created_at))}} 
            </td>
        </tr>
        <tr>
            <td class="left right bottom" colspan="4">
                <table width=100% border="0" style="border-collapse: collapse; margin-left:-3px;margin-right:-3px;margin-bottom:-3px;">
                    <tr>
                        <td colspan="3" class="left right top bottom" align="center">
                            <b>PT. SINAR RODA UTAMA</b>
                        </td>
                        <td colspan="2" class="left right top bottom" align="center">
                            <b>{{$ba->nama_rs}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="left right top bottom" height="100px"></td>
                        <td class="left right top bottom"></td>
                        <td class="left right top bottom"></td>
                        <td class="left right top bottom"></td>
                        <td class="left right top bottom"></td>
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
        </tr>
    </table>
</body>
</html>