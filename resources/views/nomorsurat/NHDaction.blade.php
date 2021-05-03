<a href="{{ route('surat.nhd.edit', $id) }}" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
@can('nomorsurat-hapus')
<div class="modal fade" id="hapusSurat{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $no_surat }}</strong> ?</h4>
        </div>
        <form action="{{ route('surat.nhd.destroy', $id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-trash-o"></i> HAPUS</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>BATAL</button>
                </center>
            </div>
        </form>     
        </div>                                         
    </div>
</div> 

<button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusSurat{{ $id }}">
    <i class="fa fa-trash"></i>
</button>   
@endcan