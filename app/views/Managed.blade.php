@extends('templates.main')
@section('content') 
<div class="page-header">
	<h1>Managed Requests <small>:: Channels are requesting managed</small></h1>
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
				<table id="managedlist" class="table table-striped table-bordered dataTable" id="managerslist" cellspacing="0" width="100%">
					<tr class="head">
						<th>ID</th>
						<th>Channel ID / Name</th>
						<th>Hub</th>
						<th>CMS Actual</th>
						<th>VPD</th>
						<th>SPD</th>
						<th>Reason</th>
						<th>Status</th>
					</tr>
					@foreach($channels as $channel)
					<tr>
						<td>{{$channel->id}}</td>
						<td>{{$channel->chid}} / {{$channel->name}}</td>
						<td>{{Hub::find($channel->hub_id)->name}}</td>
						<td>@if($channel->CMS == 1) NSTV Affiliate @else NSTV Managed @endif</td>
						<td>{{DB::table('analytics')->where('month',date("m"))->where('year',date("Y"))
                            ->where('channel_id',$channel->id)->first()->views_per_day}}</td>
						<td>
                            {{DB::table('analytics')->where('month',date("m"))->where('year',date("Y"))
                            ->where('channel_id',$channel->id)->first()->subscribers_per_day}}
                        </td>
						<td>{{$channel->managed_reason}}</td>
						<td><span class="label label-especial">{{Status::find($channel->status)->name}}</span></td>
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
<script src="{{asset('public/js/')}}/jquery.dataTables.min.js" type="text/javascript"></script>
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
         jQuery('#managerslist').dataTable({
				"bPaginate": true
		});
	});
</script>

@stop