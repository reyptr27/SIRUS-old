        
        @if ( auth()->user()->can('scm-ba-serahterimabarang') || auth()->user()->can('tam-ba') )

        <li class="treeview {{ set_active([
            'bagudang.index','bagudang.create','bagudang.edit','alamatgudang.index',
            'chemical_ro.index','chemical_ro.create','chemical_ro.edit','tam.ba.index',
            'flushing.index','flushing.create','flushing.edit','tam.teknisi.index' ,
            'gantifilter.index','gantifilter.create','gantifilter.edit',
            'gantimedia.index','gantimedia.create','gantimedia.edit',
            'gantimembrane.index','gantimembrane.create','gantimembrane.edit',
            'kalibrasi.index','kalibrasi.create','kalibrasi.edit',
            'tambahmembrane.index','tambahmembrane.create','tambahmembrane.edit',
            'ceklab.index','ceklab.create','ceklab.edit'


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
                    <!-- <a href="#"> -->
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
                @can('tam-ba')
                {{-- <li class="{{ set_active(['chemical_ro.index','chemical_ro.create','chemical_ro.edit']) }}">
                    <a href="{{ route('chemical_ro.index')}}">
                        <i class="fa fa-book"></i> Chemical RO
                    </a>
                </li> --}}
                <li class="{{ set_active(['flushing.index','flushing.create','flushing.edit']) }}">
                    <a href="{{ route('flushing.index')}}">
                        <i class="fa fa-book"></i> Flushing Pipa
                    </a>
                </li>
                <li class="{{ set_active(['gantifilter.index','gantifilter.create','gantifilter.edit']) }}">
                    <a href="{{ route('gantifilter.index')}}">
                        <i class="fa fa-book"></i> Penggantian Filter
                    </a>
                </li>
                <li class="{{ set_active(['gantimedia.index','gantimedia.create','gantimedia.edit']) }}">
                    <a href="{{ route('gantimedia.index')}}">
                        <i class="fa fa-book"></i> Penggantian Media
                    </a>
                </li>
                <li class="{{ set_active(['gantimembrane.index','gantimembrane.create','gantimembrane.edit']) }}">
                    <a href="{{ route('gantimembrane.index')}}">
                        <i class="fa fa-book"></i> Penggantian Membrane
                    </a>
                </li>
                <li class="{{ set_active(['kalibrasi.index','kalibrasi.create','kalibrasi.edit']) }}">
                    <a href="{{ route('kalibrasi.index')}}">
                        <i class="fa fa-book"></i> Kalibrasi Mesin
                    </a>
                </li>
                <li class="{{ set_active(['tambahmembrane.index','tambahmembrane.create','tambahmembrane.edit']) }}">
                    <a href="{{ route('tambahmembrane.index')}}">
                        <i class="fa fa-book"></i> Penambahan Membrane
                    </a>
                </li>
                <li class="{{ set_active(['ceklab.index','ceklab.create','ceklab.edit']) }}">
                    <a href="{{ route('ceklab.index')}}">
                        <i class="fa fa-book"></i> Form Cek Lab
                    </a>
                </li>
                @endcan
                @can('tam-ba-rs')
                <li class="{{ set_active(['tam.ba.index']) }}">
                    <a href="{{ route('tam.ba.index') }}">
                    <i class="fa fa-institution"></i> Data Rumah Sakit</a>
                </li>
                
                <li class="{{ set_active(['tam.teknisi.index']) }}">
                    <a href="{{ route('tam.teknisi.index') }}">
                    <i class="fa fa-group"></i> Data Teknisi</a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
        

                     