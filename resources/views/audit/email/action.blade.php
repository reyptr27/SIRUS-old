@php
    use App\Models\Departemen;
    use App\Models\Audit\AuditLokasi;

    $lokasi = AuditLokasi::where('status',1)->get();
    $dept = Departemen::where([
                ['status',1],
                ['nama_departemen', '!=' , 'All Department']
            ])->orderBy('nama_departemen','ASC')->get();

@endphp  
   
<style>
    .auditemailupdate-input {
        display: block !important;
        width: 100% !important;
    }

    .auditemailupdate-label {
        font-size: 14px;
        margin-top: 10px; 
        float: left;
    }

    .auditemailupdate-select {
        width: 100% !important; 
        padding: 0;
    }

    .auditemailupdate-button {
        margin-top: 30px;
        text-align: right;
        padding-right: 0px;
    }
</style>

<button type="button" title="Edit" class="btn btn-info btn-xs" data-toggle="modal"
    data-target="#updateAuditEmail{{ $id }}">
    <i class="fa fa-edit"></i>
</button>

<div class="modal fade" id="updateAuditEmail{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
                                        
    <div class="modal-dialog">
        <div class="modal-content">
                                                
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit <strong>{{ $email }}</strong> ?</h4>
            </div>
                                                
            <form action="{{ route('audit-email.update', $id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('patch') }}
                <div class="modal-body">
                                                        
                    <div class="">
                        <label class="auditemailupdate-label" for="">Nama</label>
                        <br>
                        <input class="form-control auditemailupdate-input" type="text" name="nama" placeholder="Nama" value="{{ $nama }}" required>
                    </div>

                    <div class="">
                        <label class="auditemailupdate-label" for="">Email</label>
                        <br>
                        <input class="form-control auditemailupdate-input" type="text" name="email" placeholder="Email User" value="{{ $email }}" required>
                    </div>

                    <div class="">
                        <label class="auditemailupdate-label" for="">Password</label>
                        <br>
                        <input class="form-control auditemailupdate-input" type="text" name="password" placeholder="Password" value="{{ $password }}" required>
                    </div>

                    <div class="form-select">
                        <label class="auditemailupdate-label" for="">Departemen</label>
                        <select style="" name="dept_id" class="form-control auditemailupdate-select" required>
                            <option value="" disabled selected>Pilih Departemen</option>   
                            @foreach($dept as $depts)
                            <option value="{{ $depts->id }}" @if($depts->id == $dept_id) selected @endif>{{ $depts->nama_departemen }}</option>
                            @endforeach   
                        </select>
                    </div>

                    <div class="form-select">
                        <label class="auditemailupdate-label" for="">lokasi</label>
                        <select style="" name="lokasi_id" class="form-control auditemailupdate-select" required>
                            <option value="" disabled selected>Pilih Lokasi</option>   
                            @foreach($lokasi as $lokasis)
                            <option value="{{ $lokasis->id }}" @if($lokasis->id == $lokasi_id) selected @endif>{{ $lokasis->lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                    

                    <div class="modal-footer auditemailupdate-button">
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>                                             
                    </div>
                </div>
            </form>
                
        </div>
    </div>
</div> 


<button type="button" title="Hapus" class="btn btn-danger btn-xs" data-toggle="modal"
    data-target="#hapusAuditEmail{{ $id }}">
    <i class="fa fa-trash"></i>
</button>

<div class="modal fade" id="hapusAuditEmail{{ $id }}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus email <strong>{{ $email }}</strong> ?</h4>
        </div>
        <form action="{{ route('audit-email.destroy', $id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('delete') }}
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
