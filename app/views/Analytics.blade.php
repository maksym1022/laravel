@extends('templates.main')
@section('content') 
    @if(Session::get('message'))
    <?php $message = Session::get('message');?>
    <div class="alert alert-block alert-{{$message[0]}}">
    	<a href="#" data-dismiss="alert" class="close">×</a>
    	<h4>{{$message[1]}}</h4>
    	{{$message[2]}}
    </div>
    @endif
    @include('BaseAnalytics')
@stop