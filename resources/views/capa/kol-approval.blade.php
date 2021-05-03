<?php
    use App\Models\CAPA\CAPA;
    use App\Models\CAPA\CapaFlow;
    use App\User;

    $flow = CapaFlow::where('capa_id',$id)->get();
?>

@if($status == 1)
    <a href="{{ route('capa.approval', $id) }}" title="Lihat" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Approval</a>
@else 
    <button type="button" title="Approval" class="btn btn-default btn-xs" data-toggle="modal"
        data-target="#showApproval{{ $id }}"><i class="fa fa-check"></i> Approval</a>
    </button>

    <div class="modal fade" id="showApproval{{ $id }}" role="dialog" aria-labelledby="myModalLabel">                               
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">List Approval <strong>{{ $nomor }}</strong></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover" width="100%">
                        <tr>
                            <th class="text-center" width="10%">Layer</th>
                            <th class="text-center">Nama User</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Waktu Approval</th>
                            <th class="text-center">Upload File</th>
                            <th class="text-center" width="25%">Feedback</th>
                        </tr>
                        @foreach($flow as $row)
                            <tr>
                                <td class="text-center">{{ $row->layer }}</td>
                                <td>
                                    @php 
                                        $user = User::where(['id' => $row->user_id])->first();
                                        echo $user->name; 
                                    @endphp
                                </td>
                                <td class="text-center">
                                    @if($row->status>0)
                                        @if($row->status == 2)
                                            <label class="label-success"> Approved </label>
                                        @elseif($row->status == 1)
                                            <label class="label-warning"> Waiting Approval </label>
                                        @endif
                                    @else
                                        <label class="label-danger"> Rejected </label>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($row->time == null)
                                        -
                                    @else
                                        {{ date('d-m-Y H:i', strtotime($row->time)) }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($row->upload == 0)
                                        -
                                    @elseif($row->upload == 1)
                                        <i class="fa fa-check"></i>
                                    @else
                                        <i class="fa fa-close"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($row->feedback == null)
                                        <center>-</center>
                                    @else
                                        @php
                                            echo nl2br(htmlspecialchars($row->feedback));
                                        @endphp
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
                </div>
            </div>
        </div>
    </div>
@endif

