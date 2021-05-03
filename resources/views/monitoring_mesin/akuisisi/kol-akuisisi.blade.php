<?php
    use App\User;
    use App\Models\Monitoring_Mesin\Pengiriman_Detail;
    $detail = Pengiriman_Detail::where(['header_id' => $id])->get();
?>

@if(empty($detail))
    <label class="label label-warning">Not set</label>
@else 
    @php 
        $ak = 2;
        foreach ($detail as $row) {
            if($row->akuisisi == 1){
                $ak = 1;
                break;
            }
        }
    @endphp

    @if($ak == 2)
        <label class="label label-success">Telah Diakuisisi</label>
    @else 
        <label class="label label-danger">Belum Diakuisisi</label>
    @endif
@endif