<li class="treeview {{ set_active([
    'surat.masuk.index','surat.masuk.create','surat.masuk.edit','confirmation.index'
]) }}">
    <!-- treeview header  -->
    <a href="#">
        <i class="fa fa-envelope"></i> 
            <span>
                Surat Masuk
                @if($jumlah_suratmasuk!=null)
                    <small class="label bg-green">{{ $jumlah_suratmasuk }}</small>
                @endif
            </span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <!-- end treeview header  -->
    <!-- treeview menu -->
    <ul class="treeview-menu">
        <li class="{{ set_active(['surat.masuk.index','surat.masuk.create','surat.masuk.edit']) }}" ><a href="{{ route('surat.masuk.index') }}"><i class="fa fa-level-down"></i> Surat Masuk</a></li>
        <li class="{{ set_active(['confirmation.index']) }}" ><a href="{{ route('confirmation.index') }}"><i class="fa fa-check-square"></i> Konfirmasi Surat Masuk 
            
            @if($jumlah_suratmasuk!=null)
            <span class="pull-right-container">
                <small class="label pull-right bg-green">{{ $jumlah_suratmasuk }}</small>
            </span>
            @endif
        </a></li>
    </ul>
    <!-- end treeview menu  -->
</li>