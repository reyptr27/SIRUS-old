<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $ba->no_document }}</title> 
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
        <p align="right" style="margin-top:0px;padding-top:-30px"><b> F-SRU-C-SBY-09 </b></p>
        <p align="center" style="font-size:14px;padding-top:-20px">
        
        <u><b>BERITA ACARA SERAH TERIMA BARANG</b></u>
        <br>
            No: {{ $ba->no_document }}
        </p>
        
        <p style="padding-left: 40px; padding-right: 40px;font-size:14px; margin-bottom:1px">
        
        &nbsp;&nbsp;&nbsp;&nbsp;Pada hari ini <u> &nbsp;&nbsp;&nbsp;&nbsp;{{ hari_ini(date('D', strtotime($ba->created_at) )) }} &nbsp;&nbsp;&nbsp;&nbsp; </u>
            Tanggal <u>&nbsp;&nbsp;&nbsp;&nbsp; {{ date('d', strtotime($ba->created_at) ) }} &nbsp;&nbsp;&nbsp;&nbsp;</u>
            Bulan <u>&nbsp;&nbsp;&nbsp;&nbsp;{{ getBulan(date('m', strtotime($ba->created_at) )) }} &nbsp;&nbsp;&nbsp;&nbsp; </u>
            Tahum <u>&nbsp;&nbsp;&nbsp;&nbsp; {{ date('Y', strtotime($ba->created_at) ) }} &nbsp;&nbsp;&nbsp;&nbsp; </u>
            yang bertanda tangan di bawah ini :
             <br>
             
            <span style="margin-left: 40px;">
            

                <table style="line-height: 15px; margin-left: 20px">                    
                    <tbody>
                        <tr>
                            <td valign=top>Nama</td>
                            <td valign=top><span style="margin-left: 45px;">: &nbsp;</span></td>
                            <td valign=top style="width: 300px;border-bottom:1px solid black">
                                {{ $ba->penerima}}              
                            </td>
                        </tr>

                        <tr>
                           <td valign=top>Jabatan</td>
                            <td valign=top><span style="margin-left: 45px;">:</span></td>
                            <td valign=top style="width: 300px;border-bottom:1px solid black">  
                                {{$ba->jabatan}}
                            </td>
                        </tr>

                        <tr>
                           <td valign=top>Perusahaan</td>
                            <td valign=top><span style="margin-left: 45px;">:</span></td>
                            <td valign=top style="width: 300px;border-bottom:1px solid black">  
                               PT. Sinar Roda Utama
                            </td>
                        </tr>
                        <tr>
                           <td valign=top>Nama Gudang</td>
                            <td valign=top><span style="margin-left: 45px;">:</span></td>
                            <td valign=top style="width: 300px;border-bottom:1px solid black">  
                               {{$ba->nama_gudang}}
                            </td>
                        </tr>

                        <tr>
                           <td valign=top>Alamat</td>
                            <td valign=top><span style="margin-left: 45px;">:</span></td>
                            <td valign=top style="width: 300px;border-bottom:1px solid black">
                            {{ $ba->alamat_penerima}}</td>
                        </tr>                       
                        
                    </tbody>
                </table>  
                       
        
                Dengan ini telah menerima barang yang diserahkan oleh :
                
                <table style="line-height: 15px; margin-left: 20px">                    
                    <tbody>
                        <tr>
                        <td valign=top>Nama</td>
                        <td valign=top><span style="margin-left: 65px;">: &nbsp;</span></td>
                        <td valign=top style="width: 300px;border-bottom:1px solid black">
                            {{ $ba->nama_pengirim}}              
                        </td>
                        </tr>

                        <tr>
                           <td valign=top>Perusahaan</td>
                            <td valign=top><span style="margin-left: 65px;">:</span></td>
                            <td valign=top style="width: 300px;border-bottom:1px solid black">  
                                {{$ba->perusahaan_pengirim}}
                            </td>
                        </tr>

                        <tr>
                           <td valign=top>Alamat</td>
                            <td valign=top><span style="margin-left: 65px;">:</span></td>
                            <td valign=top style="width: 300px;border-bottom:1px solid black">  
                               {{ $ba->alamat_pengirim}}
                            </td>
                        </tr>                           
                        
                    </tbody>
                </table>
                <table style="line-height: 15px; margin-left: 20">                    
                    <tbody>
                        <tr>
                            <td valign=top>Document</td>
                            <td valign=top><span style="margin-left: 65px;">: &nbsp;</span></td>
                            <td valign=top>
                                - No. PL / Resi               
                            </td>
                            <td>:</td>
                            <td style="width: 195px;border-bottom:1px solid black">{{$ba->no_resi}}</td>
                        </tr>
                        <tr>
                           <td valign=top></td>
                            <td valign=top><span style="margin-left: 65px;"> &nbsp;</span></td>
                            <td valign=top>
                                - No. Container               
                            </td>
                            <td>:</td>
                            <td style="width: 180px;border-bottom:1px solid black">{{$ba->no_container}}</td>
                        </tr>
                        <tr>
                        <td valign=top></td>
                            <td valign=top><span style="margin-left: 65px;"> &nbsp;</span></td>
                            <td valign=top>
                                - No. Seal               
                            </td>
                            <td>:</td>
                            <td style="width: 180px;border-bottom:1px solid black">{{$ba->no_seal}}</td>
                        </tr>
                        <tr>
                        <td valign=top></td>
                            <td valign=top><span style="margin-left: 65px;"> &nbsp;</span></td>
                            <td valign=top>
                                - No. Surat jalan               
                            </td>
                            <td>:</td>
                            <td style="width: 180px;border-bottom:1px solid black">
                            {{$ba->no_surat_jalan}}</td>
                        </tr>               
                        
                    </tbody>
                </table>
                <br>
                Dengan spesifikasi sebagai berikut :
                
                <table style="line-height: 15px" border="1" width="100%" cellspacing="0" cellpadding="2">                    
                    <tbody>
                        <tr align="center">
                            <td width="5%">No.</td>
                            <td width="30%" valign=top>Nama Barang</td>
                            <td width="15%" valign=top>Kuantitas</td>
                            <td width="15%" valign=top>Satuan</td>
                            <td width="10%" valign=top>Kondisi</td>
                            <td width="25%" valign=top>keterangan</td>
                        </tr>

                        
                        @php $i=1; $total=0 @endphp
                        @foreach($barang as $brg)
                        <tr>
                            <td align="center">{{$i}}</td>
                            <td >{{$brg->nama_barang}}</td>
                            <td align="center">{{$brg->kuantitas}}</td>
                            <td align="center"> {{$brg->satuan}} </td>
                            <td align="center"> 
                            @if($brg->kondisi == 1 )
                                Baik
                            @else
                                Tidak Baik
                            @endif
                            </td>
                            <td> {{$brg->keterangan}} </td>
                        </tr>
                        @php
                        $i++;
                        $total=$total+$brg->kuantitas;
                        @endphp
                        @endforeach 

                        
                        <tr>
                            <td colspan="2" align="center">Total</td>
                            <td align="center"> {{$total}} </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>                                           
                        
                    </tbody>
                </table>
                    <br>
                Barang tersebut telah diterima *(
                    @if($ba->sesuai == 1 )
                    sesuai / <strike>tidak sesuai</strike>
                    @else
                    <strike>sesuai</strike> / tidak sesuai
                    @endif
                    ) :
                
                <table style="line-height: 15px; margin-left: 20">                    
                    <tbody>
                        <tr>
                        <td valign=top>Selisih </td>
                        <td valign=top><span style="margin-left: 30px;">: &nbsp;</span></td>
                        <td valign=top style="width: 330px;border-bottom:1px solid black">
                            {{ $ba->selisih}}              
                        </td>
                        </tr>

                        <tr>
                           <td valign=top>Cacat</td>
                            <td valign=top><span style="margin-left: 30px;">:</span></td>
                            <td valign=top style="width: 330px;border-bottom:1px solid black">
                            {{ $ba->cacat}}              
                        </td>
                        </tr>                                        
                        
                    </tbody>
                </table>            
                
                *coret yang tidak perlu
                <br><br>
                Demikian Berita Acara Serah Terima Barang ini kami buat untuk dipergunakan 
                sebagaimana mestinya
                
                <span style="margin-left:40px">Diterima dan Diperiksa oleh : </span>
                <span style="margin-left:245px">Diserahkan oleh :</span>
                    <table cellpadding="10" width="100%">
                        <tbody>
                            
                            <tr>
                                <td width="15%">Receiving</td>
                                <td width="15%">Inventory</td>
                                <td width="20%">Ka. Gudang</td>
                                <td width="5%"></td>
                                <td width="20%"></td>

                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            
                            <tr>                            
                                <td>(.................)</td>
                                <td>(.................)</td>
                                <td>(.................)</td>
                                <td></td>
                                <td>(.................)</td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <p align="center">                    
                        Mengetahui <br>
                        SCM Logistic <br><br><br><br>
                        (.....................)
                    </p>  

            </span>
        </p>
    </body>
</html>
