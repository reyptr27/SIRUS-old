        
<li class="treeview {{ set_active([
    'capa.index','capa.create','capa.edit','capa.verifikasi.index','capa.verifikasi.edit',
    'capa.report.index','capa.report.filter','capa.report.detail',
    'capa.lokasi.index'
]) }}">
    <a href="#">
    <i class="fa fa-puzzle-piece"></i> 
    <span>
        CAPA 
        @if($jumlah_capa!=null)
            &nbsp;&nbsp;<small class="label bg-green">{{ $jumlah_capa }}</small>
        @endif
    </span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">

        <li class="{{ set_active(['capa.index','capa.create','capa.edit']) }}">
            <a href="{{ route('capa.index') }}">
                <i class="fa fa-circle-o"></i> Pengajuan CAPA
            </a>
        </li>

        <li class="{{ set_active(['capa.verifikasi.index','capa.verifikasi.edit']) }}">
            <a href="{{ route('capa.verifikasi.index') }}">
                <i class="fa fa-circle-o"></i> Verifikasi CAPA
                @if($jumlah_capa!=null)
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">{{ $jumlah_capa }}</small>
                    </span>
                @endif
            </a>
        </li>

        @can('capa-report')                
        <li class="{{ set_active(['capa.report.index','capa.report.filter','capa.report.detail']) }}">
            <a href="{{ route('capa.report.index') }}">
                <i class="fa fa-circle-o"></i> Report CAPA
            </a>
        </li>
        @endcan

        @can('capa-lokasi')                
        <li class="{{ set_active(['capa.lokasi.index']) }}">
            <a href="{{ route('capa.lokasi.index') }}">
                <i class="fa fa-circle-o"></i> Lokasi CAPA
            </a>
        </li>
        @endcan
    </ul>
</li>
        

                     