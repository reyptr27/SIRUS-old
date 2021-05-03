@can('surat-tugas')
<li class="treeview {{ set_active(['surattugas.index','surattugas.index','surattugas.create','surattugas.edit','surattugas.tujuan','surattugas.approval.index']) }}">
    <a href="#">
    <i class="fa fa-envelope-o"></i> <span>Surat Tugas</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ set_active(['surattugas.index','surattugas.create','surattugas.edit']) }}"><a href="{{ route('surattugas.index') }}"><i class="fa fa-envelope-o"></i> Surat Tugas</a></li>
        @can('surat-tugas-approval')                
        <li class="{{ set_active(['surattugas.approval.index']) }}">
        <a href="{{ route('surattugas.approval.index') }}"><i class="fa fa-check"></i> Approval
            @if($jml_st!=null)
            <span class="pull-right-container">
            <small class="label pull-right bg-green">{{ $jml_st }}</small>
            </span>
            @endif
        </a></li>
        @endcan
        <li class="{{ set_active(['surattugas.tujuan']) }}"><a href="{{ route('surattugas.tujuan') }}"><i class="fa fa-map-marker"></i> Tujuan Surat Tugas</a></li>
    </ul>
</li>
@endcan        