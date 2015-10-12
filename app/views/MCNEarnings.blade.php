@extends('templates.main')
@section('content') 
    	<div class="page-header">
	  <h1>MCN Earnings<small> :: Overview of Multi-Channel Network profits</small></h1>
	</div>
	@if(count($payments) > 0)
	<form action="{{asset('')}}finance/mcnearnings/" method="post" class="form-inline" role="form">
		<div class="filter-list clearfix">
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
				<a href="{{asset('')}}finance/mcnearnings/" data-month="{{$month}}" data-year="{{$year}}" id="searchFilter" class="btn btn-default">Apply</a>
			</div>
			
		</div>
		<table id="payments-list" class="table table-striped table-bordered">
			<thead>
				<tr class="head">
					<th>Hub Name</th>
					<th>Global profit Hub</th>
					<th>MCN Earnings</th>
				</tr>
			</thead>
			<tbody>
				<?php $totalHub=$totalMCN=0; ?>
                @foreach($payments as $hub_id => $value)
					<?php
                    $totalHub +=$value;
					$hub=Hub::find($hub_id);
					$payment=Payment::getPaymentFromHub($hub_id,$month,$year);
				    ?>
				<tr>
					<td>{{$hub->name}}</td>
					<?php
						$PercentageMCN=100-$hub->percentage;
						$gross=(100*$value)/$hub->percentage;
						$MCNEarnings=$gross*($PercentageMCN/100);
						$totalMCN+=$MCNEarnings;
					?>
					<td>US$ {{number_format($value, 2, '.', ',')}}</td>
					<td>US$ {{number_format($MCNEarnings, 2, '.', ',')}}</td>
				</tr>
				@endforeach
				<tr>
					<td><strong>Total</strong></td>
					<td><strong>US$ {{number_format($totalHub, 2, '.', ',')}}</strong></td>
					<td><strong>US$ {{number_format($totalMCN, 2, '.', ',')}}</strong></td>
				</tr>
			</tbody>
		</table>
	</form>
   
	<script type="text/javascript" src="{{asset('public/js')}}/filter.js"></script>
	@else
	<div class="alert alert-block alert-danger">
		<h4>Oops! No record found!</h4>
	</div>
	@endif
@stop