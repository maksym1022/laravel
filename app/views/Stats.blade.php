@extends('templates.main')
    
    @section('content')  
    <?php
    if(Channel::where('partner_id',Auth::user()->id)->count()>0){
       $channel=Channel::where('partner_id',Auth::user()->id)->first(); 
    }else{
         $channel=Channel::first(); 
    }
    ?>
    <img align="left" class="" src="http://i1.ytimg.com/u/{{$channel->chid}}/channels4_banner_hd.jpg" alt=""  width="2000" height="230"/>
<div class="fb-profile">
	<img align="left" class="fb-image-profile thumbnail" src="https://i.ytimg.com/i/{{$channel->chid}}/1.jpg" alt="Profile image example" width="200" height="200"/>
</div>
<h3>Username: <strong><span class="label label-success">{{$channel->name}}</span></strong></h3>
<h4>Channel ID: <span class="label label-especial">UC{{$channel->chid}}</span></h4>
<div class="row">
	<div class="col-md-3 col-sm-6">
		<div class="dashboard-tile detail tile-red">
			<div class="content">
				<h1 class="text-left timer" data-to="105" data-speed="2500">{{Analytic::where('month',date("m"))->where('year',date("Y"))->where('channel_id',$channel->id)->first()->views}}  </h1>
				<p>Monthly views</p>
			</div>
			<div class="icon"><i class="fa  fa-eye"></i>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="dashboard-tile detail tile-turquoise">
			<div class="content">
				<h1 class="text-left timer" data-to="105" data-speed="2500">{{Analytic::where('month',date("m"))->where('year',date("Y"))->where('channel_id',$channel->id)->first()->views_per_day}}  </h1>
				<p>Views per Day</p>
			</div>
			<div class="icon"><i class="fa  fa-eye"></i>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="dashboard-tile detail tile-purple">
			<div class="content">
				<h1 class="text-left timer" data-to="105" data-speed="2500">{{Analytic::where('month',date("m"))->where('year',date("Y"))->where('channel_id',$channel->id)->first()->subscribers_per_day}} </h1>
				<p>Subs per day</p>
			</div>
			<div class="icon"><i class="fa fa-users"></i>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="dashboard-tile detail tile-blue">
			<div class="content">
				<h1 class="text-left timer" data-from="0" data-to="32" data-speed="2500">US$  <?php $payment=Payment::getPaymentFromChannel($channel->id,date("m"),date("Y")); 
					$value=((count($payment) == 1) ? $payment->value : 0); echo $value;?></h1>
				<p>Gross Earnings</p>
			</div>
			<div class="icon"><i class="fa fa-usd"></i>
			</div>
		</div>
	</div>
</div>


@stop