@if($approval == 1)
    <button type="button" title="Approval" class="btn btn-primary btn-xs" data-toggle="modal"
        data-target="#Approval{{ $id }}">
        Process
    </button>

    <div class="modal fade" id="Approval{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Status Approval Surat <strong>{{ $nomor_surat }}</strong></h4>
            </div>
            <div class="modal-body">
                <label for="" class="label label-primary" style="font-size:15px;">Menunggu Approval HRD</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
            </div>                                         
        </div>
    </div>
@elseif($approval == 2)
    <button type="button" title="Approval" class="btn btn-success btn-xs" data-toggle="modal"
        data-target="#Approval{{ $id }}">
        Approved
    </button>

    <div class="modal fade" id="Approval{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Status Approval Surat <strong>{{ $nomor_surat }}</strong></h4>
            </div>
            <div class="modal-body">
                <label for="" class="label label-success" style="font-size:15px;">Disetujui oleh HRD</label>
            </div>
            <div class="modal-footer">         
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>    
            </div>
            </div>                                         
        </div>
    </div>

@elseif($approval == 3)
    <button type="button" title="Approval" class="btn btn-danger btn-xs" data-toggle="modal"
        data-target="#Approval{{ $id }}">
        Rejected
    </button>

    <div class="modal fade" id="Approval{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Status Approval Surat <strong>{{ $nomor_surat }}</strong></h4>
            </div>
            <div class="modal-body">
                <label for="" class="label label-danger" style="font-size:15px;">Ditolak oleh HRD</label><br><br>
                <center>
                   <h5><strong>Feedback dari HRD</strong></h5>
                </center>
                <p>{{ $feedback }}</p>
                <br>
                <p style="color:red;">Sebelum melakukan <b>Resend Approval</b>, mohon untuk dilakukan revisi sesuai dengan permintaan HRD.</p>
            </div>
            <form action="{{ route('surattugas.approval.resend', $id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-send"></i> Resend Approval</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
            </form>
            </div>                                         
        </div>
    </div>
@endif