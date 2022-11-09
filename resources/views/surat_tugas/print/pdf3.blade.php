<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>07.{{ $surattugas->nomor_surat }}</title> 
    </head>
    <body>
        <?php
            use App\User; use App\Models\Surattugas\Tujuan_St; use App\Models\Surattugas\Surat_Pegawai; 
            use App\Models\Surattugas\Surat_Tujuan; use App\Models\Surattugas\Surat_Tugas_Tanggal;
            $pegawai = Surat_Pegawai::where(['surat_tugas_id' => $surattugas->id])->get();
            $jumlahpegawai = count($pegawai);
            $tujuan = Surat_Tujuan::where(['surat_tugas_id' => $surattugas->id])->get();
            $jumlahtujuan = count($tujuan);
            $tanggal_surat = Surat_Tugas_Tanggal::where(['surat_tugas_id' => $surattugas->id])->get();
            $jumlahtanggal = count($tanggal_surat);
            $datatujuan = [];
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
        ?>

        <center><img src="{{ asset('assets/images/kop-surat-iso.jpg') }}"></center>
        <hr>
        <p align="right">{{ $surattugas->nomor_polisi}}</p>
        <p align="center"><u><b>SURAT TUGAS</b></u>
        <br>
            No.07.{{ $surattugas->nomor_surat }}
        </p>
        <br>
        <p style="padding-left: 50px; padding-right: 50px;">&nbsp;&nbsp;Diberikan kepada:<br>
            <span style="margin-left: 40px;">
                <table style="line-height: 20px; margin-left: 20">
                    
                    <tbody>
                        <tr>
                        <td valign=top>Nama</td>
                        <td valign=top><span style="margin-left: 40px;">: &nbsp;</span></td>
                        <td valign=top>
                            @php $nomorurut = 1 @endphp
                            @foreach($pegawai as $peg)
                            @if($jumlahpegawai != 1)
                                <?php 
                                    $kar = User::where(['id' => $peg->pegawai_id])->first();
                                    echo $nomorurut.". ".strtoupper($kar->name);
                                    $nomorurut++;
                                ?>
                                <br>
                            @else
                                <?php 
                                    $kar = User::where(['id' => $peg->pegawai_id])->first();
                                    echo strtoupper($kar->name);
                                ?>
                            @endif 
                            @endforeach                     
                        </td>
                        </tr>

                        <tr>
                           <td valign=top>Jabatan</td>
                            <td valign=top><span style="margin-left: 40px;">:</span></td>
                            <td valign=top>  
                                @if($surattugas->jabatan != null)
                                    {{$surattugas->jabatan}}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>

                        <tr>
                           <td valign=top>Tanggal</td>
                            <td valign=top><span style="margin-left: 40px;">:</span></td>
                            <td valign=top>  
                                @if($surattugas->opsi_tanggal == 1)
                                    @if($surattugas->tanggal_awal == $surattugas->tanggal_akhir)
                                        {{ bulanIndo($surattugas->tanggal_awal) }}
                                    @else
                                        {{ bulanIndo($surattugas->tanggal_awal) }} s/d {{ bulanIndo($surattugas->tanggal_akhir) }}
                                    @endif
                                @else
                                    @if($jumlahtanggal != 1)
                                        @php $i = 0 @endphp
                                        @foreach($tanggal_surat as $tgl)
                                            {{ bulanIndo($tgl->tanggal) }} @if($i < $jumlahtanggal-2), @elseif($i < $jumlahtanggal-1) dan @endif 
                                            @php $i++ @endphp
                                        @endforeach
                                    @else
                                        @foreach($tanggal_surat as $tgl)
                                            {{ bulanIndo($tgl->tanggal) }}
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                        </tr>

                        <tr>
                           <td valign=top>Kegiatan</td>
                            <td valign=top><span style="margin-left: 40px;">:</span></td>
                            <td valign=top>@php echo nl2br($surattugas->kegiatan) @endphp</td>
                        </tr>

                        <tr>
                        <td valign=top>Tujuan</td>
                        <td valign=top><span style="margin-left: 40px;">: &nbsp;</span></td>
                        <td valign=top>  
                            @php $nomorurut = 1 @endphp
                            @foreach($tujuan as $tuju)
                            @if($jumlahtujuan != 1)
                                <?php 
                                    $t = Tujuan_St::where(['id' => $tuju->tujuan_id])->first();
                                    echo $nomorurut.". ".$t->nama_tujuan;
                                    $datatujuan[$nomorurut] = $t->nama_tujuan;
                                    $nomorurut++;
                                ?>
                                <br>
                            @else
                                <?php 
                                    $t = Tujuan_St::where(['id' => $tuju->tujuan_id])->first();
                                    echo $t->nama_tujuan;
                                ?>
                            @endif 
                            @endforeach
                        </td>
                        </tr>
                    </tbody>
                </table>  
                       
                <p align="left" style="padding-left: 12px;">
                Demikian surat tugas ini dibuat untuk dapat dilaksanakan sebagaimana mestinya.
                </p>            
                
                <p align="left" style="padding-left: 12px;">
                    Surabaya, {{ bulanIndo($surattugas->created_at) }}<br>

                    <table cellpadding="10" width="100%">
                        <tbody>
                            <tr>
                                <td width="50%"><center><b>PT. SINAR RODA UTAMA</b></center></td>
                                <td width="50%"><center><b>{{$datatujuan[1]}}</b></center></td>
                            </tr>
                            <tr>
                                {{-- <td><center><b><u><br><br><br>Herman Harsono<br></u>Branch Office Manager</b></center></td> --}}
                                <td><center><b><br><br><br>HRD Surabaya</b></center></td>
                                <td><br><br><br><b><center>(.....................................)</center></b><br></td>
                            </tr>
                            <tr>
                                <td width="50%"><center><b>{{$datatujuan[2]}}</b></center></td>  
                                <td width="50%"><center><b>{{$datatujuan[3]}}</b></center></td>
                            </tr>
                            <tr>
                                <td><br><br><br><b><center>(.....................................)</center></b></td>
                                <td><br><br><br><b><center>(.....................................)</center></b></td>
                            </tr>
                        </tbody>
                    </table>              
                </p>
            </span>
        </p>
    </body>
</html>
