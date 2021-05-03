<?php 
    use App\Models\Surattugas\Surat_Pegawai;
    use App\Models\Surattugas\Surat_Tujuan;
    use App\Models\Surattugas\Surat_Tugas_Tanggal;
    use App\Models\Surattugas\Tujuan_St;
    use App\User;

    $pegawai = Surat_Pegawai::where(['surat_tugas_id' => $id])->get();
    $tujuan = Surat_Tujuan::where(['surat_tugas_id' => $id])->get();
    $tanggal = Surat_Tugas_Tanggal::where(['surat_tugas_id' => $id])->get();
    $jml_peg = count($pegawai);
    $jml_tuj = count($pegawai);
    $jml = count($tanggal);
?>

<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatSurat{{ $id }}">
    <i class="fa fa-eye"> View</i>
</button>

<div class="modal fade" id="lihatSurat{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Surat Tugas Nomor <strong>{{ $nomor_surat }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Surat</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($created_at)) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Nomor Surat</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">07.{{ $nomor_surat }}<br></td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Karyawan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($jml_peg > 1)
                                @foreach($pegawai  as $p)
                                    <?php $user = User::where(['id' => $p->pegawai_id])->first(); ?>
                                    <li style="margin-left:10px;">{{ $user->name }}</li>
                                @endforeach
                                <br>
                            @else
                                @foreach($pegawai  as $p)
                                    <?php $user = User::where(['id' => $p->pegawai_id])->first(); ?>
                                    {{ $user->name }}
                                @endforeach
                            @endif           
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jabatan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $jabatan }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Kegiatan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $kegiatan }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tujuan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                        @if($jml_tuj > 1)
                            @foreach($tujuan as $t)
                                <?php $st = Tujuan_St::where(['id' => $t->tujuan_id])->first(); ?>
                                <li style="margin-left:10px;">{{ $st->nama_tujuan }}</li>
                            @endforeach
                            <br>
                        @else
                            @foreach($tujuan as $t)
                                <?php $st = Tujuan_St::where(['id' => $t->tujuan_id])->first(); ?>
                                {{ $st->nama_tujuan }}
                            @endforeach
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nomor Polisi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                        @if($nomor_polisi != null)
                            {{ $nomor_polisi }}
                        @else
                            -
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Tugas</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                        @if($opsi_tanggal == 2)
                            @foreach($tanggal as $tgl)
                                <li style="margin-left:10px;">{{ date('d-m-Y', strtotime($tgl->tanggal)) }}</li>
                            @endforeach
                        @else
                            @if($tanggal_awal == $tanggal_akhir)
                                {{ date('d-m-Y', strtotime($tanggal_awal)) }}
                            @else
                                {{ date('d-m-Y', strtotime($tanggal_awal)) }} s/d {{ date('d-m-Y', strtotime($tanggal_akhir)) }}
                            @endif
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>TTD Customer</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($status_ttd == 1)
                                Ditampilkan
                            @else
                                Tidak ditampilkan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Dibuat Oleh</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            <?php 
                                $creator = User::where('id', $created_by)->first();
                            ?>
                            {{ $creator->name }}
                        </td>
                    </tr>
                    
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        </div>
    </div>
</div>  

<button type="button" title="Approve" class="btn btn-success btn-xs" data-toggle="modal"
    data-target="#ApproveSurat{{ $id }}">
    <i class="fa fa-check"> Approve</i>
</button>

<div class="modal fade" id="ApproveSurat{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Approve Surat <strong>{{ $nomor_surat }}</strong> ?</h4>
        </div>
        <form action="{{ route('surattugas.approval.approve', $id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Approve</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                </center>
            </div>
        </form>
        </div>                                         
    </div>
</div>

<button type="button" title="Reject" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#RejectSurat{{ $id }}">
    <i class="fa fa-close"> Reject</i>
</button>


<div class="modal fade" id="RejectSurat{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Reject Surat <strong>{{ $nomor_surat }}</strong> ?</h4>
        </div>
        <form action="{{ route('surattugas.approval.reject', $id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            
            <div class="modal-body">
                <h5><strong>Feedback</strong><h5>
                <textarea name="feedback" cols="60" rows="7" placeholder="Alasan surat tugas direject / ditolak" class="form-control" required></textarea>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-ban"></i> Reject</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                </center>
            </div>
        </form>
        </div>                                         
    </div>
</div>