{{-- VIEW  --}}
<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#View{{ $id }}">
    <i class="fa fa-eye"></i>
</button>

<div class="modal fade" id="View{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">View Surat Masuk <strong>{{ $nomor }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Terima</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($tgl_terima)) }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nomor</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $nomor }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Customer</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $customer }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Eksternal</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($tgl_eksternal)) }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nomor Eksternal</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $nomor_eksternal }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Hal</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $hal }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tujuan / Up</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $model->up->name }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Departemen</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $model->departemen->nama_departemen }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Perlu Balasan ?</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($perlu_balasan == 1)
                                Ya
                            @else
                                Tidak
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Status</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($tindakan == 1)
                                <label class="label label-warning" style="font-size:12px;"><i class="fa fa-download"></i> diterima sekretariat</label>
                            @elseif($tindakan == 2)
                                <label class="label label-primary" style="font-size:12px;"><i class="fa fa-check-square"></i> diterima oleh up</label>
                            @elseif($tindakan == 3)
                                <label class="label label-success" style="font-size:12px;"><i class="fa fa-reply"></i> dibalas oleh up</label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Keterangan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($keterangan != null)
                                {{ $keterangan }}
                            @else
                                <i>(kosong)</i>
                            @endif
                            
                        </td>
                    </tr>

                    @if($perlu_balasan == 1)
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Balasan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($balasan != null)
                                {{ $balasan }}
                            @else
                                <i>(belum ada balasan)</i>
                            @endif
                            
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td class="text-left" width="25%" height="30px" valign="top"><b>Dibuat Oleh</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="70%" valign="top">{{ $model->creator->name }} ({{ date('d-m-Y H:i',strtotime($created_at))}})</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        
        </div>
    </div>
</div>

{{-- EDIT  --}}
@if($up_id == auth()->user()->id || $created_by == auth()->user()->id || auth()->user()->can('nomorsurat-masuk-all'))
    <a href="{{ route('surat.masuk.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
@else
    <button class="btn btn-default btn-xs" title="Edit" disabled><i class="fa fa-edit"></i></button>
@endif

{{-- HAPUS  --}}
@can('nomorsurat-hapus')
<div class="modal fade" id="hapusSurat{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $nomor }}</strong> ?</h4>
        </div>
        <form action="{{ route('surat.masuk.destroy', $id) }}" method="post">
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

<button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusSurat{{ $id }}">
    <i class="fa fa-trash"></i>
</button>   
@endcan