<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $mt_cctv->no_document }} </title> 
    
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                height : 20px;
                padding-left:10px;
                
               
            }

            body {
                font-size: 11px;
            }

        </style>
    </head>
    <body>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" >
            <tbody >
                <tr >
                    <td style="width:250px; text-align:center"  colspan="2" >
                        <img src="../public/assets/images/logo-baru.jpg"height="50"><br>
				        <img src="../public/assets/images/logo-baru-tulisan.jpg" height="25">
                    
                    </td>
                    <td   colspan="2" style="height:100px;">
                        <center><b>FORMULIR</b></center><br>
                        <center><b style="text-align:center">MAINTENANCE SERVER CCTV</b></center><br>
                        Edisi : 1<br><br>   
                        Tanggal : 2 Januari 2019<br><br>
                    
                    </td>
                    <td  colspan="2" style="height:100px;padding-left:10px;padding-top:10px">
                        Halaman 1 dari 1<br><br>
                        Nomor Document : F-SRU-ITS-17<br><br>
                        Nomor Revisi : 0<br><br>
                        Tanggal : - <br>
                    </td>
                </tr>
                
                <tr>
                    <td >Nama Server</td>
                    <td colspan="2"> : &nbsp; {{$mt_cctv->nama_server}}</td>
                    <td >Nomor </td>
                    <td colspan="2">: &nbsp; {{$mt_cctv->no_document}}</td>

                </tr>
                <tr>
                    <td >Lokasi</td>
                    <td colspan="2"> : &nbsp; {{$mt_cctv->lokasi}} </td>
                    <td >Tanggal</td>
                    <td colspan="2">: &nbsp; {{date('d - m - Y', strtotime($mt_cctv->tanggal))}} </td>
                </tr>
                <tr>
                    
                    <td>IT Officer</td>
                    <td colspan="2">
                        : &nbsp; @foreach($users as $user) {{$user->name}} @endforeach
                    </td>
                    <td >Atasan</td>
                    <td colspan="2">: &nbsp; @foreach($users as $user) {{$user->atasan->name}} @endforeach </td>    
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" style="text-align:center"> ITEM PEMERIKSAAN</td>
                    <td colspan="2" style="text-align:center">STATUS PEMERIKSAAN</td>
                    <td rowspan="2" style="text-align:center">TINDAKAN MAINTENANCE</td>
                    <td rowspan="2" style="text-align:center">PARAF</td>
                </tr>
                <tr>
                    <td style="text-align:center">OK</td>
                    <td style="text-align:center">N / OK</td>
                </tr>
                <tr>
                    <td colspan="2">1. Kondisi PC / DVR / NVR </td>
                        @if($mt_cctv->status1 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif                    
                    <td> {{$mt_cctv->tindakan1}} </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">2. Hasil Recording </td>
                    @if($mt_cctv->status2 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan2}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">3. Kapasitas Penyimpanan</td>
                        @if($mt_cctv->status3 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan3}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">4. Kondisi Adaptor </td>
                        @if($mt_cctv->status4 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan4}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">5. Kualitas Gambar Camera</td>
                        @if($mt_cctv->status5 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan5}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">6. Kondisi Camera </td>
                        @if($mt_cctv->status6 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan6}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">7. Kondisi Splitter </td>
                        @if($mt_cctv->status7 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan7}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">8. Kondisi Display ( TV / Monitor ) </td>
                        @if($mt_cctv->status8 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan8}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">9. Kabel Coaxial / UTP / VGA / HDMI</td>
                        @if($mt_cctv->status9 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan9}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">10. Keluhan dari User </td>
                        @if($mt_cctv->status10 == 1 )
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                            <td></td>
                        @else
                            <td></td>
                            <td style="text-align:center"><img src="../public/assets/images/centang.jpg"height="15"></td>
                        @endif
                    <td> {{$mt_cctv->tindakan10}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"> </td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"> </td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"> </td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"> </td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6"><center>CATATAN HASIL MAINTENANCE : </center></td>
                </tr>
                <tr>
                    <td colspan="6" style="height:200px;vertical-align: top; padding-top:10px ">
                       {{$mt_cctv->catatan}} 
                    </td>
                </tr>
            
                
            </tbody>
            
        </table>

    
    </div>
       

        
    </body>
</html>
