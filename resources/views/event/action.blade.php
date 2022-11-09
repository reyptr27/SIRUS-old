<?php 
    use App\Models\Departemen; use App\Models\Event\Event_Dept;
    $event_dept = Event_Dept::where(['event_id' => $id])->get();
?>
<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatEvent{{ $id }}">
    <i class="fa fa-eye"></i>
</button>
<a href="{{ route('event.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>

<div class="modal fade" id="lihatEvent{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Event <strong>{{ $nama_event }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Event</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($tanggal)) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Nama Event</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $nama_event }}</td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Jenis Event</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">
                            @if($jenis_event == 1)
                                Briefing
                            @elseif($jenis_event == 2)
                                Meeting
                            @elseif($jenis_event == 3)
                                Training
                            @else
                                Lain-lain
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Keterangan</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">
                        @if($keterangan != null)
                            {{ $keterangan }}
                        @else
                            -
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Lokasi</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $lokasi }}</td>
                    </tr>
                    @if($all_dept == 1)
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Departemen</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">ALL (Semua Departemen)</td>
                    </tr>
                    @else
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Departemen</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">
                            @foreach($event_dept as $e)
                                <?php $d = Departemen::where(['id' => $e->dept_id])->first(); ?>
                                <li style="margin-left:10px;">{{ $d->nama_departemen }}</li>
                            @endforeach
                            <br>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Dibuat Oleh</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $created_by }} ( {{ date('d-m-Y H:i', strtotime($created_at)) }} )</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        
        </div>
    </div>
</div>

<button type="button" title="Print" class="btn btn-success btn-xs" data-toggle="modal"
    data-target="#printEvent{{ $id }}">
    <i class="fa fa-print"></i>
</button>

<div class="modal fade" id="printEvent{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Pilih dokumen yang ingin dicetak !</h4>
        </div>
        <form target="_blank" action="{{ route('event.print', $id) }}" method="get">
            <!-- {{ csrf_field() }} -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Pilihan Dokumen </label>
                    <select name="print_option" class="form-control">
                        <option value="1">Log Absensi</option>
                        <option value="2">Notulen</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> PRINT</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>BATAL</button>
                </center>
            </div>
        </form>     
        </div>                                         
    </div>
</div>

@can('event-hapus')
<button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusEvent{{ $id }}">
    <i class="fa fa-trash"></i>
</button>

<div class="modal fade" id="hapusEvent{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus Event <strong>{{ $nama_event }}</strong> ?</h4>
        </div>
        <form action="{{ route('event.destroy', $id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('delete') }}
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
