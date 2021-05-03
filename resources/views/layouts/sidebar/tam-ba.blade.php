        @can('tam-ba','tam-ba-rs')
        <li class="treeview {{ set_active([
            
            'chemical_ro.index','chemical_ro.create','chemical_ro.edit','tam.ba.index',
            'flushing.index','flushing.create','flushing.edit','tam.teknisi.index'        
        ]) }}">
            <a href="#">
            <i class="fa fa-book"></i> <span>Berita Acara</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                
                @can('tam-ba')
                <li class="{{ set_active(['chemical_ro.index','chemical_ro.create','chemical_ro.edit']) }}">
                    <a href="{{ route('chemical_ro.index')}}">
                        <i class="fa fa-book"></i> Chemical RO
                    </a>
                </li>
                <li class="{{ set_active(['flushing.index','flushing.create','flushing.edit']) }}">
                    <a href="{{ route('flushing.index')}}">
                        <i class="fa fa-book"></i> Flushing Pipa
                    </a>
                </li>
                @endcan
                @can('tam-ba-rs')
                <li class="{{ set_active(['tam.ba.index']) }}">
                    <a href="{{ route('tam.ba.index') }}">
                    <i class="fa fa-institution"></i> Data Rumah Sakit</a>
                </li>
                
                <li class="{{ set_active([]) }}">
                    <a href="">
                    <i class="fa fa-group"></i> Data Teknisi</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

                     