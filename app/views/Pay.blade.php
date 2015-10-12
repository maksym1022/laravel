@extends('templates.main')
@section('content')  
<div class="row">
    <div class="page-header">
    	<h1>Payment Type List <small>:: List of the mothod of payment</small></h1>
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
    <div class="col-md-12">
        <table class="table table-bordered">
        	<tr class="head">
        		<th>ID</th>
        		<th>Channel</th>
        		<th>Paypal</th>
        		<th>Bank Account</th>
        		<th>Unlink</th>
        		<th>Status</th>
        	</tr>
        	@foreach($channels as $channel)
        	<tr>
        		<td>{{$channel->id}}</td>
        		<td>{{$channel->name}}</td>
        		<td>{{$channel->paypal}}</td>
        		<td>{{$channel->bankaccount}}</td>
        		<td>{{$channel->unlink}}</td>
        		<td><span class="label label-especial">{{$channel->st}}</span></td>
        	</tr>
        	@endforeach
        </table>
        <?php echo $channels->links(); ?>
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
@stop