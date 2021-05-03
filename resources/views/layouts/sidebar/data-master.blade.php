@can('master-data')
<li class="header">DATA MASTER</li>
<!-- manajemen user  -->
<li class="treeview {{ set_active(['users.index','users.create','users.edit','users.role.list','role.index','permission.index','users.permission.list','role.permission.list']) }}">
    <a href="#">
    <i class="fa fa-users"></i> <span>
        Manajemen User &nbsp;
        @if($jumlah_controller!=null)
        <small class="label bg-green">{{ $jumlah_controller }}</small>
        @endif
        </span>  
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ set_active(['users.index','users.create','users.edit','users.role.list','users.permission.list']) }}"><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> <span>User &nbsp;@if($jumlah_controller!=null)<small class="label bg-green">{{ $jumlah_controller }}</small>@endif</span></a></li>
        <li class="{{ set_active(['role.index','role.permission.list']) }}"><a href="{{ route('role.index') }}"><i class="fa fa-briefcase"></i> Role</a></li>
        <li class="{{ set_active(['permission.index']) }}"><a href="{{ route('permission.index') }}"><i class="fa fa-key"></i> Permission</a></li>
    </ul>
</li>
<!-- end manajemen user  -->
<!-- cabang  -->
<li class="{{ set_active(['cabang.index']) }}"><a href="{{ route('cabang.index') }}"><i class="fa fa-building"></i><span>Cabang</span></a></li>
<!-- departemen -->
<li class="{{ set_active(['divisi.index']) }}"><a href="{{ route('divisi.index') }}"><i class="fa fa-cube"></i><span>Divisi</span></a></li>
<!-- departemen -->
<li class="{{ set_active(['departemen.index']) }}"><a href="{{ route('departemen.index') }}"><i class="fa fa-cubes"></i><span>Departemen</span></a></li>
@endcan
        