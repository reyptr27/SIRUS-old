<?php 
    use App\User;
    $user = User::where(['id' => $id])->first();
?>
@if(!empty($user->getRoleNames()))
    @foreach($user->getRoleNames() as $v)
        <label class="label label-success">{{ $v }}</label><br>
    @endforeach
@endif