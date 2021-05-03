<div class="modal fade" id="editstatus{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit status <strong>{{ $no_document }}</strong> ?</h4>
            </div>
            
            <form action="{{ route('pengadaan.updatestatus', $id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('patch') }}
                <div class="modal-body">
                    
                    <div class="col-md-12">
                        <div class="col-sm-5">
                            <label for="">Status Pengajuan Perbaikan</label>
                        </div>
                        <div class="col-sm-7" >
                            <select name="status" class="form-control" required>
                                <option value="1" @if($status == 1) selected @endif >Approval user / atasan</option>
                                <option value="2" @if($status == 2) selected @endif >Analisa IT</option>
                                <option value="3" @if($status == 3) selected @endif>Approval kepala Divisi / BOM</option>
                                <option value="4" @if($status == 4) selected @endif>Analisa ITS Pusat</option>
                                <option value="5" @if($status == 5) selected @endif>Approval pimpinan</option>
                                <option value="6" @if($status == 6) selected @endif>Disetujui</option>

                            </select>
                            <p class="text-danger"></p>
                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                </div>
            </form>
        
        </div>                                         
    </div>
</div> 


<div class="modal fade" id="detailpengadaan{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Pengajuan Pengadaan <strong>{{ $no_document }}</strong> ?</h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nomor Document</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $no_document }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Pengajuan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ date('d-m-Y',strtotime($created_at)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nama Pemohon</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$pemohon}}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>NIK</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$nik}}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jabatan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$jabatan}}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Departemen</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$dept}}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Cabang</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$cabang}}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jenis Pengajuan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $jenis }} &nbsp; > > {{$spesifikasi}}</td>
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
                        <td valign="top" class="text-left" height="30px"><b>Akibat Kerusakan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$akibat}}</td>
                    </tr>
                    
                    
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Dibuat Oleh</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$pembuat}} ({{ date('d-m-Y H:i', strtotime($created_at)) }})</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Diupdate Oleh</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$updater}} ({{ date('d-m-Y H:i', strtotime($updated_at)) }})</td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        
        </div>
    </div>
</div>

<button type="button" class="btn btn-info btn-xs" title="lihat" data-toggle="modal"
    data-target="#detailpengadaan{{ $id }}">
    <i class="fa fa-eye"></i>
</button> 

<!-- <a href="" class="btn btn-info btn-xs" title="Lihat"><i class="fa fa-eye"></i></a> -->
<a href="{{ route('pengadaan.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
<a href="{{ route('pengadaan.cetak', $id) }}" target="blank" class="btn btn-success btn-xs" title="Cetak"><i class="fa fa-print"></i></a>

@can('pengadaan-hapus')
<div class="modal fade" id="hapusPengadaan{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $no_document }}</strong> ?</h4>
        </div>
        <form action="{{ route('pengadaan.destroy', $id) }}" method="post">
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

<button type="button" class="btn btn-danger btn-xs" title="Hapus" data-toggle="modal"
    data-target="#hapusPengadaan{{ $id }}">
    <i class="fa fa-trash"></i>
</button>   
@endcan