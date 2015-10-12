@extends('templates.main')
@section('content') 
    @if(Session::get('message'))
    <?php $message = Session::get('message');?>
    <div class="alert alert-block alert-{{$message[0]}}">
    	<a href="#" data-dismiss="alert" class="close">×</a>
    	<h4>{{$message[1]}}</h4>
    	{{$message[2]}}
    </div>
    @endif
    <div class="page-header">
	  <h1>Hubs <small>Select the hubs to edit or delete.</small></h1>
	</div>
	<div class="filter-list clearfix">
		@if(Auth::user()->role == 'administrator')
        <a href="{{url('')}}/hubs/create" id="add-button" class="btn btn-primary action-create"><span class="glyphicon glyphicon-plus"></span> Add a hub</a>
        @endif
	</div>
	@if(count($hubs) > 0)
	<table class="table table-striped table-bordered">
		<tr class="head">
			<th>ID</th>
			<th>Hub </th>
			<th>#</th>
			<th>Support Email</th>
			<th>Website</th>
			<th>Form URL</th>
			<th style="width:3%">%</th>
			<th class="action" style="width:25%">Actions</th>
		</tr>
		@foreach($hubs as $hub)
		<tr>
			<td>{{$hub->id}}</td>
			<td>{{$hub->name}}</td>
			<td>{{Channel::where('hub_id',$hub->id)->count()}}</td>
			<td>{{$hub->email}}</td>
			<td>{{$hub->website}}</td>
			<td><a href="{{asset('')}}form/hub/{{$hub->id}}" target="_blank">{{asset('')}}form/hub/{{$hub->id}}</a></td>
			<td>{{$hub->percentage}}%</td>
			<td class="action">
				<div class="btn-group" align="right" >
				  <a class="btn btn-primary btn-sm">Actions</a>
				  <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
				    <span class="fa fa-caret-down"></span></a>
				  <ul class="dropdown-menu">
				  	<li>
				  		<a href="{{asset('')}}hubs/edit/{{$hub->id}}" class="btn btn-sm action-update"><i class="fa fa-pencil fa-fw"></i> Edit</a>
				  		@if(Auth::user()->role=='administrator')
                        <a href="{{asset('')}}hubs/csvemails/{{$hub->id}}" class="btn btn-sm generate-csv action-create"><i class="fa fa-cog fa-fw"></i> Generate Emails CSV</a>
				  		@endif
                        <a href="{{asset('')}}hubs/delete/{{$hub->id}}" class="btn btn-sm action-delete"><i class="fa fa-times-circle-o fa-fw"></i> Delete</a>
				  	</li>
				  </ul>
				</div>
			</td>
		</tr>
		@endforeach
	</table>
    <?php echo $hubs->links(); ?>
	<script type="text/javascript" src="{{asset('public/js')}}/email.js"></script>
	@else
	<div class="alert alert-block alert-danger">
		<h4>Oops! No record found!</h4>
	</div>
	@endif
@stop