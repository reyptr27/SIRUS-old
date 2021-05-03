<li class="treeview {{ set_active(['arsip.index','arsip.create','arsip.edit','jenis.arsip.index','trash.index']) }}">
    <a href="#">
    <i class="fa fa-archive"></i> <span>E - Arsip</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ set_active(['arsip.index','arsip.create','arsip.edit']) }}"><a href="{{ route('arsip.index') }}"><i class="fa fa-archive"></i> Manajemen Arsip</a></li>
        <li class="{{ set_active(['jenis.arsip.index']) }}"><a href="{{ route('jenis.arsip.index') }}"><i class="fa fa-folder-open"></i> Jenis Arsip</a></li>
        @can('arsip-trash')
        <li class="{{ set_active(['trash.index']) }}"><a href="{{ route('trash.index') }}"><i class="fa fa-trash"></i> Trash Bin</a></li>
        @endcan
    </ul>
</li>