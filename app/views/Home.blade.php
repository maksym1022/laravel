@extends('templates.main')
@section('content') 
<h2 style="padding-left:20px">
    <img src="{{Auth::user()->avatar}}" alt="" width="100" height="100" class="img-circle"> 
    Welcome Back, <strong> {{Auth::user()->first_name." ".Auth::user()->last_name}}!</strong> 
    <small>
        <a href="http://cms.nstv.me/manager/form/hub//ref/{{Auth::user()->id}}" target="_blank">
            <span class="label label-especial">
                <strong>Your reference link is http://cms.nstv.me/manager/form/hub//ref/{{Auth::user()->id}}</strong>
            </span>
        </a>
    </small>
</h2>
<br><br>    

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