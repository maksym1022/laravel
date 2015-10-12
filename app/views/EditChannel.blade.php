@extends('templates.main')
    
    @section('content')  
    <style type="text/css">
        label span.required {
            color: #B94A48; 
        }
        span.help-inline, span.help-block{ 
            color: #888; font-size: .9em; 
            font-style: italic; 
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
    <legend>Edit Channel</legend>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <?php
	$attr=((Auth::user()->role=='administrator') ? array("required" => 1) : array("disabled"=>"disabled","required"=>"required"));
    
    ?>
    {{ Form::open(array('url' => 'channels/update/'.$channel->id,'class'=>'form-horizontal','files' => true) ) }}
        @if(Auth::user()->role=='administrator')
        <div class="form-group">
            {{ Form::label('hub_id','Hub:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('hub_id',$hubs,$channel->hub_id, ['class' => 'form-control'])}}
            </div>
        </div>
        
        <div class="form-group">
            {{ Form::label('partner_id','Partner ID Login:' , array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('partner_id', $channel->partner_id,array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('chid','Channel ID:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('chid', $channel->chid ,array('class' => 'form-control'))}}
            </div>
        </div>
        @endif
        <div class="form-group">
            {{ Form::label('banner','Banner link:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('banner', $channel->banner,array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('','*Name:', array('class' => 'col-md-2 control-label'))}}
           <div class="col-md-6">
               <span class="label label-especial">{{$channel->name}}</span>&nbsp;&nbsp;
               <a href="https://www.youtube.com/channel/{{$channel->chid}}" target="_blank"><i class="fa fa-globe"></i></a>
           </div>
        </div>
        <div class="form-group">
            {{ Form::label('email','E-mail:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::email('email', $channel->email,array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('full_name','Full name:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('full_name', $channel->full_name ,array('class' => 'form-control'))}}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('paypal','Payment Email PayPal:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::email('paypal', $channel->paypal,array('class' => 'form-control'))}}
            </div>
        </div>
        @if(Auth::user()->role=='administrator')
        <div class="form-group">
            {{ Form::label('user_id','CA ID:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('user_id', $channel->user_id, ['class' => 'form-control'])}}
            </div>
        </div>
        
        <div class="form-group">
            {{ Form::label('capercentage','CA Percentage:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('capercentage',  $capercentage, $channel->capercentage, ['class' => 'form-control'])}}
            </div>
        </div>
        @endif
        <div class="form-group">
            {{ Form::label('bankaccount','Bank Account:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::text('bankaccount', $channel->bankaccount, ['class' => 'form-control'])}}
            </div>
        </div>
        @if(Auth::user()->role=='administrator')
        <?php
            switch ($channel->CMS) {
		 	case 1:
		 		$cms='NSTV Affiliate';
		 		break;
		 	case 2:
		 		$cms='NSTV Managed';
		 		break;
		 	default:
		 		$cms='NSTV Affiliate';
		 		break;
        	$cmsOptions=array("1"=>"NSTV Affiliate","2"=>"NSTV Managed");
		} 
        ?>
        <div class="form-group">
            {{ Form::label('cms','CMS:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('cms',array("1"=>"NSTV Affiliate","2"=>"NSTV Managed"),null, ['class' => 'form-control',"required" => 1])}}
            </div>
        </div>
        @endif
        <div class="form-group">
            {{ Form::label('percentage','Channel percentage:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{ Form::select('percentage',  $capercentage, $channel->percentage, ['class' => 'form-control'])}}
            </div>
        </div>
        <legend><small>Upload the contract with the signature of the owner of the channel</small></legend>
        <?php $obsContract='';?>
        @if(!empty($channel->contract))
        <div class="form-group">
            <label class="col-md-2 control-label">Current contract:</label>
            <div class="col-md-3">
                <a href="{{asset('')}}public/uploads/contracts/{{$channel->contract}}" target="_blank">'{{$channel->contract}}</a>
            </div>
        </div>
        <?php $obsContract='&lt;small&gt;(Send another contract will replace the previous)&lt;/small&gt;';?>
        @endif
        <div class="form-group">
            <label class="col-md-2 control-label" for="editchannel-element-16">Contract: <small>(Send another contract will replace the previous)</small></label>
            <div class="col-md-3">
            {{ Form::file('contract', ['class' => 'form-control'])}}
            </div>
        </div>
        <?php 
            $date=((!empty($channel->dateofuntying)) ? date("Y-m-d",strtotime($channel->dateofuntying)) : ''); 
        ?>
        <div class="form-group">
            {{ Form::label('dateofuntying','Closing Agreement:', array('class' => 'col-md-2 control-label'))}}
            <div class="col-md-3">
            {{Form::input('date', 'dateofuntying', $date, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-actions">
            {{ Form::submit('Updadte',array('class' => 'btn btn-primary'))}}
            {{ Form::button('Cancel',array('class' => 'btn btn-inverse','onclick' => 'history.go(-1);' ))}}
        </div>
    {{ Form::close() }}

@stop