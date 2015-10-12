@extends('templates.main')
@section('content')
    @if(Session::get('message'))
        <div class="alert alert-block alert-success">
			<a href="#" data-dismiss="alert" class="close">×</a>
			<h4>{{ Session::get('message') }}</h4>			
		</div>
    @endif 	
    <div class="page-header">
	  <h1>Menus <small>Select the menus to edit or delete.</small></h1>
	</div>
	<div class="filter-list clearfix">
		<a href="{{asset('menus/create')}}" id="add-button" class="btn btn-primary action-create"><span class="glyphicon glyphicon-plus"></span> Add menu</a>
	</div>
    
	 @if(count($menus) > 0)
   
	<table class="table table-striped table-bordered">
		<tr class="head">
			<th>Menu</th>
			<th>Submenus</th>
			<th>Link</th>
			<th class="action">Actions</th>
		</tr>
		@foreach($menus as $menu)
		
         
		<tr>
			<td>{{$menu->titulo}}</td>            
			<td>            
				<?php                 
					$SubMenus = DB::table('submenus')->where("menu_id", $menu->id)->get();
                    ?>
					@if(!is_null($SubMenus)) 
						@foreach ($SubMenus as $submenu)							
                            {{$submenu->titulo}} -> {{$submenu->link}}<a href="{{asset('')}}submenus/edit/{{$submenu->id}}"><small>[EDIT]</small></a> <a href="{{asset('')}}submenus/delete/{{$submenu->id}}"><small>[DELETE]</small></a><br />
						@endforeach
                    @endif
									
				<a href="{{asset('')}}submenus/create/{{$menu->id}}"class="btn btn-sm btn-primary action-update"><span class="glyphicon glyphicon-pencil"></span>Add submenu</a>
			</td>
			<td>{{$menu->link}}</td>
			<td class="action">
				<a href="{{asset('')}}menus/edit/{{$menu->id}}" class="btn btn-sm btn-primary action-update"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
				<a href="{{asset('')}}menus/delete/{{$menu->id}}" class="btn btn-sm btn-primary action-delete"><span class="glyphicon glyphicon-trash"></span> Delete</a>
			</td>
		</tr>
		@endforeach
	</table>
	<?//=((Users::role_check('administrator')) ? $view_paginacao : '');?>
	@else
	<div class="alert alert-block alert-danger">
		<h4>Oops! No record found!</h4>
	</div>
	@endif
@stop    