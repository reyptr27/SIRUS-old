<?php
    use App\User;
    use App\Models\Monitoring_Mesin\Tipe_Mesin;
    use App\Models\Monitoring_Mesin\Jenis_Mesin;
?>

<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatModel{{ $id }}">
    <i class="fa fa-eye"></i>
</button>

<div class="modal fade" id="lihatModel{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Stock Mesin <strong>{{ $nomor }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td width="20%" valign="top" class="text-left" height="30px"><b>Tanggal Penerimaan</b></td>
                        <td width="5%" valign="top"><b>:</b></td>
                        <td width="75%" valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($tgl_terima)) }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jenis</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $jenis }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tipe</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $tipe }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nomor Seri</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $nomor }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Kondisi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($kondisi == 1)
                                Baru
                            @elseif($kondisi == 2)
                                Bekas
                            @elseif($kondisi == 3)
                                Rekondisi
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Gudang</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $gudang }}
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
                        <td valign="top" class="text-left" height="30px"><b>Added at</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y H:i', strtotime($created_at)) }}
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

@can('monitoring-mesin-hapus')
{{-- UPDATE  --}}
    <a href="{{ route('monitoringmesin.stock.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>

{{-- HAPUS  --}}
    <button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
        data-target="#hapusModel{{ $id }}">
        <i class="fa fa-trash"></i>
    </button>

    <div class="modal fade" id="hapusModel{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus stock mesin <strong>{{ $nomor }}</strong> ?</h4>
            </div>
            <form action="{{ route('monitoringmesin.stock.destroy', $id) }}" method="post">
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