@extends('templates.main')
    
    @section('content')    
    @if(Session::get('message'))
        <div class="alert alert-block alert-danger">
			<a href="#" data-dismiss="alert" class="close">×</a>
			<h4>{{ Session::get('message') }}</h4>			
		</div>
    @endif     
	<link rel="stylesheet" href="{{ asset('public/css/chosen.min.css') }}"/>
    <legend>New Menu</legend>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {{ Form::open(array('url' => 'menus/register','class'=>'form-horizontal') ) }}        
        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('titulo', '',array('class' => 'form-control'))}}
            </div>
        </div>       
        <div class="form-group">
            {{ Form::label('icon', 'Icon:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('icon', '',array('class' => 'form-control'))}}
            </div>
        </div> 
        <div class="form-group">
            {{ Form::label('link', 'Link:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('link', '',array('class' => 'form-control'))}}
            </div>
        </div>  
        <div class="form-group">
            {{ Form::label('action','Actions: ', array('class' => 'col-md-2 control-label', 'for' => 'editar-element-6' )) }}                       
            <div class="col-md-6">
            {{ Form::select('actions[]', $actions, null, array('class' => 'chosen-select form-control', 'multiple' => 'multiple', 'data-placeholder' => 'Choose actions...' ))}}
            </div>
        </div>
       
        <div class="form-actions">
            {{ Form::submit('Register',array('class' => 'btn btn-primary'))}}
            {{ Form::button('Cancel',array('class' => 'btn btn-inverse','onclick' => 'history.go(-1);' ))}}
        </div>
    {{ Form::close() }}

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
	<script src="{{ asset('public/js/chosen.jquery.min.js') }}" type="text/javascript"></script>    
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