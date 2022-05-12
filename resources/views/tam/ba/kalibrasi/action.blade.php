<?php 
    use App\Models\TAM\BA\RS;
    use App\Models\TAM\BA\Kalibrasi_mesin;
    use App\User;

    $barang = Kalibrasi_mesin::where(['kalibrasi_id' => $id])->get();
    $jml_barang = count($barang);
    $i=1;

   
    
?>

<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatBa{{$id}}">
    <i class="fa fa-eye"></i>
</button>
<a href="{{ route('kalibrasi.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
<a href=" {{ route('kalibrasi.print',$id) }} " target="_blank" title="Cetak" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>

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
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>02.{{$nomor}}</strong> ?</h4>
        </div>
        <form action="{{ route('kalibrasi.destroy', $id) }}" method="post">
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
                <h4 class="modal-title" id="myModalLabel">Detail Berita Acara Kalibrasi Mesin Nomor <strong>NO.02.{{$nomor}}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%"  style="border:1px">
                    
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Nama Teknisi</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $teknisi }}
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Kepala Teknisi</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $katek }}
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Kepala TAM</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $katam }}
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Tanggal Pelaksanaan</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-M-Y', strtotime($tanggal)) }}
                        </td>                                                                 
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px" width="30%"><b>Nama Rumah Sakit</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $nama_rs }}
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
                <table width="100%" style="border:1px solid black" height="30px">
                    <tr style="border:1px solid black" height="30px" class="bg-light-blue">
                        <td width="4%" style="border:1px solid black">No</td>
                        <td width="25%" style="border:1px solid black" height="30px">Nama Barang</td>
                        <td width="15%" style="border:1px solid black" height="30px">Merk / Type</td>
                        <td width="15%" style="border:1px solid black" height="30px"> No Seri</td>
                    </tr>
                    
                    @foreach($barang  as $b)
                    <tr>    
                        <td style="border:1px solid black" height="30px"> {{ $i }}</td>
                        <td style="border:1px solid black" height="30px"> MESIN HEMODIALISA </td>
                        <td style="border:1px solid black" height="30px"> 
                            @if($b->merk==1) Surdial @endif 
                            @if($b->merk==2) Surdial 55 @endif    
                            @if($b->merk==3) Surdial 55 Plus @endif
                            @if($b->merk==4) NCU-18 @endif 
                        </td>
                        <td style="border:1px solid black" height="30px"> {{$b->no_seri}} </td>
                        
                        <?php $i++ ?>
                        
                    
                    </tr>
                    @endforeach
                </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        
        </div>
    </div>
</div>  
