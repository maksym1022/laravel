@extends('templates.main')

@section('content')  
<div>         
    <h1 style="padding-left:20px">Channel: <strong>nstvnet</strong></h1>
     <h4 style="padding-left:20px">Instagram: <strong>0.000</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Facebook: <strong>0.000</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Twitter: <strong>0.000</strong></h4>
     <span style="padding-left:20px">Network: <strong>NSTV</strong></span>
    <span style="padding-left:20px">Policy: <strong> MANAGED</strong></span><span style="padding-left:20px">MCN: <strong> Nation Studios TV</strong></span>
</div>
<br>
<div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="dashboard-tile detail tile-red">
                            <div class="content">
                                <h1 class="text-left timer" data-from="0" data-to="180" data-speed="2500">
<?php 
$h_id = DB::table('channels')->where('hub_id', '=', $hub_id)->get();
echo count($h_id);
 ?></h1>
                                <p>Subscribers</p>
                            </div>
                            <div class="icon"><i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dashboard-tile detail tile-turquoise">
                            <div class="content">
                                <h1 class="text-left timer" data-from="0" data-to="56" data-speed="2500">0.000</h1>
                                <p>Monthly Views</p>
                            </div>
                            <div class="icon"><i class="fa  fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dashboard-tile detail tile-blue">
                            <div class="content">
                                <h1 class="text-left timer" data-from="0" data-to="32" data-speed="2500"><?='US$ '.number_format(0, 2, '.', ',');?> </h1>
                                <p>Gross Earnings</p>
                            </div>
                            <div class="icon"><i class="fa fa-usd"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dashboard-tile detail tile-purple">
                            <div class="content">
                                <h1 class="text-left timer" data-to="105" data-speed="2500"><?='US$ '.number_format(0, 2, '.', ',');?>  </h1>
                                <p>Ad Earnings</p>
                            </div>
                            <div class="icon"><i class="fa fa-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 style="padding-left:20px">Last Notifications</h2>
                <br>
              <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">How to grow the CPM in 7 steps</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            
                            <div class="panel-body">
                               1. Upgrade Your Channel Meta Data, About Tab and Monetization Settings<br>
2. Improve Your Video Search Engine Optimization<br>
3. Create Amazing, Intriguing Custom Thumbnails<br>
4. Close Caption ALL of your videos – Do it!<br>
5. Increase Your Watch Time = Improved Ranking in Search<br>
6. Better Content, Pick a Topic and Stick to it!<br>
7. Be Brand Safe!
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">How to grow the audience in 6 steps</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                1. Keep more contact with your audience!<br>
2. Use correct Tags (enjoy our optimizer tags)!<br>
3. Create pages in the social networks of your channel, interacting with a new audience!<br>
4. Create thumbnails flashy consistent Video!<br>
5. Search and produce trends on YouTube!<br>
6. Keep the videos in the best quality possible!
                            </div>
                        </div>
                    </div>
@stop                       