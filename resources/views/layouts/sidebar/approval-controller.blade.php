@can('approval-controller')
<li class="header">APPROVAL USER</li>
<li class="{{ set_active(['approvalcontroller']) }}">
    <a href="{{ route('approvalcontroller') }}">
        <i class="fa fa-building"></i><span>Permintaan Approve User</span>
        @if($jumlah_approve!=null)
        <span class="pull-right-container">
        <small class="label pull-right bg-green">{{ $jumlah_approve }}</small>
        </span>
        @endif
    </a>
</li>
@endcan