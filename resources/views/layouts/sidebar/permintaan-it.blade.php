<!-- Permintaan IT CCTV  -->
<li class="treeview {{ set_active(['perbaikan.index','pengadaan.index','pengadaan.create','pengadaan.edit'
    ,'perbaikan.create',  'perbaikan.edit' ,'program.index','program.create','program.edit'
]) }}">
    <a href="#">
    <i class="fa fa-gears"></i> <span>Permintaan IT</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    
    <ul class="treeview-menu">
    @can('perbaikan')
        <li class="{{ set_active(['perbaikan.index','perbaikan.create',
        'perbaikan.edit']) }}">
        <a href="{{ route('perbaikan.index') }}">
        <i class="fa fa-gear"></i> Perbaikan</a></li>     
    @endcan

    @can('pengadaan')
        <li class="{{ set_active(['pengadaan.index','pengadaan.create','pengadaan.edit']) }}">
        <a href="{{ route('pengadaan.index') }}">
        <i class="fa fa-gear"></i> Pengadaan</a></li>
    @endcan
        <li class="{{ set_active(['program.index','program.create','program.edit']) }}">
        <a href="{{ route('program.index') }}">
        <i class="fa fa-gear"></i> Program</a></li>
    
    </ul>
    
</li>
<!-- end Permintaan IT -->
