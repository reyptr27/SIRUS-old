<?php 

    use App\Models\ManualBook\ManualBook_Departemen;
    use App\Models\Departemen;

    $manual_dept = ManualBook_Departemen::where(['manual_id' => $id])->get();
?>
@if($all_dept == 1)
    <li style="margin-left:10px;">ALL</li>
@else
    @foreach($manual_dept as $m)
        <?php $d = Departemen::where(['id' => $m->dept_id])->first(); ?>
        <li style="margin-left:10px;">{{ $d->kode_departemen }}</li>
    @endforeach
@endif
