@extends('templates.main')

@section('content')  
    @if(Session::get('message'))
        <div class="alert alert-block alert-success">
			<a href="#" data-dismiss="alert" class="close">×</a>
			<h4>{{ Session::get('message') }}</h4>			
		</div>
    @endif
	<div class="page-header">
	  <h1>Statuses <small>Select the status to edit or delete.</small></h1>
	</div>
	<div class="filter-list clearfix">
		<a href="{{asset('statuses/create')}}" id="add-button" class="btn btn-primary action-create"><span class="glyphicon glyphicon-plus"></span> Add Status</a>
	</div>
	@if(count($Statuses) > 0)
	<table class="table table-striped table-bordered">
		<tr class="head">
			<th>Status</th>
			<th>Role(s)</th>
			<th class="action">Actions</th>
		</tr>
		@foreach($Statuses as $status)
		            <?php 
        		            $rols = DB::table('statuses as s')
                            ->join('statuses_roles as st', 's.id', '=', 'st.status_id')
                            ->join('roles as r', 'st.role_id', '=', 'r.id')                   
                            ->where('s.id', $status->id)                    
                            ->select('r.role')
                            ->get();  
                            $count = count($rols);
                            
		           ?>
		<tr>
			<td> {{$status->name;}}</td>
			<td> <?php 
                       $i = 0; 
                       foreach($rols as $role){			              
                          if($i <= $count - 2){                            
			                 echo   $role->role.","; 
			              }else{
			                 echo   $role->role;
			              }
                          $i++;     
			           }                                
                 ?>                         
            @foreach($rols as $role)
			         <?php // echo substr($role->role.",",0,-1); ?>                 
			     @endforeach </td>                
			<td class="action">
				<a href="{{asset('')}}statuses/edit/{{$status->id}}" class="btn btn-sm btn-primary action-update"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
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