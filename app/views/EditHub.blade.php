@extends('templates.main')

    

    @section('content')  

    <link rel="stylesheet" href="{{url()}}/public/css/chosen.min.css">

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

    <legend>Edit Hub</legend>

    <ul>

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

    <?php $attr=((Auth::user()->role=='administrator') ? array("required" => 1) : array("disabled"=>"disabled","required"=>"required"));?>

    {{ Form::open(array('url' => 'hubs/update/'.$id.'/','class'=>'form-horizontal','files' => true) ) }}

        <div class="form-group">

            {{ Form::label('name','Name:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::text('name', $hub->name,array('class' => 'form-control','required' => 1))}}

            </div>

        </div>

        <?php $obslOGO=''; ?>

        @if(!empty($hub->logo))

        <div class="form-group">

            <label class="col-md-2 control-label" for="editchannel-element-11">Current logo:</label>

            <div class="col-md-3">

                <img src="{{url('')}}/public/uploads/logos/{{$hub->logo}}">

            </div>

        </div>

        <?php $obslOGO='<small>(Send another logo will replace the previous)</small>';?>

        @endif

        <div class="form-group">

            <label class="col-md-2 control-label" for="logo">Logo (140px(x)40px):<?php echo $obslOGO ?></label>

            <div class="col-md-3">

            {{ Form::file('logo',array('class' => 'form-control','id'=>'editHub-element-3'))}}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('email','Support Email:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::email('email', $hub->email,array('class' => 'form-control','required' => 1))}}

            </div>

        </div>

         <div class="form-group">

            {{ Form::label('website','Website:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::text('website', $hub->website,array('class' => 'form-control','required' => 1))}}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('paypal','PayPal:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::email('paypal', $hub->paypal,array('class' => 'form-control','required' => 1))}}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('contract_url_form','Contract URL for Channels:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">

            {{ Form::text('contract_url_form', $hub->contract_url_form,array('class' => 'form-control','required' => 1))}}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('percentage_form','Default Percentage for Channels:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">
            @if(Auth::user()->role=='administrator')
            {{ Form::select('percentage_form',  $percentage_form, $hub->percentage_form, ['class' => 'form-control'])}}
            @else
            {{ Form::select('percentage_form',  $percentage_form, $hub->percentage_form, ['class' => 'form-control','disabled'=>'disabled'])}}
            @endif 
            </div>

        </div>

        <div class="form-group">

            {{ Form::label('percentage','Percentage:', array('class' => 'col-md-2 control-label'))}}

            <div class="col-md-3">
            
            @if(Auth::user()->role=='administrator')
            {{ Form::select('percentage',  $percentage, $hub->percentage, ['class' => 'form-control'])}}
            @else
            {{ Form::select('percentage',  $percentage, $hub->percentage, ['class' => 'form-control','disabled'=>'disabled'])}}
            @endif
            </div>

        </div>

       <?php

       $options='';

    	foreach($selected as $key => $value)

    		$options.='<option selected="selected" value="'.$key.'">'.$value.'</option>';

    	foreach($managers as $key => $value)

    		$options.='<option value="'.$key.'">'.$value.'</option>';

       ?>

        <div class="form-group">

            <label class="col-md-2 control-label" for="editar-element-6">

                <span class="required">* </span>Manager:</label>

            <div class="col-md-6">

                <select name="managers[]"  class="chosen-select form-control" multiple="multiple" data-placeholder="Choose managers..." id="editar-element-6">

                <?php echo $options?>

                </select>

            </div>

        </div>

        <div class="form-actions">

            {{ Form::submit('Update',array('class' => 'btn btn-primary'))}}

            {{ Form::button('Cancel',array('class' => 'btn btn-inverse','onclick' => 'history.go(-1);' ))}}

        </div>

    {{ Form::close() }}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>

	<script src="{{url('')}}/public/js/chosen.jquery.min.js" type="text/javascript"></script>

	<script type="text/javascript">



	var config = {

	  '.chosen-select'           : {},

	  '.chosen-select-deselect'  : {allow_single_deselect:true},

	  '.chosen-select-no-single' : {disable_search_threshold:10},

	  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},

	  '.chosen-select-width'     : {width:"95%"}

	}

	for (var selector in config) {

	  $(selector).chosen(config[selector]);

	}

	

	</script>

@stop