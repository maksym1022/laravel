@extends('templates.main')
    
    @section('content')  
    <style type="text/css">
        label span.required {
            color: #B94A48; 
        }
        span.help-inline, span.help-block{ 
            color: #888; font-size: .9em; 
            font-style: italic; 
        }
     </style> 
    @if(Session::get('message'))
    <?php $message = Session::get('message');?>
    <div class="alert alert-block alert-{{$message[0]}}">
    	<a href="#" data-dismiss="alert" class="close">×</a>
    	<h4>{{$message[1]}}</h4>
    	{{$message[2]}}
    </div>
    @endif
    <legend>New Hub</legend>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {{ Form::open(array('url' => 'hubs/register','class'=>'form-horizontal') ) }}
        <div class="form-group">
            {{ Form::label('name','Name:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('name', '',array('class' => 'form-control','required' => 1))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('email','Support Email:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::email('email', '',array('class' => 'form-control','required' => 1))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('website','Website:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('website', '',array('class' => 'form-control','required' => 1))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('paypal','PayPal:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::email('paypal', '',array('class' => 'form-control','required' => 1))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('percentage','Percentage:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('percentage',  $percentage, null, ['class' => 'form-control'])}}
            </div>
        </div>
        <!-- TODO: <div class="form-group">
            {{ Form::label('manager','Manager:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('manager',  array(), null, ['class' => 'form-control'])}}
            </div>
        </div> -->
        <div class="form-actions">
            {{ Form::submit('Create',array('class' => 'btn btn-primary'))}}
            {{ Form::button('Cancel',array('class' => 'btn btn-inverse','onclick' => 'history.go(-1);' ))}}
        </div>
    {{ Form::close() }}

@stop