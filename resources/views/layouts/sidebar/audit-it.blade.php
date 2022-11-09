<!-- Audit IT  -->
@can('audit-it')
<li class="treeview {{ set_active(['audit-email.index','audit-pc.index','audit-lokasi.index']) }} ">
    <a href="#">
    <i class="fa fa-check-square-o"></i> <span>Audit IT</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    
    <ul class="treeview-menu">

        <li class="{{ set_active(['audit-email.index','audit-email.create',
        'audit-email.edit']) }}">
        <a href="{{ route('audit-email.index') }}">
        <i class="fa fa-envelope"></i> Audit Email</a></li>     
    
        <li class="{{ set_active(['audit-pc.index','audit-pc.create',
        'audit-pc.edit']) }}">
        <a href="#">
        <i class="fa fa-windows"></i> Audit PC</a></li>
        
        <li class="{{ set_active(['audit-lokasi.index','audit-lokasi.create',
        'audit-lokasi.edit']) }}">
        <a href="{{ route('audit-lokasi.index') }}">
        <i class="fa fa-map-o"></i> Lokasi Audit</a></li>

    </ul>
    
</li>
@endcan
<!-- end Audit IT -->
