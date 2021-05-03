<div class="modal fade" id="lihatModel{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail <strong>{{ $judul }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td width="20%" valign="top" class="text-left" height="30px"><b>Nama</b></td>
                        <td width="5%" valign="top"><b>:</b></td>
                        <td width="75%" valign="top" class="text-left">
                            {{ $judul }}
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" valign="top" class="text-left" height="30px"><b>Deskripsi</b></td>
                        <td width="5%" valign="top"><b>:</b></td>
                        <td width="75%" valign="top" class="text-left">
                            {{ $deskripsi }}
                        </td>
                    </tr>
                    <tr>
                        <td height="10px"></td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>File Size</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $file_size }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>File Format</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $format_file }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jumlah Dilihat</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $jumlah_lihat }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jumlah Download</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $jumlah_download }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Diupload Oleh</b></td>
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
                <a href="{{ route('manualbook.download', $id) }}" class="btn btn-success pull-left"><i class="fa fa-download"></i> Download</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        </div>
    </div>
</div> 
<a href="{{ route('manualbook.show', $id) }}" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-eye"></i></a>
<a href="{{ route('manualbook.download', $id) }}" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a>

@can('manual-book-hapus')
    <a href="{{ route('manualbook.edit', $id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
    <button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
        data-target="#hapusModel{{ $id }}">
        <i class="fa fa-trash"></i>
    </button>

    <div class="modal fade" id="hapusModel{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $judul }}</strong> ?</h4>
            </div>
            <form action="{{ route('manualbook.destroy', $id) }}" method="post">
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


