<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $ba->no_document }}</title>
    <style>
        body {
            font-size: 14px;
        }
        .top {
            border-top: thin solid;
            border-color: black;
        }
        .bottom {
            border-bottom: thin solid;
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
    ?>

    <table width="100%" border="0" cellpadding="2" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td align="right" colspan="12"><strong>F-SRU-C-SBY-09</strong></td>
        </tr>
        <tr>
            <td align="center" colspan="12" style="padding-top:10px">
                <strong><u>BERITA ACARA SERAH TERIMA BARANG</u></strong><br>
                No: {{ $ba->no_document }}
            </td>
        </tr>
        <tr>
            <td colspan="12"></td>
        </tr>
        <tr>
            <td width="5%">&nbsp;</td>
            <td colspan="11">
                &nbsp;&nbsp;&nbsp;&nbsp;Pada hari ini <u> &nbsp;&nbsp;&nbsp;&nbsp;{{ hari_ini(date('D', strtotime($ba->created_at) )) }} &nbsp;&nbsp;&nbsp;&nbsp; </u>
                Tanggal <u>&nbsp;&nbsp;&nbsp;&nbsp; {{ date('d', strtotime($ba->created_at) ) }} &nbsp;&nbsp;&nbsp;&nbsp;</u>
                Bulan <u>&nbsp;&nbsp;&nbsp;&nbsp;{{ getBulan(date('m', strtotime($ba->created_at) )) }} &nbsp;&nbsp;&nbsp;&nbsp; </u>
                Tahum <u>&nbsp;&nbsp;&nbsp;&nbsp; {{ date('Y', strtotime($ba->created_at) ) }} &nbsp;&nbsp;&nbsp;&nbsp; </u>
                yang bertanda tangan <br> di bawah ini :
            </td>
            {{-- <td width="5%">&nbsp;</td> --}}
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td width="4%">&nbsp;</td>
            <td valign=top width="18%">Nama</td>
            <td valign=top width="1%">:</td>
            <td valign=top colspan="6" class="bottom">
                {{ $ba->penerima}}    
            </td>
            <td width="17%">&nbsp;</td>
            <td width="4%">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top>Jabatan</td>
            <td valign=top>:</td>
            <td valign=top colspan="6" class="bottom">
                {{$ba->jabatan}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top>Perusahaan</td>
            <td valign=top>:</td>
            <td valign=top colspan="6" class="bottom">
                PT. Sinar Roda Utama
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top>Nama Gudang</td>
            <td valign=top>:</td>
            <td valign=top colspan="6" class="bottom">
                {{$ba->nama_gudang}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top>Alamat</td>
            <td valign=top>:</td>
            <td valign=top colspan="6" class="bottom">
                {{ $ba->alamat_penerima}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="12"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="10">
                Dengan ini telah menerima barang yang diserahkan oleh :
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top>Nama</td>
            <td valign=top>:</td>
            <td valign=top colspan="6" class="bottom">
                {{ $ba->nama_pengirim}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top>Perusahaan</td>
            <td valign=top>:</td>
            <td valign=top colspan="6" class="bottom">
                {{$ba->perusahaan_pengirim}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top>Alamat</td>
            <td valign=top>:</td>
            <td valign=top colspan="6" class="bottom">
                {{ $ba->alamat_pengirim}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top>Document</td>
            <td valign=top>:</td>
            <td valign=top colspan="2" width="20%">
                - No. PL / Resi
            </td>
            <td valign="top" width="1%">:</td>
            <td valign="top" colspan="3" class="bottom">
                {{$ba->no_resi}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top colspan="2">
                - No. Container 
            </td>
            <td valign="top" width="1%">:</td>
            <td valign="top" colspan="3" class="bottom">
                {{$ba->no_container}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top colspan="2">
                - No. Seal  
            </td>
            <td valign="top" width="1%">:</td>
            <td valign="top" colspan="3" class="bottom">
                {{$ba->no_seal}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign=top colspan="2">
                - No. Surat jalan     
            </td>
            <td valign="top" width="1%">:</td>
            <td valign="top" colspan="3" class="bottom">
                {{$ba->no_surat_jalan}}
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="10">
                Dengan spesifikasi sebagai berikut :     
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="left top right bottom" align="center">No.</td>
            <td class="left top right bottom" align="center" colspan="3">Nama Barang</td>
            <td class="left top right bottom" align="center" colspan="3">Kuantitas</td>
            <td class="left top right bottom" align="center">Satuan</td>
            <td class="left top right bottom" align="center">Kondisi</td>
            <td class="left top right bottom" align="center">Keterangan</td>
            <td>&nbsp;</td>
        </tr>

        @php $i=1; $total=0 @endphp
        @foreach($barang as $brg)
            <tr>
                <td>&nbsp;</td>
                <td class="left top right bottom" align="center">{{$i}}</td>
                <td class="left top right bottom" colspan="3">{{$brg->nama_barang}}</td>
                <td class="left top right bottom" align="center" colspan="3">{{$brg->kuantitas}}</td>
                <td class="left top right bottom" align="center"> {{$brg->satuan}} </td>
                <td class="left top right bottom" align="center"> 
                @if($brg->kondisi == 1 )
                    Baik
                @else
                    Tidak Baik
                @endif
                </td>
                <td class="left top right bottom"> {{$brg->keterangan}} </td>
                <td>&nbsp;</td>
            </tr>
            @php
                $i++;
                $total=$total+$brg->kuantitas;
            @endphp
        @endforeach 

        <tr>
            <td>&nbsp;</td>
            <td class="left top right bottom" colspan="4" align="center">Total</td>
            <td class="left top right bottom" align="center" colspan="3"> {{$total}} </td>
            <td class="left top right bottom"></td>
            <td class="left top right bottom"></td>
            <td class="left top right bottom right"></td>
            <td>&nbsp;</td>
        </tr>  
        <tr>
            <td colspan="12">&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="10">
                Barang tersebut telah diterima *(
                @if($ba->sesuai == 1 )
                    sesuai / <strike>tidak sesuai</strike>
                @else
                    <strike>sesuai</strike> / tidak sesuai
                @endif
                ) :
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Selisih</td>
            <td>:</td>
            <td colspan="7" class="bottom">{{ $ba->selisih}}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Cacat</td>
            <td>:</td>
            <td colspan="7" class="bottom">{{ $ba->cacat}}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="11">
                *coret yang tidak perlu
                <br><br>
                Demikian Berita Acara Serah Terima Barang ini kami buat untuk dipergunakan 
                sebagaimana mestinya
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="8">Diterima dan Diperiksa oleh :</td>
            <td colspan="2">Diserahkan oleh :</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">&nbsp;&nbsp;Receiving</td>
            <td colspan="3">&nbsp;&nbsp;Inventory</td>
            <td colspan="4">Ka. Gudang</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="12"><br><br><br><br></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">(...................)</td>
            <td colspan="3">(...................)</td>
            <td colspan="4">(...................)</td>
            <td>(......................)</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="12">&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5">&nbsp;</td>
            <td colspan="4">
                &nbsp;&nbsp;Mengetahui <br>
                SCM Logistic
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="12"><br><br><br><br></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"></td>
            <td colspan="4">(......................)</td>
            <td></td>
            <td></td>
        </tr>
    </table>
</body>
</html>