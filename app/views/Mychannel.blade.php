@extends('templates.main')
@section('content') 
<div class="page-header">
	<h1>My Channel <small>:: See your channel and your features.</small></h1>
</div>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Useful information:</h3>
			<div class="actions pull-right">
				<i class="fa fa-chevron-down"></i>
			</div>
		</div>
		<div class="panel-body">
			This page is only for views of the media and confirmation of insertion means of payment applied channels.
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Emergency cases:</h3>
			<div class="actions pull-right">
				<i class="fa fa-chevron-down"></i>
			</div>
		</div>
		<div class="panel-body">
			If a channel does not receive payment, you should perform a query below.
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label" for="paypal">PayPal</label>  
	<div class="col-md-5">
		<input id="paypal" name="paypal" type="text" placeholder="placeholder" class="form-control input-md" required="" value="<?php $channel=Channel::where('user_id',Auth::user()->id)->firstOrFail();?>{{$channel->paypal}}">
		<span class="help-block">Insert your paypal</span>  
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">List of Requests</h3>
				<div class="actions pull-right">
					<i class="fa fa-chevron-down"></i>
					<i class="fa fa-times"></i>
				</div>
			</div>
			<div class="panel-body">
				<table id="managedlist" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<tr class="head">
						<th>ID</th>
						<th>Channel ID / Name</th>
						<th>Network</th>
						<th>Partner Policy</th>
						<th>Daily Views</th>
						<th>Daily subs</th>
						<th>PayPal</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
					@foreach($channels as $channel)
					<tr>
						<td>{{$channel->id}}</td>
						<td>{{$channel->chid}} / {{$channel->name}} <a href="https://www.youtube.com/channel/UC{{$channel->chid}}" target="_blank"><i class="fa fa-globe"></i></a></td>
						<td>{{Hub::find($channel->hub_id)->name}}</td>
						<td>{{(($channel->cms == 1) ? 'NSTV Affiliate' : 'NSTV Managed')}}</td>
						<td>{{DB::table('analytics')->where('month',date("m"))->where('year',date("Y"))
                            ->where('channel_id',$channel->id)->first()->views_per_day}}</td>
						<td>
                            {{DB::table('analytics')->where('month',date("m"))->where('year',date("Y"))
                            ->where('channel_id',$channel->id)->first()->subscribers_per_day}}
                        </td>
                        <td contenteditable='true'>{{$channel->paypal}}</td>
						<td><span class="label label-especial">{{Status::find($channel->status)->name}}</span></td>
						<td class="action">
							<div class="btn-group">
								<a class="btn btn-sm btn-primary " ><i class=""></i> Action</a>
								<a class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="fa fa-caret-down"></span></a>
								<ul class="dropdown-menu">
									<li class="action-update"><a href="{{asset('')}}/mychannel/edit/{{$channel->id}}"><i class="fa fa-pencil fa-fw"></i> Edit Payment info</a></li>
									<li><a href="{{asset('')}}/mychannel/edit/{{$channel->id}}"><i class="fa fa-pencil fa-fw"></i> Edit payment</a></li>
									<li class="action-update"><a href="#formstatus" class="change-status" data-action="{{asset('')}}/channels/generatestatus" data-channel="{{$channel->id}}" data-toggle="modal" data-target=""><i class="fa fa-retweet"></i> Change Status</a></li>
									<li class="action-update"><a href="#"><i class="fa fa-times-circle-o"></i> Unlinking request</a></li>
									<li class="action-update"><a href="#"><i class="fa fa-check"></i> Catalyser Login</a></li>
								</ul>
							</div>
						</td>
					</tr>
					@endforeach
				</table>
                <?php echo $channels->links(); ?>
			</div>
		</div>
	</div>
</div>
<!-- formModal email -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"> Preview</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			<div class="panel panel-danger hide" id="feedback">
				<div class="panel-heading">
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function(){
	    jQuery(".play-preview").on("click",function(e){
	        e.preventDefault();
	        jQuery('.modal-body').html('<iframe width="100%" height="100%" style="background: #000" border="0" src="'+jQuery(this).attr('data-music')+'"></iframe>');
	        return true;
	    });
	    jQuery(".modal-footer button").on("click",function(e){
	        e.preventDefault();
	        jQuery('.modal-body').html('');
	        return true;
	     });
	});
</script>
<script src="{{asset('')}}jquery.dataTables.min.js" type="text/javascript"></script>

@stop