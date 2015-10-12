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
        <h1>Hubs Payments <small>:: Profitability of financial control payments.</small></h1>
    </div>
	<div class="filter-list clearfix">
		@if(Auth::user()->role == 'administrator')
        <a href="{{asset('')}}finance/csvhubs/month/{{$month}}/year/{{$year}}" id="generate-button" class="btn btn-primary"><span class="glyphicon glyphicon-cog"></span> Generate export file</a>
        @endif
	</div>
	@if(count($payments) > 0)
	
    <form action="{{asset('')}}finance/bulk/2/multiple/{{$month}}/{{$year}}" method="post" class="form-inline" role="form">
		<div class="filter-list clearfix">
            @if(Auth::user()->role=='administrator')
			<div class="pull-left action-update">
				<div class="form-group">
				    <label class="sr-only" for="action">Action</label>
				    <select required="required" class="form-control" id="action" name="action">
				    	<option value="finish">Finish</option>
				    </select>
				</div>
				<button type="submit" class="btn btn-default">Apply</button>
			</div>
            @endif
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
				<a href="{{asset('')}}finance/hubspayments/" data-month="{{$month}}" data-year="{{$year}}" id="searchFilter" class="btn btn-default">Apply</a>
			</div>
			
		</div>
		<table id="payments-list" class="table table-striped table-bordered">
			<thead>
				<tr class="head">
					<th><input type="checkbox" name="checkall" id="checkall" value="1"></th>
					<th>Hub Name</th>
					<th>Gross Earnings</th>
					<th style="width:7%">% RevShare</th>
					<th>Net Earnings</th>
					<th>Ready for Payment</th>
					@if(Auth::user()->role=='administrator')<th class="action">Action</th>@endif
					<th style="width:20%">Paid</th>
				</tr>
			</thead>
			<tbody>
				@foreach($payments as $hub_id => $value)
                <?php
					$hub=Hub::find($hub_id);
					$payment=Payment::getPaymentFromHub($hub_id,$month,$year);
					$paid=((count($payment) == 1 && $payment->status == 1) ? true : false);
				?>
				<tr>
					<td><input <?php if($value > 1 && !$paid){}  else echo 'disabled="disabled"';?> type="checkbox" class="bulk" name="bulk[]" value="{{$hub->id}}/{{$month}}/{{$year}}/{{$value}}"></td>
					<td>{{$hub->name}}</td>
					<?php
						$gross=(100*$value)/$hub->percentage;
					?>
                                        
					<td class="{{(($paid) ? 'finished' : '')}}">US$ {{number_format($gross, 2, '.', ',')}}</td>
					<td>{{$hub->percentage}} %</td>
					<td>US$ {{number_format($value, 2, '.', ',')}}</td>
					<td>@if($value > 1) 
                            <span class="label label-success">YES</span>
                        @else<span class="label label-danger">NO</span>
                        @endif
                    </td>
					@if(Auth::user()->role=='administrator')
                    <td class="action">
						@if(!$paid)
							<a class="finish-hub btn action-update btn-sm btn-primary {{(($value > 1) ? '' : 'disabled')}}" href="{{asset('')}}finance/finishhub/{{$hub->id}}/{{$month}}/{{$year}}/{{$value}}">Finish</a>
						@else
							<a href="#" class="btn btn-sm btn-success finished">Finished</a>
						@endif
					</td>
                    @endif
					<td>
						@if($paid) <span class="label label-success">Paid</span><br />{{$payment->updated_at}} @endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</form>
   
	<script src="{{asset('public/js')}}/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{{asset('public/js')}}/jquery.jeditable.js" type="text/javascript"></script>
    <script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#payments-list').dataTable({
					"bPaginate": true,
					"aoColumnDefs": [
				      { "bSortable": false, "aTargets": [ 0 ] }
				    ]
			})
		})
	</script>
    <script type="text/javascript" src="{{asset('public/js')}}/filter.js"></script>
	<script type="text/javascript" src="{{asset('public/js')}}/data.js"></script>
	@else
	<div class="alert alert-block alert-danger">
		<h4>Oops! No record found!</h4>
	</div>
	@endif
@stop