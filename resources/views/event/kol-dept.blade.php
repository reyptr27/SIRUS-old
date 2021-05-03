<?php 

    use App\Models\Event\Event_Dept;
    use App\Models\Departemen;

    $event_dept = Event_Dept::where(['event_id' => $id])->get();
?>
@if($all_dept == 1)
    <li style="margin-left:10px;">ALL</li>
@else
    @foreach($event_dept as $e)
        <?php $d = Departemen::where(['id' => $e->dept_id])->first(); ?>
        <li style="margin-left:10px;">{{ $d->kode_departemen }}</li>
    @endforeach
@endif
