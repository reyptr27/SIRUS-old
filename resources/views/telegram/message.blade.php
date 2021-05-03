@extends('layouts.layout')

@section('title')
    SIRUS | Telegram Message
@endsection

@section('content')
<div class="content-wrapper">
    <!-- content header -->
    <section class="content-header">
    <h1>
        Telegram Message Broadcast
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Telegram</a></li>
        <li class="active"><a href="{{ route('telegram.message') }}">Telegram Message</a></li>
    </ol>
    </section>  

    <!-- Section konten -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Telegram Message Broadcast</h3>
                    </div>
                    <div class="box-body">
                    <form action="{{ route('telegram.message.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Message</label>
                                <textarea name="message"  rows="5" class="form-control {{ $errors->has('message') ? 'is-invalid':'' }}" placeholder="Input Message"></textarea>
                                <p class="text-danger">{{ $errors->first('message') }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">                                            
                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Broadcast</button>
                        </div>
                    </form>
                    </div>
                </div>   
            </div>
        </div>        
    </section>
</div>
@endsection