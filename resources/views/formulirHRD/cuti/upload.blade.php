

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

        <a class="btn btn-primary btn-xs" href="{{ route('hrd.cuti.show', $id) }}" target="_blank">
        <i class="fa fa-eye"></i></a>
        <button type="button" title="Upload" class="btn btn-success btn-xs" data-toggle="modal"
            data-target="#uploadBa{{$id}}">
            <i class="fa fa-upload"></i>
        </button>
        
        <a class="btn btn-danger btn-xs" href="{{ route('hrd.cuti.download', $id) }}">
        <i class="fa fa-download"></i></a>
    @else
        {{-- jika selain image --}}
        <button type="button" title="Lihat" class="btn btn-primary btn-xs" data-toggle="modal"
            data-target="#lihatFile{{$id}}">
            <i class="fa fa-eye"></i>
        </button>        
        <button type="button" title="Upload" class="btn btn-success btn-xs" data-toggle="modal"
            data-target="#uploadBa{{$id}}">
            <i class="fa fa-upload"></i>
        </button>
        <a class="btn btn-danger btn-xs" title="Download" href="{{ route('hrd.cuti.download', $id) }}">
        <i class="fa fa-download"></i></a>
    @endif
</center>
@else
<center>
    <button type="button" title="Upload" class="btn btn-success btn-xs" data-toggle="modal"
        data-target="#uploadBa{{$id}}">
        <i class="fa fa-upload"></i>
    </button>
</center>
@endif

<div class="modal fade" id="uploadBa{{$id}}" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pilih file / Dokumen <strong></strong></h4>
            </div>
        <form action="{{ route('hrd.cuti.upload', $id) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Upload Dokumen / File (pdf, jpg, jpeg, png)</label><br>
                    @if($upload_file != null)
                        <br>
                        @if($ekstensi == "pdf")
                            <img src="{{ asset('assets/images/pdf.png')}}" style="width:30%; height:30%"><br>
                            <label for=""><strong>Nama File :</strong> {{ $upload_file}}</label><br>
                        @else                            
                            <!-- <img src="{{ asset('assets/images/jpg.png')}}" style="width:30%; height:30%"><br> -->
                            <img src="{{ asset('storage/FormCuti/'.$upload_file)}}" style="width:45%; height:45%"><br>
                            <!-- <img src="{{ Storage::url('/BeritaAcara/baranggudang/1588222175_sticker-CTPS.jpg')}}" width="30%"><br> -->
                                                        
                            <label for=""><strong>Nama File :</strong> {{ $upload_file}}</label><br>
                        @endif                    
                    @endif
                    <label for="">Pilih File</label>
                    <input type="file" name="upload_file" class="form-control 
                    {{ $errors->has('upload_file') ? 'is-invalid':'' }}"
                     value="{{ old('upload_file') }}" 
                    accept="image/png, image/jpeg, application/pdf" required>
                    <p class="text-danger">{{ $errors->first('upload_file') }}</p>
                </div>

            </div>
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> UPLOAD</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>BATAL</button>
                </center>
            </div>
        </form>     
        </div>                                         
    </div>
</div>


<div class="modal fade" id="lihatFile{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
    <div class="modal-dialog modal-lg" width="100%">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Form Cuti<strong></strong></h4>
            </div>
            
            <div class="modal-body">
                <img src="{{ asset('storage/FormCuti/'.$upload_file) }}" alt="{{$upload_file}}" width="100%">                
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        
        </div>
    </div>
</div>  
