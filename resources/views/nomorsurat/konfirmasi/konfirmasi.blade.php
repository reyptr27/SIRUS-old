{{-- Terima --}}
@if($tindakan == 1)
    <button type="button" title="Terima" class="btn btn-primary btn-xs" data-toggle="modal"
        data-target="#terima{{$id}}">
        <i class="fa fa-check-square"></i> Diterima
    </button>
@else
    <button type="button" title="Terima" class="btn btn-default btn-xs" disabled>
        <i class="fa fa-check-square"></i> Diterima
    </button>
@endif

<div class="modal fade" id="terima{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menerima surat <strong>{{ $nomor }}</strong> ?</h4>
        </div>
        <form action="{{ route('confirmation.statusUpdate', $id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <input type="hidden" name="tindakan" value="2">
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-primary">YA</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">TIDAK</button>
                </center>
            </div>
        </form>     
        </div>                                         
    </div>
</div> 


{{-- Balas  --}}
@if($perlu_balasan == 1)
    @if($tindakan < 3)
        <button type="button" title="Balas" class="btn btn-success btn-xs" data-toggle="modal"
            data-target="#balas{{$id}}">
            <i class="fa fa-reply"></i> Dibalas
        </button>
    @else 
        <button type="button" title="Balas" class="btn btn-default btn-xs" disabled>
            <i class="fa fa-reply"></i> Dibalas
        </button>
    @endif

    <div class="modal fade" id="balas{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Anda yakin telah membalas surat <strong>{{ $nomor }}</strong> ?</h4>
            </div>
            <form action="{{ route('confirmation.statusUpdate', $id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="modal-body">
                    <center>
                        <p style="color: red">Isi pembuktian menggunakan nomor surat / keterangan lain</p> <br>
                        <input type="hidden" name="tindakan" value="3">
                        <label for="Balasan">Balasan</label><br>
                        <textarea name="balasan" rows="5" class="form-control" placeholder="Balasan / Pembuktian" style="width: 400px !important" required>{{ $balasan }}</textarea>
                    </center>
                </div>

                <div class="modal-footer">
                    <center>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
                    </center>
                </div>
            </form>     
            </div>                                         
        </div>
    </div> 
@endif

