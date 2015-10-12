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

	<style type="text/css">table.table tr.locked td{background:#ccc;color:#999}</style>

	<div class="page-header">

	  <h1>Users <small>Select the users to edit or delete.</small></h1>

	</div>
	@if(Auth::user()->role=='administrator')
	<div class="filter-list clearfix">

		<a href="{{ asset('users/create')}}" id="add-button" class="btn btn-primary action-create"><span class="glyphicon glyphicon-plus"></span> Add a new user</a>

	</div>
	@endif
	@if(count($users) > 0)

	<table class="table table-striped table-bordered">

		<tr class="head">

			<th>ID</th>

			<th>Full Name</th>

			

			<th>Email</th>

			<th>Username</th>

			<th>Referall Code</th>

			<th>Role</th>

			<th>Actions</th>

		</tr>

        @foreach($users as $user)

		<tr class="<?=(($user->status == 2) ? 'locked' : '');?>">

		        <td><?=$user->id;?></td>

			<td><?=$user->first_name." ".$user->last_name;?></td>

			

			<td><?=$user->email;?></td>

			<td><?=$user->username;?></td>

			<td><a href="{{ asset('form/hub')}}//ref/{{$user->id}}" target="_blank"><strong>Referall Link </strong></a></td>

			<td>{{$user->role}}</td>

			<td> 

                @if($user->status == 2)

                <a href="{{ asset('')}}users/unlock/{{$user->id}}" class="btn btn-success btn-xs action-update" title="Unlock user"><span class="icon-ok  icon-white"></span> Unlock</a>

                @else

                <a href="{{ asset('')}}users/lock/{{$user->id}}" class="btn btn-danger btn-xs action-update" title="Lock user"><span class="icon-ban-circle  icon-white"></span> Lock</a>

                @endif

                <a href="{{ asset('')}}users/edit/{{$user->id}}" class="btn btn-primary btn-xs action-update" title="Edit user">

                <span class="icon-edit  icon-white"></span> Edit</a> 

                <a href="{{ asset('')}}users/delete/{{$user->id}}" class="btn btn-default btn-xs action-delete" title="Delete user">

                <span class="icon-trash icon-white"></span> Delete</a>

            </td>

		</tr>

		@endforeach

    </table>

    <?php echo $users->links(); ?>    

	@else

	<div class="alert alert-block alert-danger">

		<h4>Oops! No record found!</h4>

	</div>

	@endif

@stop