<?php

class Payment extends Eloquent  {

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payments';
    protected $guarded = array('id');
    public $timestamps = false;
    
    public static function getPaymentsToExport($month,$year){
		return self::whereRaw("month=? AND year=? AND status=0 AND value > 1",array($month,$year))->get();
	}
	public static function getHubsPaymentsToExport($month,$year){
	    if(Role::theRole()->general == 1 ){
	       $hubs = Hub::all();
	    }else{
	       	$hub_id=Manager::getManagerByUser(Auth::user()->id)->hub_id;
            $hubs =array(Hub::find($hub_id));
	    }
	
		foreach($hubs as $hub){
			$channels=Channel::where('hub_id',$hub->id)->get();
			$valueHub=0;
			foreach($channels as $channel){
				$pagamento=Payment::getPaymentFromChannel($channel->id,$month,$year);
				$value        = !is_null($pagamento) ? $pagamento->value : 0;
				$percentageSd = (100-intval($channel->percentage))/100;
				$valueSd      = $value*$percentageSd;
				$valueFinish  = $valueSd*($hub->percentage/100);
				$valueHub+=$valueFinish;
			}
			$valueHubFinish[$hub->id]=$valueHub;
		}
		return $valueHubFinish;
	}
    public static function getFirstYear(){
		return self::orderBy('year', 'ASC')->first()->year;
	}
    /**
	 * get  table Payments from Channel id
     * @param  int  $channel_id
     * @param  int  $month
     * @param  int  $year
	 * @return one rows of table payments
	 */
	public static function getPaymentFromChannel($channel_id,$month,$year){
		return self::where('channel_id',$channel_id)
                ->where('month',$month)
                ->where('year',$year)->first();
	}
    /**
	 * get  table Payments from Hub
     * @param  int  $hub_id
     * @param  int  $month
     * @param  int  $year
	 * @return one row of table payments
	 */
	public static function getPaymentFromHub($hub_id,$month,$year){
		return self::where('hub_id',$hub_id)
                ->where('month',$month)
                ->where('year',$year)->first();
	}
}
