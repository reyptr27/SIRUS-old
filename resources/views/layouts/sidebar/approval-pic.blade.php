@can('approval-pic')
<li class="header">APPROVAL USER</li>
<li class="{{ set_active(['approvalpic']) }}">
    <a href="{{ route('approvalpic') }}">
        <i class="fa fa-building"></i><span>Permintaan Approve User </span>
        @if($jumlah_user!=null)
        <span class="pull-right-container">
        <small class="label pull-right bg-green">{{ $jumlah_user }}</small>
        </span>
        @endif
    </a>
</li>
@endcan