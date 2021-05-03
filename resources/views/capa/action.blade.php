{{-- SHOW  --}}
<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatModel{{ $id }}">
    <i class="fa fa-eye"></i>
</button>

<div class="modal fade" id="lihatModel{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail <strong>{{ $nomor }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td width="20%" valign="top" class="text-left" height="30px"><b>Nomor Form PTKP</b></td>
                        <td width="5%" valign="top"><b>:</b></td>
                        <td width="75%" valign="top" class="text-left">
                            {{ $nomor }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Dari</b> <small>(Departemen yang menemukan)</small></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $dari }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Kepada</b> <small>(Departemen temuan)</small></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $kepada }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Terjadi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($tgl_terjadi)) }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Lokasi Sumber</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $lokasi }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Kategori</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            [@if($kategori_1 == 2) V @else &nbsp;&nbsp;&nbsp; @endif] Management Review
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px">&nbsp;</td>
                        <td valign="top">&nbsp;</td>
                        <td valign="top" class="text-left">
                            [@if($kategori_2 == 2) V @else &nbsp;&nbsp;&nbsp; @endif] Tindakan Pencegahan
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px">&nbsp;</td>
                        <td valign="top">&nbsp;</td>
                        <td valign="top" class="text-left">
                            [@if($kategori_3 == 2) V @else &nbsp;&nbsp;&nbsp; @endif] Tindakan Koreksi
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Potensi Ketidaksesuaian</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $inti_masalah }}<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Rincian Permasalahan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @php echo nl2br(htmlspecialchars($rincian_masalah)); @endphp<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Penyebab Permasalahan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @php echo nl2br(htmlspecialchars($penyebab_masalah)); @endphp<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tindakan Koreksi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @php echo nl2br(htmlspecialchars($koreksi)); @endphp<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tindakan Pencegahan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($pencegahan != null)
                                @php echo nl2br(htmlspecialchars($pencegahan)); @endphp<br><br>
                            @else 
                                <i>(kosong)</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Target Penyelesaian</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($tgl_target)) }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>PIC Penyelesaian</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $pic }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Verifikator</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $verifikator }}
                        </td>
                    </tr>
                    @if($status == 2)
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Pembuktian/Verifikasi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($hasil_tindakan != null)
                                @php echo nl2br(htmlspecialchars($hasil_tindakan)); @endphp<br><br>
                            @else 
                                <i>(kosong)</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Verifikasi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($tgl_verifikasi != null)
                                {{ date('d-m-Y', strtotime($tgl_verifikasi)) }}
                            @else 
                                <i>(kosong)</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Catatan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($catatan != null)
                                @php echo nl2br(htmlspecialchars($catatan)); @endphp<br><br>
                            @else 
                                <i>(kosong)</i>
                            @endif
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Status</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($status == 1)
                                <label class="label label-primary">Process</label>
                            @elseif($status == 2)
                                <label class="label label-success">Done</label>
                            @else 
                                <label class="label label-danger">Rejected</label>
                            @endif
                        </td>
                    </tr>
                    @if($status == 3)
                        <tr>
                            <td valign="top" class="text-left" height="30px"><b>Feedback</b></td>
                            <td valign="top"><b>:</b></td>
                            <td valign="top" class="text-left">
                                @if($feedback != null)
                                    {{ $feedback}}
                                @else 
                                    <i>(kosong)</i>
                                @endif
                                <br><br>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Dibuat Oleh</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $creator }} ( {{ date('d-m-Y H:i', strtotime($created_at)) }} )
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Diupdate Oleh</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $updater }} ( {{ date('d-m-Y H:i', strtotime($updated_at)) }} )
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        </div>
    </div>
</div> 
{{-- END SHOW  --}}
{{-- EDIT  --}}
@if($status == 1 || $status == 3)
    <a href="{{ route('capa.edit', $id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
@else
    <button type="button" title="Edit" class="btn btn-default btn-xs" data-toggle="modal"
            data-target="#showEdit{{ $id }}"><i class="fa fa-edit"></i>
        </button>

        <div class="modal fade" id="showEdit{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail Status <strong>{{ $nomor }}</strong></h4>
                </div>
                
                <div class="modal-body">
                    <center><p><b>{{$nomor}}</b> telah diverikasi oleh <b>{{$verifikator}}</b>.</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
                </div>
            </div>
        </div>
    </div>
@endif
{{-- END EDIT  --}}

{{-- PRINT --}}
<a href="{{ route('capa.print', $id) }}" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>
{{-- END PRINT  --}}

{{-- HAPUS  --}}
@can('capa-hapus')
    <button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
        data-target="#hapusModel{{ $id }}">
        <i class="fa fa-trash"></i>
    </button>

    <div class="modal fade" id="hapusModel{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $nomor }}</strong> ?</h4>
            </div>
            <form action="{{ route('capa.destroy', $id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="modal-footer">
                    <center>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> HAPUS</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>BATAL</button>
                    </center>
                </div>
            </form>     
            </div>                                         
        </div>
    </div>
@endcan
{{-- END HAPUS  --}}