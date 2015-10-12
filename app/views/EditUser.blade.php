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

    <legend>Edit User</legend>

    <ul>

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

    {{ Form::open(array('url' => 'users/save/'.$user->id,'class'=>'form-horizontal') ) }}

        {{ Form::hidden('id', $user->id)}}

        <div class="form-group">

            {{ Form::label('first_name', 'First name:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::text('first_name', $user->first_name,array('class' => 'form-control'))}}

            </div>

        </div>  

        <div class="form-group">

            {{ Form::label('last_name','Last name:', array('class' => 'col-md-2 control-label'))}}

        	<div class="col-md-3">

            {{  Form::text('last_name', $user->last_name,array('class' => 'form-control'))}}

            </div>

        </div>

            

        <div class="form-group">

            {{ Form::label('','Username:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::text('',$user->username,array('class' => 'form-control','disabled'=>'disabled'))}}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('email','E-mail:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::text('', $user->email,array('class' => 'form-control','disabled'=>'disabled'))}}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('avatar','Avatar link:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::text('avatar', $user->avatar,array('class' => 'form-control'))}}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('paypal','Payment Email PayPal:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

                {{ Form::text('paypal', $user->paypal,array('class' => 'form-control'))}}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('role_id','Role:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

                @if(Auth::user()->role=='administrator')

                {{ Form::select('role_id', $roles, $user->role_id, ['class' => 'form-control'])}}

                @else

                {{ Form::select('role_id', $roles, $user->role_id, ['class' => 'form-control','disabled'=>'disabled','required' => 1])}}

                @endif

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('hub_id','Hub:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            <?php if(empty($managers->id)){

                $hub = 1;

            }else{

                 $hub = $managers->id;

            }

                

            ?>

            @if(Auth::user()->role=='administrator')

            {{ Form::select('hub_id',$hubs,$hub, ['class' => 'form-control'])}}

            @else

            {{ Form::select('hub_id',$hubs,$hub, ['class' => 'form-control','disabled'=>'disabled','required' => 1])}}

            @endif

            </div>

        </div>

        

        <span style="padding-left:100px"><a href="{{ asset('')}}form/hub//ref/{{$user->id}}" target="_blank">

        <strong>Referall Link: </strong>{{ asset('')}}form/hub//ref/165</a></span>

        <br /><br />

        <legend>Change your password:</legend>

        <div class="form-group">

            {{ Form::label('password','Password:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

                {{ Form::password('password',array('class' => 'form-control'))}}

            </div>

        </div>

        <div class="form-actions">

                {{ Form::submit('Update',array('class' => 'btn btn-primary'))}}

                {{ Form::button('Cancel',array('class' => 'btn btn-inverse','onclick' => 'history.go(-1);' ))}}

            </div>

        {{ Form::close() }}



@stop