<?php

class Hub extends Eloquent  {

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'hubs';
    protected $guarded = array('id');
    public $timestamps = false;
	public static function getAll($order="",$inicio="",$limite=""){

		if (Role::theRole()->general == 1){
			$all = self::paginate(15);
		}
		else {
		  $hub_id=Manager::where('user_id',Auth::user()->id)->first()->hub_id;
		  $all = self::where('id',$hub_id)->paginate(15);
            
		}

		return $all;
	}

}
