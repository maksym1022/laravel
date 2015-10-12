@extends('templates.main')

@section('content') 

<style type="text/css">

	span.label.label-especial{

	color:#5D5F63;

	border:thin solid #DFDFDF;

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

<div class="page-header">

	<h1>Channels <small>:: Overall listing channels.</small></h1>

</div>

<div class="filter-list clearfix">

	<div class="pull-left">

		@if(Auth::user()->role == 'administrator')

		<a href="{{asset('')}}channels/create" id="add-button" class="btn btn-primary action-create">

		<span class="glyphicon glyphicon-plus"></span> Add a new Channel

		</a>

		@endif

	</div>

	<div class="pull-left">

		@if(Auth::user()->role == 'administrator')

		<a href="{{asset('')}}channels/edit/{{Auth::user()->id}}" id="add-button" class="btn btn-primary action-create" style="margin-left:50px" data-><span class="glyphicon glyphicon-plus"></span> Update Analytics</a> 

		@endif

	</div>

	<div class="pull-right">

		<div class="btn-group" align="right" >

			<a class="btn btn-primary"><i class="fa fa-search "></i> Channel Status Filter</a>

			<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">

			<span class="fa fa-caret-down"></span></a>

			<ul class="dropdown-menu">

				<li><a href="{{asset('')}}channels"></i> All</a></li>

				@foreach($statuses as $status)

				<li><a href="{{asset('')}}channels/status/{{$status->id}}"></i> {{$status->name}}</a></li>

				@endforeach

			</ul>

		</div>

	</div>

</div>

<br>

@if(count($channels) > 0)

<table class="table table-striped table-bordered dataTable" id="channelslist" cellspacing="-1" width="100%">

	<thead>

		<tr class="head">

			<th>ID</th>

			<th>Channel Name</th>

			<th>Hub</th>

			<!-- <th>Referral</th>

			<th>CMS</th>

			<th>AVG</th>

			<th>AVG Subs</th>

			<th>Network</th> -->

			<th>Status</th> 

			<th class="action" style="width:20%">Action</th>

		</tr>

	</thead>

	<tbody>

		@foreach($channels as $channel)

		<tr>

			<td>{{$channel->id}}</td>

			<td>

				{{$channel->name}} 

				<div style="float:right">

					<a href="https://www.youtube.com/{{$channel->name}}" target="_blank"><i class="fa fa-globe"></i></a>&nbsp;

					<a href="http://socialblade.com/youtube/channel/{{$channel->name}}" target="_blank">

						<i class="fa fa-bar-chart-o"></i>

				</div>

			</td>

			<td>{{Hub::find($channel->hub_id)->name}}</td>

			<!-- <td>

            @if(!empty($channel->user_id))

                {{User::find($channel->user_id)->first_name." ".User::find($channel->user_id)->last_name }}

             @endif

            </td>

			<td>@if ($channel->CMS == 1) NSTV Affiliate @else NSTV Managed @endif</td>

			<td>@if(DB::table('analytics')->where('month',date("m"))->where('year',date("Y"))->where('channel_id',$channel->id)->count())
            {{DB::table('analytics')->where('month',date("m"))->where('year',date("Y"))

                            ->where('channel_id',$channel->id)->first()->views_per_day}}
                  @else
                  0
                  @endif           
            </td>
               
			<td>
                @if(DB::table('analytics')->where('month',date("m"))->where('year',date("Y"))->where('channel_id',$channel->id)->count())
                {{DB::table('analytics')->where('month',date("m"))->where('year',date("Y"))
                ->where('channel_id',$channel->id)->first()->subscribers_per_day}}
                @else
                0
                @endif 
            </td>

			<td>{{ucfirst($channel->network)}}</td> -->

			<td>

			<span class="label label-especial">{{Status::find($channel->status)->name}}</span>

			</td>

			<td class="action">

			<div class="btn-group">

			<a class="btn btn-sm btn-primary " ><i class=""></i> Action</a>

			<a class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" href="#">

			<span class="fa fa-caret-down"></span></a>

			<ul class="dropdown-menu">

			<li class="action-update"><a href="{{asset('')}}channels/edit/{{$channel->id}}"><i class="fa fa-pencil fa-fw"></i> Edit Channel</a></li>

			<li class="action-update"><a href="#formstatus" class="change-status" data-action="{{asset('')}}channels/generatestatus" data-channel="{{$channel->id}}" data-toggle="modal" data-target=""><i class="fa fa-retweet"></i> Change Status</a></li>

			<li class="action-update"><a href="#"><i class="fa fa-times-circle-o"></i> Unlinking request</a></li>

			<li class="action-update"><a href="#"><i class="fa fa-check"></i> Catalyser Login</a></li>

			<li><a href="#formModal" data-channel="{{$channel->id}}" class="send-email" data-toggle="modal" data-target=""><i class="fa fa-envelope-o"></i> Send email</a></li>

			</ul>

			</div>

			</td>

		</tr>

		@endforeach

	</tbody>

</table>

<?php echo $channels->links(); ?>  

<!-- formModal email -->

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

				<h4 class="modal-title" id="myModalLabel"> Send Email</h4>

			</div>

			<div class="modal-body">

				<form data-channel="" data-link="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>" id="form-send-email" class="form-horizontal" role="form" action="{{asset('channels/send')}}/">

					<div class="form-group">

						<label for="subject" class="col-sm-2 control-label">Subject</label>

						<div class="col-sm-10">

							<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">

						</div>

					</div>

					<div class="form-group">

						<label for="message" class="col-sm-2 control-label">Message</label>

						<div class="col-sm-10">

							<textarea  class="form-control ckeditor" name="message" id="message" style="height:450px;"></textarea>

						</div>

					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="button" id="send-email-start" class="btn btn-primary">Send</button>

				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

			</div>

			<div class="panel panel-danger hide" id="feedback">

				<div class="panel-heading">

				</div>

			</div>

		</div>

	</div>

</div>

<!-- formModal status-->

<div class="modal fade" id="formstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

				<h4 class="modal-title" id="myModalLabel"> Change Status</h4>

			</div>

			<div class="modal-body">

				<form class="form-horizontal" data-item="" action="{{asset('')}}channels/updatestatus/" data-link="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>" id="form-update-status-channel" role="form">

					<h4>Select a status for the save</h4>

					<br>

					<div class="form-group">

						<select required="required" class="form-control input-sm" name="channel-status" id="channel-status">

                        </select>

					</div>

					<h5>Note: After changing the status can not be returned.</h5>

				</form>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				<button type="button" id="update-status-channel" class="btn btn-primary">Save</button>

			</div>

			<div class="panel panel-danger hide" id="feedback">

				<div class="panel-heading">

				</div>

			</div>

		</div>

	</div>

</div>

<script src="{{asset('public/js/')}}/ckeditor/ckeditor.js" type="text/javascript"></script>

<script src="{{asset('public/js/')}}/ckeditor/adapters/jquery.js" type="text/javascript"></script>

<script src="{{asset('public/js/')}}/jquery.dataTables.min.js" type="text/javascript"></script>

<script type="text/javascript">

	jQuery(document).ready(function(){

		jQuery('#channelslist').dataTable({

				"bPaginate": false

		});

	})

</script>

<script type="text/javascript" src="{{asset('public')}}/js/status.js"></script>

<script type="text/javascript" src="{{asset('public')}}/js/email.js"></script>

@else

<div class="alert alert-block alert-danger">

	<h4>Oops! No record found!</h4>

</div>

@endif

@stop