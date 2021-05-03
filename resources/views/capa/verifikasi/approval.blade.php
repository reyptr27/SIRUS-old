
@if($status == 1)
    <input type="hidden" value="PROSES-VERIF">
    <a href="{{ route('capa.verifikasi.edit', $id) }}" title="Verifikasi" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Verifikasi</a>

    <button type="button" title="Reject" class="btn btn-danger btn-xs" data-toggle="modal"
        data-target="#RejectCAPA{{ $id }}">
        <i class="fa fa-close"></i> Reject
    </button>

    <div class="modal fade" id="RejectCAPA{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Reject <strong>{{ $nomor }}</strong> ?</h4>
            </div>
            <form action="{{ route('capa.verifikasi.reject', $id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                
                <div class="modal-body">
                    <h5><strong>Feedback</strong><h5>
                    <textarea name="feedback" cols="60" rows="7" placeholder="Alasan pengajuan CAPA direject / ditolak" class="form-control" required></textarea>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-ban"></i> Reject</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                    </center>
                </div>
            </form>
            </div>                                         
        </div>
    </div>
@elseif($status == 2)
    <input type="hidden" value="VERIFIED">
    <label title="Reject" class="label label-success" data-toggle="modal"
        data-target="#verifikasiCAPA{{ $id }}">
        Telah diverifikasi
    </label>

    <div class="modal fade" id="verifikasiCAPA{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Anda yakin ingin mengupdate Verifikasi <strong>{{ $nomor }}</strong> ?</h4>
            </div>
                <div class="modal-footer">
                    <center>
                        <a href="{{ route('capa.verifikasi.edit', $id) }}" title="Verifikasi" class="btn btn-success"><i class="fa fa-check"></i> Yakin</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                    </center>
                </div>
            </div>                                         
        </div>
    </div>
@else 
    <input type="hidden" value="NOT-VERIF">
    <label class="label label-danger">Telah direject</label>
@endif