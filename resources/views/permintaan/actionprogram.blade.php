<div class="modal fade" id="editstatus{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit status <strong>{{ $no_document }}</strong> ?</h4>
            </div>
            
            <form action="{{ route('program.updatestatus', $id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('patch') }}
                <div class="modal-body">
                    
                    <div class="col-md-12">
                        <div class="col-sm-5">
                            <label for="">Status Pengajuan Perbaikan</label>
                        </div>
                        <div class="col-sm-7" >
                            <select name="status" class="form-control" required>
                                <option value="1" @if($approval == 1) selected @endif>Approval user / atasan</option>
                                <option value="2" @if($approval == 2) selected @endif>Verifikasi IT</option>
                                <option value="3" @if($approval == 3) selected @endif>Verifikasi Operational Improvement</option>
                                <option value="4" @if($approval == 4) selected @endif>Approval Operational Manager</option>
                                <option value="5" @if($approval == 5) selected @endif>Approval Branch Office Manager</option>
                                <option value="6" @if($approval == 6) selected @endif>Disetujui</option>
                                <option value="7" @if($approval == 7) selected @endif>Proses Pengembangan oleh IT</option>
                                <option value="8" @if($approval == 8) selected @endif>Selesai</option>

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
                        <td valign="top" class="text-left" height="30px"><b>Kadiv / Kadept</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$kadept}}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jenis Pengajuan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                        @if($jenis==1) Pengembangan Aplikasi
                        @else Pembuatan Aplikasi Baru
                        @endif
                        
                        </td>
                    </tr>
                    
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Deskripsi Program</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $program }}</td>
                    </tr>
                    <tr>
                        <td height="10px"></td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Alasan Permohonan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$alasan}}</td>
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
<a href="{{ route('program.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
<a href="{{ route('program.cetak', $id) }}" target="blank" class="btn btn-success btn-xs" title="Cetak"><i class="fa fa-print"></i></a>

@can('program-hapus')
<div class="modal fade" id="hapusProgram{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $no_document }}</strong> ?</h4>
        </div>
        <form action="{{ route('program.destroy', $id) }}" method="post">
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
    data-target="#hapusProgram{{ $id }}">
    <i class="fa fa-trash"></i>
</button>   
@endcan