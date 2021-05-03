        
        @if ( 
            auth()->user()->can('monitoring-mesin') || auth()->user()->can('monitoring-mesin-acct') || auth()->user()->can('monitoring-mesin-hd')
            || auth()->user()->can('monitoring-mesin-tam') || auth()->user()->can('monitoring-mesin-scm') || auth()->user()->can('monitoring-mesin-tipe')
        ) 

        <li class="treeview {{ set_active([
            'monitoringmesin.tipe.index','monitoringmesin.tipe.create','monitoringmesin.tipe.edit',
            'monitoringmesin.stock.index','monitoringmesin.stock.create','monitoringmesin.stock.edit',
            'monitoringmesin.penerimaan.index','monitoringmesin.penerimaan.create','monitoringmesin.batal.index',
            'monitoringmesin.rekomendasi.index','monitoringmesin.rekomendasi.create','monitoringmesin.selesai.index',
            'monitoringmesin.rencanapengiriman.index','monitoringmesin.rencanapengiriman.edit','monitoringmesin.realisasipengiriman.index',
            'monitoringmesin.akuisisi.index','monitoringmesin.akuisisi.edit','monitoringmesin.report.index','monitoringmesin.report.filter','monitoringmesin.report.detail'
        ]) }}">
            <a href="#">
            <i class="fa fa-truck"></i> <span>Monitoring Mesin</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                @can('monitoring-mesin-scm')                
                <li class="{{ set_active(['monitoringmesin.penerimaan.index','monitoringmesin.penerimaan.create','monitoringmesin.penerimaan.edit']) }}">
                    <a href="{{ route('monitoringmesin.penerimaan.index') }}">
                        <i class="fa fa-circle-o"></i> Penerimaan Mesin
                    </a>
                </li>
                @endcan

                @can('monitoring-mesin-hd')                
                <li class="{{ set_active(['monitoringmesin.rekomendasi.index','monitoringmesin.rekomendasi.create']) }}">
                    <a href="{{ route('monitoringmesin.rekomendasi.index') }}">
                        <i class="fa fa-circle-o"></i> Rekomendasi Mesin
                    </a>
                </li>
                @endcan

                @can('monitoring-mesin-tam')                
                <li class="{{ set_active(['monitoringmesin.rencanapengiriman.index','monitoringmesin.rencanapengiriman.edit']) }}">
                    <a href="{{ route('monitoringmesin.rencanapengiriman.index') }}">
                        <i class="fa fa-circle-o"></i> Rencana Pengiriman
                    </a>
                </li>

                <li class="{{ set_active(['monitoringmesin.realisasipengiriman.index']) }}">
                    <a href="{{ route('monitoringmesin.realisasipengiriman.index') }}">
                        <i class="fa fa-circle-o"></i> Realisasi Pengiriman
                    </a>
                </li>
                @endcan

                @can('monitoring-mesin-hd')                
                <li class="{{ set_active(['monitoringmesin.selesai.index']) }}">
                    <a href="{{ route('monitoringmesin.selesai.index') }}">
                        <i class="fa fa-circle-o"></i> Approval Penyelesaian Mesin
                    </a>
                </li>
                @endcan

                @can('monitoring-mesin-acct')                
                <li class="{{ set_active(['monitoringmesin.akuisisi.index','monitoringmesin.akuisisi.edit']) }}">
                    <a href="{{ route('monitoringmesin.akuisisi.index') }}">
                        <i class="fa fa-circle-o"></i> Akuisisi Mesin
                    </a>
                </li>
                @endcan

                <li class="{{ set_active(['monitoringmesin.report.index','monitoringmesin.report.filter','monitoringmesin.report.detail']) }}">
                    <a href="{{ route('monitoringmesin.report.index') }}">
                        <i class="fa fa-circle-o"></i> Report Monitoring Mesin
                    </a>
                </li>

                <li class="{{ set_active(['monitoringmesin.batal.index']) }}">
                    <a href="{{ route('monitoringmesin.batal.index') }}">
                        <i class="fa fa-circle-o"></i> Pengiriman Dibatalkan
                    </a>
                </li>

                <li class="{{ set_active(['monitoringmesin.stock.index','monitoringmesin.stock.create','monitoringmesin.stock.edit']) }}">
                    <a href="{{ route('monitoringmesin.stock.index') }}">
                        <i class="fa fa-circle-o"></i> Stock Mesin
                    </a>
                </li>

                @can('monitoring-mesin-tipe')                
                <li class="{{ set_active(['monitoringmesin.tipe.index','monitoringmesin.tipe.create','monitoringmesin.tipe.edit']) }}">
                    <a href="{{ route('monitoringmesin.tipe.index') }}">
                        <i class="fa fa-circle-o"></i> Tipe Mesin
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
        

                     