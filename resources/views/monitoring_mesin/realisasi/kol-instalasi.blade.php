@if($tgl_instalasi != null )
    <center>{{ date('d-m-Y', strtotime($tgl_instalasi)) }}</center>
@else 
    <center>
    <button type="button" title="Hapus" class="btn btn-primary btn-xs" data-toggle="modal"
        data-target="#updateInstalasi{{ $id }}">
        <i class="fa fa-calendar"></i> Update
    </button>
    </center>

    <div class="modal fade" id="updateInstalasi{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Realisasi Instalasi <strong>{{ $nomor }}</strong> ?</h4>
                </div>
                <form action="{{ route('monitoringmesin.realisasipengiriman.updateInstalasi', $id) }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <label for="" class="col-sm-6 control-label">Tanggal Realisasi Instalasi</label>
                            <div class="col-sm-6">
                                <input type="date" name="tgl_instalasi" class="form-control" required>          
                            </div>
                        </div>  <br><br>                              
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> UPDATE</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>BATAL</button>
                        </center>
                    </div>
                </form>  
            </div>                                         
        </div>
    </div>
@endif