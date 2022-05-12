<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $pengadaan->no_document }} </title> 
        <?php
            $login = Auth::user();
        ?>
    
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                height : 20px;
                padding-left:10px;                 
            }

            body {
                font-size: 12px;
            }

        </style>
    </head>
    <body>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" >
            <tbody >
                <tr >
                    <td style="width:220px; text-align:center"  colspan="2" >
                        <img src="../public/assets/images/logo-baru.jpg"height="50"><br>
				        <img src="../public/assets/images/logo-baru-tulisan.jpg" height="25">
                    
                    </td>
                    <td   colspan="2" style="height:100px;">
                        <center><b>FORMULIR</b></center><br>
                        <center><b style="text-align:center">Pengadaan Perangkat IT</b></center><br>
                        Edisi : 1<br><br>   
                        Tanggal : 20 Februari 2019<br><br>
                    
                    </td>
                    <td  colspan="2" style="width:220px; height:100px;padding-left:10px;padding-top:10px">
                        Halaman 1 dari 1<br><br>
                        Nomor Document : F-SRU-ITS-03<br><br>
                        Nomor Revisi : 0<br><br>
                        Tanggal : - <br>
                    </td>
                </tr>
                
                <tr>
                    <td >Tanggal</td>
                    <td colspan="2"> : &nbsp; {{date('d - M - Y', strtotime($pengadaan->created_at))}}</td>
                    <td >No. ID Pemohon </td>
                    <td colspan="2">: &nbsp; @foreach($users as $user) {{$user->nik}} @endforeach</td>

                </tr>
                <tr>
                    <td >Nama</td>
                    <td colspan="2"> : &nbsp;  @foreach($users as $user) {{$user->name}} @endforeach</td>
                    <td >Email</td>
                    <td colspan="2">: &nbsp;  @foreach($users as $user) {{$user->email}} @endforeach</td>
                </tr>
                <tr>
                    
                    <td>Jabatan</td>
                    <td colspan="2">
                        : &nbsp; @foreach($users as $user) {{$user->jabatan}} @endforeach
                    </td>
                    <td >Departemen</td>
                    <td colspan="2">: &nbsp; @foreach($users as $user) {{$user->dept->nama_departemen}} @endforeach </td>    
                </tr>
                <tr>
                    
                    <td>Perusahaan</td>
                    <td colspan="2">
                        : &nbsp; PT. Sinar Roda Utama
                    </td>
                    <td >Cabang</td>
                    <td colspan="2">: &nbsp; @foreach($users as $user) {{$user->cabang->nama_cabang}} @endforeach </td>    
                </tr>
                <tr>
                    
                <td  colspan="6" style="height:20px;padding-left:10px;padding-top:10px;padding-bottom:10px">
                        Jenis Pengajuan : <br>
                        [ 
                        @foreach($jenis as $jp) 
                            
                            @if($jp->kode == "Hardware") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                            @else
                                &nbsp;&nbsp;
                            @endif
                            
                        @endforeach 
                        ] Hardware 
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp; 
                        [ 
                        @foreach($jenis as $jp) 
                            
                            @if($jp->kode == "Software") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                            @else
                                &nbsp;&nbsp;
                            @endif
                            
                        @endforeach 
                        ] Software 
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp; 
                        [ 
                        @foreach($jenis as $jp) 
                            
                            @if($jp->kode == "Consumables") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                            @else
                                &nbsp;&nbsp;
                            @endif
                            
                        @endforeach 
                        ] Consumables 
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                             &nbsp;&nbsp;&nbsp;&nbsp;
                        [ 
                        @foreach($jenis as $jp) 
                            
                            @if($jp->kode == "Service") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                            @else
                                &nbsp;&nbsp;
                            @endif
                            
                        @endforeach 
                        ] Service 
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                             &nbsp;&nbsp;&nbsp;&nbsp;
                        [ 
                        @foreach($jenis as $jp) 
                            
                            @if($jp->kode == "Email") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                            @else
                                &nbsp;&nbsp;
                            @endif
                            
                        @endforeach 
                        ] Email 
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;

                    </td>
                    
                </tr>
                
                <tr>
                    <td colspan="3" rowspan="2" valign="top" style="padding-top:10px" >
                     Diskripsi : <br><br>
                     {{$pengadaan->deskripsi}}
                     </td>
                    <td colspan="3" style="" >IT Officer : </td>
                    
                </tr>
                <tr>
                    <td colspan="3" valign="top" style="height:80px;">Verifikasi Masalah : </td>
                    
                </tr>
                <tr>
                    <td colspan="3" valign="top" style="height:80px;" > 
                    Alasan permohonan : <br><br>
                    {{ $pengadaan->akibat }}
                     </td>  
                    <td colspan="3" valign="top" > Usulan Penanganan :  </td>                   
                    
                </tr>
                <tr>
                    <td colspan="2" valign="top" style="height:80px;" >
                        Pemohon : <br><br><br><br><br><br>
                        ( @foreach($users as $user) {{$user->name}} @endforeach ) 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>  
                    <td colspan="2" valign="top" > Atasan pemohon :  <br><br><br><br><br><br>
                        ( @foreach($users as $user) @if($user->atasan_id != null) {{$user->atasan->name}} @endif @endforeach ) 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>

                    <td colspan="2" valign="top" > Kepala Divisi / BOM : <br><br><br><br><br><br> 
                        {{-- ( Herman Harsono ) --}}
                        (  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>                   
                    
                </tr>
                <tr>
                    <td colspan="3" rowspan="2" valign="top">
                        [&nbsp;&nbsp;] Sesuai prosedur <br>
                        [&nbsp;&nbsp;] Sesuai prosedur dengan Catatan <br>
                        [&nbsp;&nbsp;] Tidak sesuai dengan kebijakan dan prosedur
                    </td>
                    <td colspan="3" rowspan="5" valign="top" >IT Moderator : 
                        <br><br><br><br><br><br><br>
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/

                    </td>
                </tr>
                <tr></tr>
                <tr>
                    <td colspan="3" >
                    Estimasi Biaya : </td>
                </tr>
                <tr>
                    <td colspan="3" rowspan="2" valign="top">Catatan : </td>
                </tr>
                <tr></tr>
                
                <tr>
                    <td colspan="3"  valign="top">
                        Hasil Permohonan : <br> 
                        [&nbsp;&nbsp;] Disetujui
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        [&nbsp;&nbsp;] Ditolak 

                    </td>
                    <td colspan="3" rowspan="2" valign="top" >Direksi : 
                        <br><br><br><br><br><br>
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/

                    </td>
                </tr>
                
                <tr>
                    <td colspan="3">Catatan : <br><br><br><br> </td>
                </tr>

                <tr>
                    <td colspan="6"> Dibawah ini diisi setelah perangkat telah diterima oleh pemohon.</td>
                </tr>
                
                <tr>
                
                    <td colspan="3" style="padding-bottom:10px"> Telah diterima oleh pemohon : 
                        <br><br><br><br><br><br><br>
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                    
                    </td>
                    <td colspan="3" style="padding-bottom:10px"> IT Officer : 
                        <br><br><br><br><br><br><br>
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                    
                    </td>
                
                </tr>   
                
                
                
            
                
            </tbody>
            
        </table>
        <p style="font-size:10px;padding-top:-10px;padding-left:20px">
        Created by @foreach($pembuats as $pembuat) {{$pembuat->name}} @endforeach | Printed by {{$login->name}} | {{date('d-m-Y h:i:s')}}
        
        </p>

    
    </div>
    
       

        
    </body>
</html>
