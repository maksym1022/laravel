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
    <legend>New User</legend>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {{ Form::open(array('url' => 'users/register/','class'=>'form-horizontal') ) }}
        <div class="form-group">
            {{ Form::label('first_name', 'First name:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('first_name', '',array('class' => 'form-control'))}}
            </div>
        </div>  
        <div class="form-group">
            {{ Form::label('last_name','Last name:', array('class' => 'col-md-2 control-label'))}}
        	<div class="col-md-3">
            {{  Form::text('last_name', '',array('class' => 'form-control'))}}
            </div>
        </div>
            
        <div class="form-group">
            {{ Form::label('username','Username:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('username', '',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('email','E-mail:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('email', '',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('avatar','Avatar link:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('avatar', '',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('paypal','Payment Email PayPal:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('paypal', '',array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('role_id','Role:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('role_id',  $roles, null, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('hub_id','Hub:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('hub_id',$hubs,null, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-actions">
            {{ Form::submit('Register',array('class' => 'btn btn-primary'))}}
            {{ Form::button('Cancel',array('class' => 'btn btn-inverse','onclick' => 'history.go(-1);' ))}}
        </div>
    {{ Form::close() }}

@stop