<?php



class Channel extends Eloquent  {



	



	/**

	 * The database table used by the model.

	 *

	 * @var string

	 */

	protected $table = 'channels';

    protected $guarded = array('id');

    public $timestamps = false;

	public static function getChannel($id){

	   return  self::where('id', '=', $id)->first();

	}

    public static function getChannels($status=""){

		$StatusSetPoint=Status::orderBy('id', 'DESC')->first()->id+1;

		$role = Role::theRole();

		$user_id = Auth::user()->id;

		if ($role->general == 1){

			if ($role->role == 'partner') {

				$all=(!empty($status) && is_numeric($status)) ? self::where("status",$status)->where("partner_id",$user_id)->paginate(15) : self::where("status",'<',$StatusSetPoint)->where("partner_id",$user_id)->paginate(15);

			}

			else if($role->role == 'recruiter') {

			 

				$all=(!empty($status) && is_numeric($status)) ? self::where("status",$status)->where("user_id",$user_id)->paginate(15) : self::where("status",'<',$StatusSetPoint)->where("user_id",$user_id)->paginate(15);

			}

			else {
			 
				$all=(!empty($status) && is_numeric($status)) ? self::where("status",$status)->paginate(15) : self::where("status",'<',$StatusSetPoint)->paginate(15);

			}
			
		}

		else {

			$hub_id=Manager::getManagerByUser(Auth::user()->id)->hub_id;

			if ($role->role == 'partner') {

				$all=(!empty($status) && is_numeric($status)) ? self::where("status",$status)->where("hub_id",$hub_id)->where("partner_id",$user_id)->paginate(15) : self::where("status",$StatusSetPoint)->where("hub_id",$hub_id)->where("partner_id",$user_id)->paginate(15);

			}

			else if($role->role == 'recruiter') {

				$all=(!empty($status) && is_numeric($status)) ? self::where("status",$status)->where("hub_id",$hub_id)->where("user_id",$user_id)->paginate(15) : self::where("status",$StatusSetPoint)->where("hub_id",$hub_id)->where("user_id",$user_id)->paginate(15);

			}

			else {

				$all=(!empty($status) && is_numeric($status)) ? self::where("status",$status)->where("hub_id",$hub_id)->paginate(15) : self::where("hub_id",$hub_id)->paginate(15);

			}

		}

		return $all;

	}

}

