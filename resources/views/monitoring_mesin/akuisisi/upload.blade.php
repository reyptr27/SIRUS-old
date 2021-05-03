
@if( $upload_file != null )
<center>
    <?php
        $namafile = $upload_file;
        $pisah = explode('.', $namafile);
        $leght = count($pisah)-1;
        $ekstensi = $pisah[$leght];
    ?>
    @if($ekstensi == "pdf")
        {{-- jika pdf --}}

        <a class="btn btn-primary btn-xs" href="{{ route('monitoringmesin.akuisisi.show', $id) }}" target="_blank">
            <i class="fa fa-eye"></i>
        </a>
        
        <a class="btn btn-success btn-xs" href="{{ route('monitoringmesin.akuisisi.download', $id) }}">
            <i class="fa fa-download"></i>
        </a>
    @else
        {{-- jika image --}}
        <button type="button" title="Lihat" class="btn btn-primary btn-xs" data-toggle="modal"
            data-target="#lihatFile{{$id}}">
            <i class="fa fa-eye"></i>
        </button>        
        <a class="btn btn-success btn-xs" title="Download" href="{{ route('monitoringmesin.akuisisi.download', $id) }}">
            <i class="fa fa-download"></i>
        </a>
    @endif
</center>
@else
<center>
    <button type="button" title="Upload" class="btn btn-danger btn-xs" data-toggle="modal"
        data-target="#uploadFile{{$id}}">
        <i class="fa fa-inbox"></i>
    </button>
</center>
@endif

<div class="modal fade" id="uploadFile{{$id}}" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">File belum diupload<strong></strong></h4>
        </div>
        <div class="modal-footer">
            <center>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>CLOSE</button>
            </center>
        </div>
   
    </div>                                         
</div>
</div>


<div class="modal fade" id="lihatFile{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
<div class="modal-dialog modal-lg" width="100%">
    <div class="modal-content">
        
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">File / Dokumen<strong></strong></h4>
        </div>
        
        <div class="modal-body">
            <img src="{{ asset('storage/MonitoringMesin/'.$upload_file) }}" alt="{{$upload_file}}" width="100%">                
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
        </div>
    
    </div>
</div>
</div>  
