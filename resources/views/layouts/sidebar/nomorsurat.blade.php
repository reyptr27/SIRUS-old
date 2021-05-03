    <li class="treeview {{ set_active([
            'surat.eksternal.index','surat.eksternal.create','surat.eksternal.edit','tujuan.eksternal.index',
            'surat.hd.index','surat.hd.create','surat.hd.edit','tujuan.hd.index','kategori.hd.index',
            'surat.nhd.index','surat.nhd.create','surat.nhd.edit','tujuan.nhd.index','kategori.nhd.index',
        ]) }}">
            <!-- treeview header  -->
            <a href="#">
                <i class="fa fa-envelope"></i> <span>Nomor Surat</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <!-- end treeview header  -->
            <!-- treeview menu -->
            <ul class="treeview-menu">
                <li class="treeview {{ set_active(['surat.eksternal.index','surat.eksternal.create','surat.eksternal.edit','tujuan.eksternal.index']) }}">
                    <!-- treeview header  -->
                    <a href="#"><i class="fa fa-file-text"></i> Surat Eksternal
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <!-- end treeview header  -->
                    <ul class="treeview-menu">
                        <li class="{{ set_active(['surat.eksternal.index','surat.eksternal.create','surat.eksternal.edit']) }}" ><a href="{{ route('surat.eksternal.index') }}"><i class="fa fa-file-text"></i> Surat Eksternal</a></li>
                        <li class="{{ set_active(['tujuan.eksternal.index']) }}"><a href="{{ route('tujuan.eksternal.index') }}"><i class="fa fa-map-marker"></i> Tujuan</a></li>
                    </ul>
                </li>

                @can('nomorsurat-hd')
                <li class="treeview {{ set_active(['surat.hd.index','surat.hd.create','surat.hd.edit','tujuan.hd.index','kategori.hd.index']) }}">
                    <!-- treeview header  -->
                    <a href="#"><i class="fa fa-envelope-square"></i> Surat Internal HD
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <!-- end treeview header  -->
                    <ul class="treeview-menu">
                        <li class="{{ set_active(['surat.hd.index','surat.hd.create','surat.hd.edit']) }}"><a href="{{ route('surat.hd.index') }}"><i class="fa fa-envelope-square"></i> Surat Internal HD</a></li>
                        <li class="{{ set_active(['tujuan.hd.index']) }}"><a href="{{ route('tujuan.hd.index') }}"><i class="fa fa-map-marker"></i> Tujuan / UP</a></li>
                        <li class="{{ set_active(['kategori.hd.index']) }}"><a href="{{ route('kategori.hd.index') }}"><i class="fa fa-archive"></i> Kategori Surat HD</a></li>
                    </ul>
                </li>
                @endcan

                @can('nomorsurat-nhd')
                <li class="treeview {{ set_active(['surat.nhd.index','surat.nhd.create','surat.nhd.edit','tujuan.nhd.index','kategori.nhd.index']) }}">
                    <!-- treeview header  -->
                    <a href="#"><i class="fa fa-file-archive-o"></i> Surat Internal NHD
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <!-- end treeview header  -->
                    <ul class="treeview-menu">
                        <li class="{{ set_active(['surat.nhd.index','surat.nhd.create','surat.nhd.edit']) }}"><a href="{{ route('surat.nhd.index') }}"><i class="fa fa-file-archive-o"></i> Surat Internal NHD</a></li>
                        <li class="{{ set_active(['tujuan.nhd.index']) }}"><a href="{{ route('tujuan.nhd.index') }}"><i class="fa fa-map-marker"></i> Tujuan / UP</a></li>
                        <li class="{{ set_active(['kategori.nhd.index']) }}"><a href="{{ route('kategori.nhd.index') }}"><i class="fa fa-archive"></i> Kategori Surat NHD</a></li>
                    </ul>
                </li>
                @endcan
            </ul>
            <!-- end treeview menu  -->
        </li>