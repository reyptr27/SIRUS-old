@if($tanggal == date('Y-m-d'))
<a href="{{ route('event.absensi', $id) }}" class="btn btn-success btn-xs" title="Absensi"><i class="fa fa-check"></i>  Absensi</a><br>
@else
<button class="btn btn-default btn-xs" title="Absensi" disabled><i class="fa fa-check"></i>  Absensi</button><br>
@endif

<a href="{{ route('event.log', $id) }}" class="btn btn-info btn-xs" title="Absensi"><i class="fa fa-list"></i> View Log</a><br>
<a href="{{ route('event.notulen', $id) }}" class="btn btn-primary btn-xs" title="Notulen"><i class="fa fa-book"></i>  Notulen</a>
