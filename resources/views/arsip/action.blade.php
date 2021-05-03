<a href="{{ route('arsip.show', $id) }}" target="blank" type="button" title="Lihat" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
<a href="{{ route('arsip.download', $id) }}" type="button" title="Download" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a>
<a href="{{ route('arsip.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>

<button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusArsip{{ $id }}">
    <i class="fa fa-trash"></i>
</button>

<div class="modal fade" id="hapusArsip{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $nama_arsip }}</strong> ?</h4>
        </div>
        <form action="{{ route('arsip.delete', $id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
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

<div class="modal fade" id="detailArsip{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Arsip Nomor <strong>{{ $nomor }}</strong> ?</h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Jenis Arsip</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $jenis_arsip }}<br></td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nomor</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $nomor }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Arsip</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ date('d-m-Y',strtotime($tgl_arsip)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tahun</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $tahun }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nama Arsip</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $nama_arsip }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Deskripsi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $deskripsi }}</td>
                    </tr>
                    <tr>
                        <td height="10px"></td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>File Size</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $file_size }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>File Format</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $format_file }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jumlah Download</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $jumlah_download }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Diupload Oleh</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $uploader }} ({{ date('d-m-Y H:i', strtotime($created_at)) }})</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Diupdate Oleh</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $updater }} ({{ date('d-m-Y H:i', strtotime($updated_at)) }})</td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <form method="GET" action="{{route('arsip.download', $id)}}">
                <button type="submit" class="btn btn-success pull-left"><i class="fa fa-download"></i> DOWNLOAD</button>
                </form>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        
        </div>
    </div>
</div>  
