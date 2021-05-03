@can('scm-ba-serahterimabarang')
        <li class="treeview {{ set_active([
            'bagudang.index','bagudang.create','bagudang.edit','alamatgudang.index',
               
        ]) }}">
            <a href="#">
            <i class="fa fa-book"></i> <span>Berita Acara</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                @can('scm-ba-serahterimabarang')                
                <li class="{{ set_active(['bagudang.index','bagudang.create','bagudang.edit']) }}">
                    <a href="{{ route('bagudang.index') }}">
                        <i class="fa fa-book"></i> BA Serah Terima Barang
                    </a>
                </li>
                @endcan
                @can('scm-ba-alamatgudang')
                <li class="{{ set_active(['alamatgudang.index']) }}">
                    <a href="{{ route('alamatgudang.index') }}">
                    <i class="fa fa-institution"></i> Alamat Gudang Penerima</a>
                </li>
                @endcan
                
                
            </ul>
        </li>
        @endcan

                     