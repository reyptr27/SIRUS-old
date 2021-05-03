<?php 
    use App\Models\Surattugas\Surat_Pegawai;
    use App\User;

    $pegawai = Surat_Pegawai::where(['surat_tugas_id' => $id])->get();
?>

@foreach($pegawai  as $p)
    <?php $user = User::where(['id' => $p->pegawai_id])->first(); ?>
    <li style="margin-left:10px;">{{ $user->name }}</li>
@endforeach




