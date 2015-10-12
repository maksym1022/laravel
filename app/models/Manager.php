<?php

class Manager extends Eloquent  {

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'managers';
    protected $guarded = array('id');
    public $timestamps = false;
	
    public static function getManagerByHub($hub_id){
		return self::where('hub_id',$hub_id)->first();
	}
	public static function getManagersByHub($hub_id){
		$managers=self::where('hub_id',$hub_id)->get();
		$managersFiltered=array();
		foreach($managers as $manager){
			$user=User::find($manager->user_id);
			$managersFiltered[$manager->user_id]=$user->first_name." ".$user->last_name;
		}
		return $managersFiltered;
	}
    public static function getAllUsersByHub($hub_id){
		return self::where('hub_id',$hub_id)->get();
	}
	public static function getManagerByUser($user_id){
	   if(self::where('user_id',$user_id)->count()>0){
	       return self::where('user_id',$user_id)->first();
	   }else{
	       return 0;
	   }
		
	}
	public static function validateManager($user_id,$hub_id){
		return self::where('user_id',$user_id)->where('hub_id',$hub_id)->count();
	}
	public static function validatePrivileges($user_id){
		if(self::where('user_id',$user_id)->count() > 0){
		    $register=self::where('user_id',$user_id)->first();
			$hub_id=$register->hub_id;
			$ids=array();
			foreach(self::getAllUsersByHub($hub_id) as $user)
				$ids[$user->user_id]=$user->user_id;
			return((in_array(Auth::user()->id, $ids)) ? true : false);
		}else return false;
	}
	public static function deleteManagers($hub_id){
		self::where('hub_id', $hub_id);
	}
	public static function deleteManagersByUser($user_id){
		self::where('user_id', $user_id)->delete();
	}
    public static function validateAccess($channel_id){
        $hub = self::whereRaw('id > ?', array($channel_id))->get();
        if(count($hub)==1 && Auth::role=='Network Manager'){
            
    		return (($hub[0]->hub_id == Channel::where('id', '=', $channel_id)) ? true : false);
    	}else 
            return false;
    }

}
