<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatForm{{ $id }}">
    <i class="fa fa-eye"></i>
</button>
<a href="{{ route('hrd.unpaid.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
<a href="{{ route('hrd.unpaid.print', $id) }}" target="blank" title="Cetak" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>

<div class="modal fade" id="lihatForm{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Formulir Unpaid Leave tanggal <strong>{{ date('d-m-Y', strtotime($created_at)) }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Form</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($created_at)) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Nama Karyawan</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $name }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>NIK</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $nik }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Jabatan</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $jabatan }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Departemen</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $nama_departemen }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Divisi</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $divisi }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Cabang</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $nama_cabang }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Tanggal Unpaid</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">@if($tanggal_awal == $tanggal_akhir){{ date('d-m-Y',strtotime($tanggal_awal)) }} @else {{ date('d-m-Y',strtotime($tanggal_awal)) }} s/d {{ date('d-m-Y',strtotime($tanggal_akhir)) }} @endif</td>
                    </tr>
                    <?php 
                        $begin = new DateTime($tanggal_awal);
                        $end = new DateTime($tanggal_akhir);

                        $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
                        //mendapatkan range antara dua tanggal dan di looping
                        $i  = 0;
                        $x  = 0;
                        $end= 1;

                        foreach($daterange as $date){
                            $daterange     = $date->format("Y-m-d");
                            $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);
                            //Convert tanggal untuk mendapatkan nama hari
                            $day         = $datetime->format('D');
                            //Check untuk menghitung yang bukan hari sabtu dan minggu
                            if($day!="Sun") {
                                $x += $end-$i; 
                            }
                            $end++;
                            $i++;
                        }
                    ?>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Jumlah Hari</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ ($x+1).' hari' }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Alasan</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $alasan }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Tanggal Masuk</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ date('d-m-Y',strtotime($tanggal_masuk)) }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Dibuat Oleh</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $pembuat }} ({{ date('d-m-Y H:i',strtotime($created_at))}})</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        
        </div>
    </div>
</div>

@can('hrd-formulir-hapus')
<button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusForm{{ $id }}">
    <i class="fa fa-trash"></i>
</button>

<div class="modal fade" id="hapusForm{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus Form Unpaid tanggal <strong>{{ date('d-m-Y', strtotime($created_at)) }}</strong> ?</h4>
        </div>
        <form action="{{ route('hrd.unpaid.destroy', $id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-trash-o"></i> HAPUS</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>BATAL</button>
                </center>
            </div>
        </form>     
        </div>                                         
    </div>
</div>
@endcan
