<?php 
    use App\Models\Surattugas\Surat_Tugas_Tanggal;

    $tanggal = Surat_Tugas_Tanggal::where(['surat_tugas_id' => $id])->get();
    $jml = count($tanggal);
?>

@if($opsi_tanggal == 2)
    <!-- @php $i = 0 @endphp -->
    @foreach($tanggal as $tgl)
        <!-- @if($i < $jml-1)
            {{ date('j', strtotime($tgl->tanggal)) }} @if($i < $jml-2),@else dan @endif
            @php $i++ @endphp
        @else
            {{ date('j-m-Y', strtotime($tgl->tanggal)) }}
            @php $i++ @endphp
        @endif -->
        <li style="margin-left:10px;">{{ date('d-m-Y', strtotime($tgl->tanggal)) }}</li>
    @endforeach
@else
    @if($tanggal_awal == $tanggal_akhir)
        {{ date('d-m-Y', strtotime($tanggal_awal)) }}
    @else
        {{ date('d-m-Y', strtotime($tanggal_awal)) }} s/d {{ date('d-m-Y', strtotime($tanggal_akhir)) }}
    @endif
@endif