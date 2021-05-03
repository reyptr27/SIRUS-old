
@if($status == 1)

    <button type="button" title="Status" class="btn btn-primary btn-xs" data-toggle="modal"
        data-target="#showStatus{{ $id }}">Process
    </button>

    <div class="modal fade" id="showStatus{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail Status <strong>{{ $nomor }}</strong></h4>
                </div>
                
                <div class="modal-body">
                    <center><p><b>{{$nomor}}</b> sedang dalam proses. Menunggu proses verifikasi oleh <b>{{$verifikator}}</b>.</p></center> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
                </div>
            </div>
        </div>
    </div> 
@elseif($status == 2)
    <button type="button" title="Status" class="btn btn-success btn-xs" data-toggle="modal"
        data-target="#showStatus{{ $id }}">Done
    </button>

    <div class="modal fade" id="showStatus{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail Status <strong>{{ $nomor }}</strong></h4>
                </div>
                <div class="modal-body">
                    <center><p><b>{{$nomor}}</b> telah diverifikasi oleh <b>{{ $verifikator }}</b>.</p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
                </div>
            </div>
        </div>
    </div>
@elseif($status == 3)
    <button type="button" title="Status" class="btn btn-danger btn-xs" data-toggle="modal"
        data-target="#showStatus{{ $id }}">Rejected
    </button>

    <div class="modal fade" id="showStatus{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail Status <strong>{{ $nomor }}</strong></h4>
                </div>
                
                <div class="modal-body">
                    <center>
                        <p>
                            <b>{{ $nomor }}</b> telah direject / ditolak oleh <b>{{ $verifikator }}</b>. 
                            Silahkan merevisi pengajuan CAPA kemudian klik tombol <b>RE-SEND</b> untuk mengajukan verifikasi ulang.
                        </p>
                    </center>
                    <br><center><b>Feedback</b><br>
                    <p>{{ $model->feedback }}</p></center>
                </div>
                <div class="modal-footer">
                    
                    <form action="{{ route('capa.resend', $id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button type="submit"  class="btn btn-primary pull-left"><i class="fa fa-plane"></i> RE-SEND</button>
                    </form>  

                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
                </div>
            </div>
        </div>
    </div>
@endif