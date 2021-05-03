@extends('layouts.layout')

@section('title')
    SIMIT | Maintenance CCTV
@endsection
    
@section('content')

<div class="content-wrapper">

    <!-- Section Content Header -->
    <section class="content-header">
        <h1> Data Maintenance</h1>

        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#"></a>Maintenance CCTV</li>
        
        </ol>
    
    </section>

    <!-- Section Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <!-- BOX Header -->
                    <div class="box-header with-border">
                        <h3 class="box-title">List Maintenance CCTV</h3>

                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#tambahMtcctv">
                            <i class="fa fa-plus"></i> Tambah
                        </button>

                            <!-- Modal Tambah -->
                            <div class="modal fade" id="tambahMtcctv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                                <div class="modal-dialog modal-lg" role="document" style="width:95%;">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <h4 class="modal-title" id="myModalLabel">Tambahkan Maintenance CCTV</h4>
                                        </div>

                                        <!-- Form Modal Tambah -->
                                        <form action="{{ route('maintenance_cctv.store') }}" method="post">
                                            
                                            {{ csrf_field() }}
                                            <div class="modal-body">


                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td><label for="">Nama Server</label></td>
                                                                <td><input type="text" name="nama_server" class="form-control" placeholder="Nama Server " required></td>
                                                                <td><label for="">Tanggal</label></td>
                                                                <td><input type="date" name="tanggal" class="form-control" placeholder="Tanggal " required></td>

                                                            </tr>
                                                            <tr>
                                                                <td><label for="">Lokasi</label></td>
                                                                <td><input type="text" name="lokasi" class="form-control" placeholder="Lokasi" required></td>
                                                                <td><label for="">Status</label></td>
                                                                <td>
                                                                    <select name="status" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>                                                    
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><label for="">Officer</label></td>
                                                                <td>
                                                                    <select name="officer_id" id="officer_id" class="form-control" required>
                                                                        @foreach($officers as $officer)
                                                                            <option value="{{$officer->id}}">{{ $officer->name }}</option>
                                                                        @endforeach    
                                                                    </select>
                                                                </td>
                                                                <td rowspan="2"><label for="">Catatan</label></td>
                                                                <td rowspan="2"><textarea name="catatan" id="" cols="40" rows="3" class="form-control" required></textarea>    </td>
                                                            </tr>
                                                            <tr>
                                                                <td><label for="">Atasan</label></td>
                                                                <td><input type="text" name="atasan" class="form-control" placeholder="Atasan"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover" id="data-table">
                                                        <thead>
                                                            <th class="bg-blue">NO</th>
                                                            <th class="bg-blue">ITEM PEMERIKSAAN</th>
                                                            <th class="bg-blue">STATUS</th>
                                                            <th class="bg-blue">TINDAKAN MAINTENANCE</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                
                                                                <td class="text-center">1</td>
                                                                <td>
                                                                    Kondisi PC / DVR / NVR
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status1" class="form-control" required> 
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan1" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                
                                                                <td class="text-center">2</td>
                                                                <td>
                                                                    Hasil Recording
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status2" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan2" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td class="text-center">3</td>
                                                                <td>
                                                                    Kapasitas Penyimpanan
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status3" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan3" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td class="text-center">4</td>
                                                                <td>
                                                                    Kondisi Adaptor
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status4" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan4" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                               
                                                                <td class="text-center">5</td>
                                                                <td>
                                                                    Kualitas Gambar Camera
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status5" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan5" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td class="text-center">6</td>
                                                                <td>
                                                                    Kondisi Camera
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status6" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan6" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td class="text-center">7</td>
                                                                <td>
                                                                    Kondisi Splitter
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status7" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan7" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td class="text-center">8</td>
                                                                <td>
                                                                    Kondisi Display (TV / Monitor)
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status8" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan8" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <td class="text-center">9</td>
                                                                <td>
                                                                    Kabel Coaxial / UTP / VGA / HDMI
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status9" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan9" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                               
                                                                <td class="text-center">10</td>
                                                                <td>
                                                                    Keluhan dari user
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status10" class="form-control" required>
                                                                        <option value="1">OK</option>
                                                                        <option value="2">Not OK</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="tindakan10" id="" cols="40" rows="1" class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                                                <button type="submit" class="btn btn-success">SIMPAN</button>
                                            </div>


                                        </form>


                                    </div>
                                </div>

                            </div>
                                        
                    </div>
                    <!-- Box Body -->

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <th class="text-center">NO.</th>
                                    <th class="text-center">TANGGAL</th>
                                    <th class="text-center">NO. MAINTENANCE</th>
                                    <th class="text-center">TINDAKAN MAINTENANCE</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">ACTION</th>
                                </thead>
                                
                                    @php $i = 1; @endphp
                                    @foreach($mt_cctv as $cctv)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{date('d - M - Y', strtotime($cctv->tanggal))}}</td>
                                        <td>{{ $cctv->no_document }}</td>
                                        <td>{{ $cctv->catatan }}</td>
                                        <td class="text-center">
                                            @if($cctv->status == 1 )
                                                <label class="label label-success">OK</label>
                                            @else
                                                <label class="label label-danger">Not-OK</label>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- tombol action -->
                                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                                data-target="#updateMtcctv{{ $cctv->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            {{ csrf_field() }}
                                            <button type="button" class="btn btn-default btn-xs" >
                                                <a href="{{route('maintenance_cctv.cetak',$cctv->id)}}"><i   class="fa fa-print"></i> Cetak</a>
                                            </button>

                                            
                                            
                                            <!-- <a href="{{ route ('maintenance_cctv.cetak', $cctv->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit">Cetak</i></a> -->
                                            
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#hapusMtcctv{{ $cctv->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>   
                                        </td>
                                    </tr>

                                    <!-- Modal Update -->

                                    <div class="modal fade" id="updateMtcctv{{ $cctv->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                                           <div class="modal-dialog modal-lg" role="document" style="width:95%;">
                                               <div class="modal-content">
                                                   <div class="modal-header text-center">
                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                           <span aria-hidden="true">&times;</span>
                                                       </button>
                                                       <h4 class="modal-title" id="myModalLabel">Edit <strong>{{ $cctv->no_document }}</strong> ?</h4>

                                                   </div>

                                                   <!-- Form Modal Update -->
                                                   <form action="{{ route('maintenance_cctv.update',$cctv->id) }}" method="post">

                                                       {{ csrf_field() }}
                                                       {{ method_field('patch') }}
                                                       <div class="modal-body">
                                                            <div class="col-sm-12">
                                                                <div class="col-sm-2">
                                                                    <label for="">Nama Server</label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <input type="text" name="nama_server" value="{{ $cctv->nama_server }}" class="form-control" placeholder="Nama Server " required>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="">Tanggal</label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <input type="date" name="tanggal" value="{{ $cctv->tanggal }}" class="form-control" placeholder="Tanggal " required>
                                                                </div>
                                                                <br><br>

                                                                <div class="col-sm-2">
                                                                    <label for="">Lokasi</label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <input type="text" name="lokasi" value="{{ $cctv->lokasi }}"  class="form-control" placeholder="Lokasi" required>
                                                                </div>

                                                                <div class="col-sm-2">
                                                                    <label for="">Status</label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <select name="status"  class="form-control" required>
                                                                        
                                                                        <option value="1" @if ($cctv->status == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <br><br>
                                                            
                                                                <div class="col-sm-2">
                                                                    <label for="">Officer</label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <select name="officer_id" id="officer_id" class="form-control" required>
                                                                              @foreach($officers as $officer)
                                                                                  <option value="{{$officer->id}}"
                                                                                    @if ($officer->id == $cctv->officer_id)
                                                                                        selected
                                                                                    @endif
                                                                                  >{{ $officer->name }}</option>
                                                                              @endforeach
                                                                    </select>
                                                                </div>
                                                            
                                                                <div class="col-sm-2">
                                                                    <label for="">Catatan</label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <textarea name="catatan"  id="" cols="40" rows="3" class="form-control">{{ $cctv->catatan }}</textarea>  
                                                                </div>
                                                            
                                                                <div class="col-sm-2">
                                                                    <label for="">Atasan</label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                            @foreach($officers as $officer)
                                                                                  
                                                                                    @if ($officer->id == $cctv->officer_id)
                                                                                    <input type="text" name="atasan" value=" {{$officer->atasan->name}}" class="form-control" placeholder="Atasan" id="atasan">
                                                                                    @endif
                                                                                  
                                                                            @endforeach
                                                                 
                                                                                                                                   
                                                                </div>

                                                                <br><br><br>

                                                                <div class="col-sm-12"></div>
                                                                <br><br><br>
                                                                <div class="col-sm-12 bg-blue">
                                                                    <div class="col-sm-1 bg-blue text-center">
                                                                        <label for="">NO</label>
                                                                    </div>
                                                                    <div class="col-sm-3 bg-blue text-center">
                                                                        <label for="">ITEM PEMERIKSAAN</label>
                                                                    </div>
                                                                    <div class="col-sm-2 bg-blue text-center">
                                                                        <label for="">STATUS PEMERIKSAAN</label>
                                                                    </div>

                                                                    <div class="col-sm-6 bg-blue text-center">
                                                                        <label for="">TINDAKAN PEMERIKSAAN</label>
                                                                    </div>
                                                                </div>
                                                                
                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center"><label >1</label></div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Kondisi PC / DVR / NVR</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status1" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status1 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status1 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea name="tindakan1" id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan1 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >2</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Hasil Recording</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status2" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status2 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status2 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea name="tindakan2"  id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan2 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >3</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Kapasitas Penyimpanan</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status3" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status3 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status3 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea name="tindakan3"  id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan3 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >4</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Kondisi Adaptor</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status4" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status4 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status4 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea name="tindakan4"  id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan4 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >5</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Kualitas Gambar Kamera</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status5" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status5 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status5 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea name="tindakan5" id="" cols="40" rows="1" class="form-control"> {{ $cctv->tindakan5 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >6</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Kondisi Kamera</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status6" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status6 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status6 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea name="tindakan6"  id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan6 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >7</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Kondisi Splitter</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status7" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status7 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status7 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea name="tindakan7"  id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan7 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >8</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Kondisi Display ( TV / Monitor )</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status8" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status8 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status8 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <textarea name="tindakan8"  id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan8 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >9</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Kabel Coaxial / UTP / VGA / HDMI</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status9" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status9 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status9 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                <textarea name="tindakan9"  id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan9 }}</textarea>
                                                                </div>

                                                                <br><br><br>
                                                                <div class="col-sm-1 text-center">
                                                                    <label >10</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label for=""> Keluhan dari user</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select name="status10" class="form-control" required>
                                                                        <option value="1" @if ($cctv->status10 == 1 ) selected @endif >OK</option>
                                                                        <option value="2" @if ($cctv->status10 == 2 ) selected @endif >Not OK</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                <textarea name="tindakan10" id="" cols="40" rows="1" class="form-control">{{ $cctv->tindakan10 }}</textarea>
                                                                </div>




                                                                <br><br><br><br>

                                                                <div class="col-sm-2"></div>
                                                                <div class="col-sm-6"></div>
                                                            
                                                            
                                                            </div>

                                                           
                                                                      
                                                                   

                                                       </div>
                                                       <div class="modal-footer">
                                                           <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                                                           <button type="submit" class="btn btn-success">SIMPAN</button>
                                                       </div>


                                                   </form>


                                               </div>
                                           </div>
                                    </div>

                                    <!-- modal hapus -->
                                    <div class="modal fade" id="hapusMtcctv{{ $cctv->id }}" role="dialog" aria-labelledby="myModalLabel">

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Anda yakin ingin menghapus <strong>{{ $cctv->no_document }}</strong> ?</h4>
                                                </div>
                                                
                                                <form action="{{ route('maintenance_cctv.destroy',$cctv->id)}}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <div class="modal-footer">
                                                        <center>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                                                            <button type="submit" class="btn btn-success">HAPUS</button>
                                                        </center>
                                                    </div>
                                                </form> 
                                                    
                                            </div>                                         
                                        </div>
                                    </div> 


                                    @endforeach     
                                
                            </table>
                           
                        </div>
                       
                    </div>
                    
                    
                </div>
               
            </div>
        </div>
    </section>

    


<script type="text/javascript">
  $("select[name='officer_id']").change(function(){
      var id_country = $(this).val();
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "{{route('maintenance_cctv.autofill','officer_id')}}",
          method: 'POST',
          data: {officer_id:officer_id},
          success: function(data) {
            $("select[name='atasan'").html('');
            $("select[name='atasan'").html(data);
          }
      });
  });
</script>


</div>


@endsection
