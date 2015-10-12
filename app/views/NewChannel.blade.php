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
    <legend>New Channel</legend>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {{ Form::open(array('url' => 'channels/register','class'=>'form-horizontal') ) }}
        <div class="form-group">
            {{ Form::label('hub_id','Hub:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('hub_id',$hubs,null, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('channel_name','Channel Name:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('channel_name', '',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('channel_email','E-mail:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('channel_email', '',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('full_name','Full name:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('full_name', '',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('paypal','Payment Email PayPal:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('paypal', '',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('status','Status:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('status',  $statuses, null, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('percentage','Percentage:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('percentage',  $percentage, null, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-actions">
            {{ Form::submit('Create',array('class' => 'btn btn-primary'))}}
            {{ Form::button('Cancel',array('class' => 'btn btn-inverse','onclick' => 'history.go(-1);' ))}}
        </div>
    {{ Form::close() }}

@stop