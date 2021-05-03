<?php 
    use App\Models\Surattugas\Surat_Tujuan;
    use App\Models\Surattugas\Tujuan_St;

    $tujuan = Surat_Tujuan::where(['surat_tugas_id' => $id])->get();
?>

@foreach($tujuan as $t)
    <?php $st = Tujuan_St::where(['id' => $t->tujuan_id])->first(); ?>
    <li style="margin-left:10px;">{{ $st->nama_tujuan }}</li>
@endforeach



