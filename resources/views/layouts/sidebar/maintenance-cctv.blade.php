@can('maintenance-cctv')
<!-- manajemen user  -->
<li class="treeview {{ set_active(['maintenance_cctv.index']) }}">
    <a href="#">
    <i class="fa fa-gears"></i> <span>Maintenance</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ set_active(['maintenance_cctv.index','maintenance_cctv.store','maintenance_cctv.update','maintenance_cctv.cetak']) }}"><a href="{{ route('maintenance_cctv.index') }}"><i class="fa fa-gear"></i> Maintenance CCTV</a></li>

    </ul>
</li>
<!-- end maintenance CCTV  -->
@endcan