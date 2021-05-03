<?php 
    use App\Models\Beritaacara\Ba_Gudang;
    use App\Models\Beritaacara\Ba_Gudang_Barang;
    use App\User;

    $barang = Ba_Gudang_Barang::where(['ba_gudang_id' => $id])->get();
    $jml_barang = count($barang);
    $i=1;
    
?>

<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatBa{{$id}}">
    <i class="fa fa-eye"></i>
</button>
<a href="{{ route('bagudang.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
<a href="{{ route('bagudang.print', $id) }}" target="blank" title="Cetak" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>

@can('scm-ba-hapus')
<button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusBa{{$id}}">
    <i class="fa fa-trash"></i>
</button>

<div class="modal fade" id="hapusBa{{$id}}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $no_document }}</strong> ?</h4>
        </div>
        <form action="{{ route('bagudang.destroy', $id) }}" method="post">
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
    <div class="modal-dialog modal-lg" width="90%">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Berita Acara Serah Terima Barang Nomor <strong>{{$no_document}}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%"  style="border:1px">
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Berita Acara</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-M-Y', strtotime($created_at)) }}
                        </td>
                        <td width="4%"></td>
                        <td valign="top" class="text-left" width="20%" height="30px"><b>Berupa</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td valign="top" class="text-left" width="25%">
                            {{$jenis_barang}}
                        </td>                                               
                        
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Nomor Berita Acara</b></td>
                        <td valign="top" width="3%"><b>:</b></td>
                        <td class="text-left" width="25%" valign="top">{{$no_document}}<br></td>
                        <td width="4%"></td>
                        <td valign="top" class="text-left" height="30px"><b>No. PL / Resi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{$no_resi}}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Penerima</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{$penerima}}
                        </td>
                        <td width="4%"></td>
                        <td valign="top" class="text-left" height="30px"><b>No. Container</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                             {{$no_container}}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jabatan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$jabatan}}</td>
                        <td></td>
                        <td valign="top" class="text-left" height="30px"><b>No. Seal</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                             {{$no_seal}}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Alamat Penerima</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{$alamat_penerima}}</td>
                        <td></td>
                        <td valign="top" class="text-left" height="30px"><b>No. Surat Jalan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                             {{$no_surat_jalan}}
                        </td>
                    </tr>
                    <tr>
                        <td height="20px"></td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Nama Pengirim</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ $nama_pengirim}}
                        </td>
                        <td></td>
                        <td valign="top" class="text-left" height="30px"><b>Sesuai</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($sesuai==1) Sesuai @endif
                            @if($sesuai==0) Tidak Sesuai @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Perusahaan Pengirim</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{$perusahaan_pengirim}}
                        </td>
                        <td></td>
                        <td valign="top" class="text-left" height="30px"><b>Barang Selisih</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($sesuai==1) - @endif
                            @if($sesuai==0) {{$selisih}} @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Alamat Pengirim</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{$alamat_pengirim}}
                        </td>
                        <td></td>
                        <td valign="top" class="text-left" height="30px"><b>Barang Cacat</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($sesuai==1) - @endif
                            @if($sesuai==0) {{$cacat}} @endif
                        </td>
                    </tr>
                </table>
                <table width="100%" style="border:1px solid black" height="30px">
                    <tr style="border:1px solid black" height="30px" class="bg-light-blue">
                        <td width="4%" style="border:1px solid black">No</td>
                        <td width="25%" style="border:1px solid black" height="30px">Nama Barang</td>
                        <td width="15%" style="border:1px solid black" height="30px">Kuantitas</td>
                        <td width="15%" style="border:1px solid black" height="30px">Satuan</td>
                        <td width="15%" style="border:1px solid black" height="30px"> Kondisi</td>
                        <td width="26%" style="border:1px solid black" height="30px">Keterangan</td>
                    </tr>
                    
                    @foreach($barang  as $b)
                    <tr>    
                        <td style="border:1px solid black" height="30px"> {{ $i }}</td>
                        <td style="border:1px solid black" height="30px"> {{$b->nama_barang}} </td>
                        <td style="border:1px solid black" height="30px"> {{$b->kuantitas}} </td>
                        <td style="border:1px solid black" height="30px"> {{$b->satuan}}</td>
                        <td style="border:1px solid black" height="30px"> 
                            @if($b->kondisi==1) Baik @endif 
                            @if($b->kondisi==0) Tidak Baik @endif    
                        </td>
                        <td style="border:1px solid black" height="30px"> {{$b->keterangan}}</td>
                        
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
