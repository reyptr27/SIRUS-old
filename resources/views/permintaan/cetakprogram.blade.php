<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $program->no_document }} </title> 
    
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
                    <td style="width:220px; text-align:center"  colspan="4" >
                        <img src="../public/assets/images/logo-baru.jpg"height="50"><br>
				        <img src="../public/assets/images/logo-baru-tulisan.jpg" height="25">
                    
                    </td>
                    <td   colspan="4" style="height:80px;width:220px;">
                        <center><b>FORMULIR</b></center><br>
                        <center><b style="text-align:center">PERMOHONAN PEMBUATAN PROGRAM APLIKASI</b></center><br>
                        Edisi : 1<br><br>   
                        Tanggal : 20 Februari 2019<br><br>
                    
                    </td>
                    <td  colspan="4" style="width:220px; height:80px;padding-left:10px;padding-top:10px">
                        Halaman 1 dari 1<br><br>
                        Nomor Document : F-SRU-ITS-03<br><br>
                        Nomor Revisi : 0<br><br>
                        Tanggal : - <br>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">Tanggal</td>
                    <td colspan="4"> : &nbsp; {{date('d  M  Y', strtotime($program->created_at))}}</td>
                    <td colspan="2">No. ID Pemohon </td>
                    <td colspan="4">: &nbsp; @foreach($pemohons as $pemohon) {{$pemohon->nik}} @endforeach</td>

                </tr>
                <tr>
                    <td colspan="2">Nama</td>
                    <td colspan="4"> : &nbsp;  @foreach($pemohons as $pemohon) {{$pemohon->name}} @endforeach</td>
                    <td colspan="2">Email</td>
                    <td colspan="4">: &nbsp;  @foreach($pemohons as $pemohon) {{$pemohon->email}} @endforeach</td>
                </tr>
                <tr>
                    
                    <td colspan="2">Jabatan</td>
                    <td colspan="4">
                        : &nbsp; @foreach($pemohons as $pemohon) {{$pemohon->jabatan}} @endforeach
                    </td>
                    <td colspan="2">Departemen</td>
                    <td colspan="4">: &nbsp; @foreach($pemohons as $pemohon) {{$pemohon->dept->nama_departemen}} @endforeach </td>    
                </tr>
                <tr>
                    
                    <td colspan="2">Perusahaan</td>
                    <td colspan="4">
                        : &nbsp; PT. Sinar Roda Utama
                    </td>
                    <td colspan="2">Cabang</td>
                    <td colspan="4">: &nbsp; @foreach($pemohons as $pemohon) {{$pemohon->cabang->nama_cabang}} @endforeach </td>    
                </tr>
                <tr>
                    
                <td  colspan="12" style="height:20px;padding-left:10px;padding-top:5px;padding-bottom:5px">
                        Jenis Pengajuan : <br>
                        [
                        @if($program->jenis == "1") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                        @else
                            &nbsp;&nbsp;
                        @endif
                        ] Pengembangan Aplikasi
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        [    
                        @if($program->jenis == "2") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                        @else
                            &nbsp;&nbsp;
                        @endif
                        ] Pembuatan Aplikasi Baru

                    </td>
                    
                </tr>
                
                <tr>
                    <td colspan="6" valign="top" style="height:120px;" >
                        Program Aplikasi yang diinginkan ( isi dengan jelas ) : <br><br>
                        {{$program->program}}
                     </td>
                     <td colspan="6" valign="top" style="height:120px;" > 
                        Alasan permohonan ( isi dengan jelas): <br><br>
                        {{ $program->alasan }}
                     </td>
                </tr>              
                
                <tr>
                    <td colspan="4"  >
                        Pemohon : 
                    </td>
                      
                    <td colspan="4"> Atasan pemohon :  
                        
                    </td>

                    <td colspan="4"  > Kadiv / Kadept Pemohon :  
                    </td>                   
                    
                </tr>
                <tr>
                    <td colspan="4" valign="top" style="height:70px;" >                        
                    </td>                      
                    <td colspan="4" valign="top" > 
                    </td>
                    <td colspan="4" valign="top" >  
                    </td>                   
                </tr>
                <tr>
                    <td colspan="4">                       
                        ( @foreach($pemohons as $pemohon) {{$pemohon->name}} @endforeach ) 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>                      
                    <td colspan="4"> 
                        ( @foreach($pemohons as $pemohon) @if($pemohon->atasan_id != null) {{$pemohon->atasan->name}} @endif @endforeach ) 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>
                    <td colspan="4">                         
                        ( @foreach($kadepts as $kadept) {{$kadept->name}} @endforeach )
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td> 
                </tr>

                <tr>
                    <td colspan="3" rowspan="3" valign="top">
                        Verifikasi IT Officer : 
                    </td>
                    <td colspan="3" > IT Officer :</td>
                    <td colspan="3" rowspan="3" valign="top">
                        Verifikasi Operasional Improvement :
                    </td>
                    <td colspan="3" >Operasional Improvement :</td>    
                    
                </tr>
                <tr>
                   
                    <td colspan="3" style="height:70px;"></td>
                    <td colspan="3" ></td>    
                    
                </tr>
                <tr>
                    <td colspan="3" >
                    ( @foreach($officers as $officer) {{$officer->name}} @endforeach )
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>
                    <td colspan="3" >
                    ( @foreach($improvements as $improvement) {{$improvement->name}} @endforeach )
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>                       
                    
                </tr>
                <tr>
                    <td colspan="6" rowspan="4" valign="top">
                        Catatan : 
                    </td>
                    <td colspan="6" > Diperiksa,</td>
                </tr>
                <tr>
                   
                    <td colspan="6" >Operasional Manager : </td>
                </tr>
                <tr>
                   
                    <td colspan="6" style="height:70px;"> </td>
                </tr>
                <tr>
                   
                    <td colspan="6" > 
                    ( @foreach($oms as $om) {{$om->name}} @endforeach )
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>
                </tr>

                <tr>
                    <td colspan="6" rowspan="4" valign="top">
                        Catatan : 
                    </td>
                    <td colspan="6" > Disetujui,</td>
                </tr>
                <tr>
                   
                    <td colspan="6" >Branch Office Manager : </td>
                </tr>
                <tr>
                   
                    <td colspan="6" style="height:70px;"> </td>
                </tr>
                <tr>
                   
                    <td colspan="6" > 
                    ( @foreach($boms as $bom) {{$bom->name}} @endforeach )
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 
                    </td>
                </tr>
                <tr>                    
                <td  colspan="12" style="height:20px;padding-left:10px;padding-top:5px;padding-bottom:5px">
                        * Hasil Permohonan : <br>
                        [
                        @if($program->hasil == "1") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                        @else
                            &nbsp;&nbsp;
                        @endif
                        ] Disetujui
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        [    
                        @if($program->hasil == "2") 
                            <img src="../public/assets/images/centang.jpg"height="10">
                        @else
                            &nbsp;&nbsp;
                        @endif
                        ] Ditolak

                    </td>
                    
                </tr>
                  
                
                
                
            
                
            </tbody>
            
        </table>

    
    </div>
    
       

        
    </body>
</html>
