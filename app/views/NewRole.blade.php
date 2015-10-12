<?php $options = array(); 
foreach($relations as $relation){    	   
   $menu_id = $relation->menu_id;
   $action_id = $relation->action_id;
   $id = $relation->id;       
   $submenu_id = $relation->submenu_id;    
   
   $slug_actions = DB::table('actions')->where('id', $action_id)->first();      
   if(!is_null($submenu_id) && !is_null($menu_id)){                                                                                   
        $permission = Menus::get_permissions($submenu_id);                                                       
		$options[] .='<option value="'.$id.'">'.$permission.'->'.SubMenus::find($submenu_id)->titulo.((!is_null($action_id)) ? '->'.$slug_actions->slug : '').'</option>';                                        
	}elseif(!is_null($menu_id) && is_null($submenu_id)){
		$menus_titulo = DB::table('menus')->where('id', $menu_id)->first();  
        $options[] .='<option value="'.$id.'">'.$menus_titulo->titulo.((!is_null($action_id)) ? '->'.$slug_actions->slug : '').'</option>';                
	}              
}?>
@extends('templates.main')
    
    @section('content')    
    @if(Session::get('message'))
        <div class="alert alert-block alert-danger">
			<a href="#" data-dismiss="alert" class="close">×</a>
			<h4>{{ Session::get('message') }}</h4>			
		</div>
    @endif     
	<link rel="stylesheet" href="{{ asset('public/css/chosen.min.css') }}"/>
    <legend>New Role</legend>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {{ Form::open(array('url' => 'roles/register','class'=>'form-horizontal') ) }}        
        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('name', '',array('class' => 'form-control'))}}
            </div>
        </div>       
        <div class="form-group">
            {{ Form::label('roles','Allowed roles: ', array('class' => 'col-md-2 control-label', 'for' => 'editar-element-6' )) }}                       
            <div class="col-md-6">
            {{ Form::select('roles[]', $roles, null, array('class' => 'chosen-select form-control', 'multiple' => 'multiple', 'data-placeholder' => 'Choose roles...' ))}}
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 control-label" for="editar-element-6">Choose permissions:</label>
            <div class="col-md-6">
                <select name="permissions[]" class="chosen-select form-control" multiple="multiple" data-placeholder="Choose roles..." id="editar-element-6"><?php echo implode(" ",$options);   ?></select>
            </div>
        </div>
            
        <div class="form-group">
            {{ Form::label('general','General Data:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">            
            {{ Form::select('general',$general,null, ['class' => 'form-control'])}}
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