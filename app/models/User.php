<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;


class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	
	protected $hidden = array('password', 'remember_token');
    
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
    
    public function getAuthPassword()
    {
        return $this->password;
    } 
    
    public function getRememberToken()
    {
        return $this->remember_token;
    }
    
   public function getRememberTokenName()  {
        return "remember_token";
    }
    
    public function getReminderEmail()
    {
        return $this->email;
    }
    public static $rules = array(
        'first_name'=>'required|alpha',
        'last_name'=>'required|alpha',
        'username'=>'required|alpha|unique:users',
        'email'=>'required|email|unique:users',
        'avatar'=>'required',
        'paypal'=>'required',
        'role_id'=>'required',
        'hub_id'=>'required',
    );
    /**
	 * delete user
	 *
	 * @var array
	 */
    public function delete()
    {
        // Delete all of the products that have the same ids...
        DB::table('status_logs')->where("user_id", $this->id)->delete();
        DB::table('login_attempts')->where("user_id", $this->id)->delete();
        /*DB::table('payments')->where("user_id", $this->id)->delete();*/
        $channel = DB::table('channels')->where('user_id', $this->id)->lists('id');
        DB::table('payments')->where('user_id', $this->id)->delete();
        DB::table('analytics')->wherein("channel_id", $channel)->delete();
        DB::table('procedures')->wherein("channel_id", $channel)->delete();
        DB::table('status_logs')->wherein("channel_id", $channel)->delete();
        DB::table('channels')->where("user_id", $this->id)->delete();
        // Finally, delete this category...
        return parent::delete();
    }
    /**
	 * get managers form user with role = network-manager
	 *
	 * @var array
	 */
    public static function getManagers(){
		$managers=self::where('role','network_manager')->get();
		$managerFiltered=array();
		foreach ($managers as $manager)
			if(count(Manager::getManagerByUser($manager->id)) == 0)
				$managerFiltered[$manager->id]=$manager->first_name." ".$manager->last_name;
		return $managerFiltered;
	}
    //show table user
    public static function getAll($order=""){
		$roles=RolesToUsers::getSelectedByUserRoleId();

		if (Role::theRole()->general == 1){
			
			$all = self::paginate(15);
		}
		else {
            if(Manager::where('user_id',Auth::user()->id)->count()){
                $hub_id=Manager::where('user_id',Auth::user()->id)->first()->hub_id;
            }else{
                $hub_id=Manager::first()->hub_id;
            }
			
			$ids=Manager::where('hub_id',$hub_id)->lists('user_id');
			$all = self::whereIn('id',$ids)->whereIn('role_id',$roles)->paginate(15);
		}
		
		return $all;
	}

}
