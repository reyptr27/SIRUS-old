<?php 
    use App\Models\TAM\BA\RS;
    use App\Models\TAM\Ceklab;
    use App\User;

   
    
?>

<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatBa{{$id}}">
    <i class="fa fa-eye"></i>
</button>
<a href="{{ route('ceklab.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
<a href=" {{ route('ceklab.print',$id) }} " target="blank" title="Cetak" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>

@can('tam-ba-hapus')
<button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusBa{{$id}}">
    <i class="fa fa-trash"></i>
</button>

<div class="modal fade" id="hapusBa{{$id}}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{$nomor}}</strong> ?</h4>
        </div>
        <form action="{{ route('ceklab.destroy', $id) }}" method="post">
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

<div class="modal fade" id="lihatBa{{$id}}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Form Permintaan Pemeriksaan Cek Lab <br> Nomor <strong>{{$nomor}}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%"  style="border:1px">
                    
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Nama Pemohon</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $pemohon}}
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Customer / Rumah Sakit</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $nama_rs }}
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Alamat Customer</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{$alamat}}
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Type Mesin / No Seri</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{$type }}
                        </td>                                                                 
                    </tr>                    
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Tanggal Permohonan</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-M-Y', strtotime($created_at)) }}
                        </td>                                                                 
                    </tr>
                    
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Pemeriksaan</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($pemeriksaan== 1) Tes Na dan K @endif
                            @if($pemeriksaan== 2) Tes Air RO standart AAMI (Lengkap) @endif
                            @if($pemeriksaan== 3) Lainnya : Mikrobiologi (TPC) @endif
                            @if($pemeriksaan== 4) Lainnya : Air Bersih (Kimia Kesehatan) @endif
                            @if($pemeriksaan== 5) Lainnya : {{ $lainnya }} @endif
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Pihak Ketiga</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($pihak_ketiga== 1) PT. SUCOFINDO - Laboratory Surabaya @endif 
                            @if($pihak_ketiga== 2) PERSADA LABORATORY - Mojokerto @endif 
                            @if($pihak_ketiga== 3) Balai Besar Laboratorium Kesehatan(BBLK) - Surabaya @endif 
                            @if($pihak_ketiga== 4) PT. CITO DIAGNOSTIKA UTAMA - Semarang @endif 
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Dibuat Oleh</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $pembuat }} ({{ date('d-m-Y H:i', strtotime($created_at)) }})
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Diupdate Oleh</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $updater }} ({{ date('d-m-Y H:i', strtotime($updated_at)) }})
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
