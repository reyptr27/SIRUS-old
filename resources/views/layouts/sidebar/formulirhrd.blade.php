<li class="treeview {{ set_active(['hrd.izin.index','hrd.izin.create','hrd.izin.edit','hrd.sakit.index','hrd.sakit.create','hrd.sakit.edit',
    'hrd.cuti.index','hrd.cuti.create','hrd.cuti.edit','hrd.cuti.serahterima','hrd.cuti.inventaris', 'hrd.unpaid.index','hrd.unpaid.create','hrd.unpaid.edit'
]) }}">
    <a href="#">
    <i class="fa fa-list-alt"></i> <span>Formulir HRD</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ set_active(['hrd.izin.index','hrd.izin.create','hrd.izin.edit']) }}"><a href="{{ route('hrd.izin.index') }}"><i class="fa fa-circle-o"></i> Formulir Izin</a></li>
        <li class="{{ set_active(['hrd.sakit.index','hrd.sakit.create','hrd.sakit.edit']) }}"><a href="{{ route('hrd.sakit.index') }}"><i class="fa fa-circle-o"></i> Formulir Sakit</a></li>
        <li class="{{ set_active(['hrd.cuti.index','hrd.cuti.create','hrd.cuti.edit','hrd.cuti.serahterima','hrd.cuti.inventaris']) }}"><a href="{{ route('hrd.cuti.index') }}"><i class="fa fa-circle-o"></i> Formulir Cuti</a></li>
        <li class="{{ set_active(['hrd.unpaid.index','hrd.unpaid.create','hrd.unpaid.edit']) }}"><a href="{{ route('hrd.unpaid.index') }}"><i class="fa fa-circle-o"></i> Formulir Unpaid</a></li>
    </ul>
</li>
