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
	  <h1>Channel Payments <small>:: Profitability of financial control payments.</small></h1>
	</div>
	@if(Auth::user()->role == 'administrator')  
    <small>Payments measured between days 28 and 28 of the previous month of the current.</small>@endif
	<br>
	<div class="filter-list clearfix">
		@if(Auth::user()->role == 'administrator')  
        <a href="{{asset('')}}finance/csvchannels/month/{{$month}}/year/{{$year}}" id="generate-button" class="btn btn-primary">
            <span class="glyphicon glyphicon-cog"></span> Generate export file</a>
        @endif
	</div>
	@if(count($channels) > 0)
	<form action="{{asset('')}}finance/bulk/1/multiple/{{$month}}/{{$year}}" method="post" class="form-inline" role="form">
		<div class="filter-list clearfix">
			<div class="pull-left action-update">
				<div class="form-group">
				    <label class="sr-only" for="action">Action</label>
				    <select required="required" class="form-control" id="action" name="action">
				    	<option value="finish">Finish</option>
				    </select>
				</div>
				<button type="submit" class="btn btn-default">Apply</button>
			</div>
			<div class="pull-right">
				<div class="form-group">
				    <select class="form-control" id="monthFilter" name="monthFilter">
				    	<option value="">Month...</option>
				    	@for($i=1;$i<=12;$i++)
				    		<option value="{{$i}}" <?php if($i==$month) echo 'selected';?>>{{$i}}</option>
				    	@endfor
				    </select>
				    <select class="form-control" id="yearFilter" name="yearFilter">
				    	<option value="">Year...</option>
				    	@for($i=$first_year;$i<=date("Y");$i++)
				    		<option value="{{$i}}" <?php if($i==$year) echo 'selected';?> >{{$i}}</option>
				    	@endfor
				    </select>
				</div>
				<a href="{{asset('')}}finance/channelspayments/" data-month="{{$month}}" data-year="{{$year}}" id="searchFilter" class="btn btn-default">Apply</a>
			</div>
			
		</div>
		<table id="payments-list" class="table table-striped table-bordered">
			<thead>
				<tr class="head">
					<th><input type="checkbox" name="checkall" id="checkall" value="1"></th>
					<th>Channel Name</th>
					<th>Hub Channel</th>
					<th>Gross Earnings</th>
					<th style="width:7%">%</th>
					<th>Net Earnings</th>
					<th>Ready for Payment</th>
					@if(Auth::user()->role == 'administrator')   
                    <th class="action">Action</th>
                    @endif
					<th style="width:20%">Paid</th>
				</tr>
			</thead>
			<tbody>
				@foreach($channels as $channel)
					<?php $hub=Hub::find($channel->hub_id);
					$payment=Payment::getPaymentFromChannel($channel->id,$month,$year);
					$value=((count($payment) == 1) ? $payment->value : 0);
					$paid=((count($payment) == 1 && $payment->status == 1) ? true : false);?>
				
				<tr>
					<td><input <?php if($value > 1 && !$paid){}  else echo 'disabled="disabled"';?> type="checkbox" class="bulk" name="bulk[]" value="{{$channel->id}}/{{$month}}/{{$year}}/{{$value}}"></td>
					<td>{{$channel->name}}</td>
					<td>{{$hub->name}}</td>
					<td data-percentage="{{$channel->percentage}}" id="{{$channel->id}}/{{$month}}/{{$year}}" class="{{(($paid) ? 'finished' : '');}}">US$ {{number_format($value, 2, '.', ',')}}</td>
					<td>{{$channel->percentage}} %</td>
					<td>US${{number_format($value*($channel->percentage/100), 2, '.', ',')}}</td>
					<td>@if($value > 1) <span class="label label-success">YES</span>@else<span class="label label-danger">NO</span>@endif</td>
					<td class="action">
                        
						@if(!$paid)
							<a class="finish-hub action-update btn btn-sm btn-primary {{(($value > 1) ? '' : 'disabled')}}" href="{{asset('')}}finance/finish/1/{{$channel->id}}/{{$month}}/{{$year}}">Finish</a>
						@else
							<a href="#" class="btn btn-sm btn-success finished">Finished</a>
						@endif
					</td>
					<td>
						@if($paid)<span class="label label-success">Paid</span><br />{{$payment->updated_at}} @endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
        <?php echo $channels->links(); ?>
	</form>
    <script src="{{asset('public/js')}}/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{{asset('public/js')}}/jquery.jeditable.js" type="text/javascript"></script>
	<script type="text/javascript" src="{{asset('public/js')}}/jquery.dataTables.editable.js"></script>
	
	<script type="text/javascript" src="{{asset('public/js')}}/filter.js"></script>
	<script type="text/javascript" src="{{asset('public/js')}}/data.js"></script>
	@else
	<div class="alert alert-block alert-danger">
		<h4>Oops! No record found!</h4>
	</div>
	@endif
@stop