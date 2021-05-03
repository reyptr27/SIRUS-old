<?php 
    use App\User; use App\Models\FormulirHRD\Form_Izin; use App\Models\Departemen; use App\Models\Cabang;
    $form = Form_Izin::where(['id' => $id])->first();
    $karyawan = User::where(['id' => $form->karyawan_id])->first();
    $dept = Departemen::where(['id' => $karyawan->dept_id])->first();
    $cab =  Cabang::where(['id' => $karyawan->cabang_id])->first();
?>

<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatForm{{ $id }}">
    <i class="fa fa-eye"></i>
</button>
<a href="{{ route('hrd.izin.edit', $id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
<a href="{{ route('hrd.izin.print', $id) }}" target="blank" title="Cetak" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>

<div class="modal fade" id="lihatForm{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Formulir Izin tanggal <strong>{{ date('d-m-Y', strtotime($tanggal)) }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Izin</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($tanggal)) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" width="20%" height="30px" valign="top"><b>Nama Karyawan</b></td>
                        <td valign="top" width="5%"><b>:</b></td>
                        <td class="text-left" width="75%" valign="top">{{ $karyawan->name }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>NIK</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $karyawan->nik }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jabatan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $karyawan->jabatan }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Departemen</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $dept->nama_departemen }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Cabang</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $cab->nama_cabang }}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Keperluan</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($keperluan == 1)
                                Keluar kantor urusan pekerjaan
                            @elseif($keperluan == 2)
                                Keluar kantor urusan pribadi
                            @elseif($keperluan == 3)
                                Lambat datang
                            @elseif($keperluan == 4)
                                Pulang awal
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jam Keluar</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">@if($jam_keluar){{ date('H:i', strtotime($jam_keluar)) }}@else - @endif</td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Jam Masuk</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">@if($jam_masuk){{ date('H:i', strtotime($jam_masuk)) }}@else - @endif</td>
                    </tr>
                    @if($keperluan == 1)
                        <tr>
                            <td valign="top" class="text-left" height="30px"><b>Nama Tujuan</b></td>
                            <td valign="top"><b>:</b></td>
                            <td valign="top" class="text-left">{{ $nama_tujuan }}</td>
                        </tr>
                        <tr>
                            <td valign="top" class="text-left" height="30px"><b>Bertemu Dengan</b></td>
                            <td valign="top"><b>:</b></td>
                            <td valign="top" class="text-left">{{ $up_tujuan }}</td>
                        </tr>
                        <tr>
                            <td valign="top" class="text-left" height="30px"><b>Tujuan Kunjungan</b></td>
                            <td valign="top"><b>:</b></td>
                            <td valign="top" class="text-left">{{ $tujuan_kunjungan }}</td>
                        </tr>
                        <tr>
                            <td valign="top" class="text-left" height="30px"><b>Informasi Lainnya</b></td>
                            <td valign="top"><b>:</b></td>
                            <td valign="top" class="text-left">@if($informasi_tambahan) {{ $informasi_tambahan }} @else - @endif</td>
                        </tr>
                    @else
                        <tr>
                            <td valign="top" class="text-left" height="30px"><b>Keterangan</b></td>
                            <td valign="top"><b>:</b></td>
                            <td valign="top" class="text-left">{{ $keterangan }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Dibuat Oleh</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">{{ $pembuat }} ({{ date('d-m-Y H:i:s', strtotime($created_at)) }})</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        
        </div>
    </div>
</div>  

@can('hrd-formulir-hapus')
<button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusForm{{ $id }}">
    <i class="fa fa-trash"></i>
</button>

<div class="modal fade" id="hapusForm{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus Form Izin tanggal <strong>{{ date('d-m-Y', strtotime($tanggal)) }}</strong> ?</h4>
        </div>
        <form action="{{ route('hrd.izin.destroy', $id) }}" method="post">
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
