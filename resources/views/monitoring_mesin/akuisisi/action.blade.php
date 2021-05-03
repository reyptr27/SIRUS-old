<?php
    use App\User;
    use App\Models\Monitoring_Mesin\Pengiriman_Detail;
    use App\Models\Monitoring_Mesin\Tipe_Mesin;
    use App\Models\Monitoring_Mesin\Jenis_Mesin;
    use App\Models\Monitoring_Mesin\Stock_Mesin;
    use App\Models\Beritaacara\Ba_Gudang_Alamat;
    use App\Models\TAM\BA\RS;

    $detail = Pengiriman_Detail::where(['header_id' => $id])->get();
?>

<button type="button" title="Lihat" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#lihatModel{{ $id }}">
    <i class="fa fa-eye"></i>
</button>

<div class="modal fade" id="lihatModel{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Rekomendasi Pengiriman Mesin <strong>{{ $nomor }}</strong></h4>
            </div>
            
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td width="20%" valign="top" class="text-left" height="30px"><b>Tanggal Approval</b></td>
                        <td width="5%" valign="top"><b>:</b></td>
                        <td width="75%" valign="top" class="text-left">
                            {{ date('d-m-Y', strtotime($tgl_approval)) }}
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
                        <td valign="top" class="text-left" height="30px"><b>Kategori</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($kategori == 1)
                                Penambahan
                            @elseif($kategori == 2)
                                Penggantian
                            @elseif($kategori == 3)
                                Peminjaman
                            @endif
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
                        <td valign="top" class="text-left" height="30px"><b>Rencana Kirim</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($tgl_plan_kirim != null)
                                {{ date('d-m-Y', strtotime($tgl_plan_kirim)) }}
                            @else 
                                <i>(belum diupdate)</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Rencana Instalasi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($tgl_plan_instalasi != null)
                                {{ date('d-m-Y', strtotime($tgl_plan_instalasi)) }}
                            @else 
                                <i>(belum diupdate)</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Kirim</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($tgl_kirim != null)
                                {{ date('d-m-Y', strtotime($tgl_kirim)) }}
                            @else 
                                <i>(belum diupdate)</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal Instalasi</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($tgl_instalasi != null)
                                {{ date('d-m-Y', strtotime($tgl_instalasi)) }}
                            @else 
                                <i>(belum diupdate)</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Tanggal BAST</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($tgl_bast != null)
                                {{ date('d-m-Y', strtotime($tgl_bast)) }}
                            @else 
                                <i>(belum diupdate)</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Status</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" class="text-left">
                            @if($status == 1)
                                <label class="label label-primary">Rekomendasi</label>
                            @elseif($status == 2)
                                <label class="label label-primary">Rencana Pengiriman</label>
                            @elseif($status == 3)
                                <label class="label label-primary">Pengiriman dan Instalasi</label>
                            @elseif($status == 4)
                                <label class="label label-success">Selesai</label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="text-left" height="30px"><b>Dibuat Oleh</b></td>
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
                    <table width="100%" border="1">
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Jenis</b></td>
                            <td align="center"><b>Tipe</b></td>
                            <td align="center"><b>Serial</b></td>
                            <td align="center"><b>Kondisi</b></td>
                            <td align="center"><b>Gudang</b></td>
                            <td align="center"><b>Customer Peruntukan</b></td>
                        </tr>
                        @if($detail != null)
                            @php $i = 1; @endphp
                            @foreach ($detail as $row)
                                @php 
                                    $tipe = Tipe_Mesin::where(['id' => $row->tipe_id])->first(); 
                                    $gudang = Ba_Gudang_Alamat::where(['id' => $row->gudang_id])->first();
                                    $customer = RS::where(['id' => $row->customer_id])->first();
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        @php $jm = Jenis_Mesin::where(['id' => $row->jenis_id])->first(); @endphp
                                        {{ $jm->jenis }}
                                    </td>
                                    <td>{{ $tipe->tipe }}</td>
                                    <td>{{ $row->nomor }}</td>
                                    <td>
                                        @if($row->kondisi == 1)
                                            Baru
                                        @elseif($row->kondisi == 2)
                                            Bekas
                                        @elseif($row->kondisi == 3)
                                            Rekondisi
                                        @endif
                                    </td>
                                    <td>{{ $gudang->nama_gudang }}</td>
                                    <td>{{ $customer->nama_rs }}</td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        @endif
                    </table>
                    
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        </div>
    </div>
</div> 

<a href="{{ route('monitoringmesin.akuisisi.edit', $id) }}" title="Edit" class="btn btn-primary btn-xs">
    <i class="fa fa-edit"></i>
</button>

