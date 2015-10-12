@extends('templates.main')
@section('content')	
    <div class="page-header">
	  <h1>Roles <small>Select the roles to edit or delete.</small></h1>
	</div>
	<div class="filter-list clearfix">
		<a href="{{asset('roles/create')}}" id="add-button" class="btn btn-primary action-create"><span class="glyphicon glyphicon-plus"></span> Add role</a>
	</div>   
    
	@if(count($roles) > 0)
    
	<table class="table table-striped table-bordered">
		<tr class="head">
			<th>Role name</th>
			<th>Allowed roles</th>
			<th class="action">Actions</th>
		</tr>
		@foreach($roles as $role)		                  
		<tr>
			<td>{{$role->name}}</td>
			<td>
				<?php 
					$i=0;
					$roles=null;
                    $permitted_roles = DB::table('roles_to_users')->where("user_role_id", $role->id)->get();                                    
                ?>    					
					@if(!is_null($permitted_roles))
						@foreach($permitted_roles as $allowed_role)						  
							<?php $i++;
							$roles[$i] = Role::find($allowed_role->role_id)->name;
                            ?>                            
						@endforeach                       
						{{(!is_null($roles) ? implode(",",$roles) : '')}}
					@endif				
			</td>
			<td class="action">
				<a href="{{asset('')}}roles/edit/{{$role->id}}" class="btn btn-sm btn-primary action-update"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
				<a href="{{asset('')}}roles/delete/{{$role->id}}" class="btn btn-sm btn-primary action-delete"><span class="glyphicon glyphicon-trash"></span> Delete</a>
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