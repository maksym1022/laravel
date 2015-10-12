<?php

class Role extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';
    protected $guarded = array('id');
    public $timestamps = false;
	public static function getAll(){
		$roles=self::all();
		$rolesFiltered=array();
		foreach($roles as $role)
			$rolesFiltered[$role->id]=$role->role;
		return $rolesFiltered;
	}
	public static function getRole(){
		return Auth::user()->role_id;
	}
	public static function theRole()
	{
		return self::find(self::getRole());
	}
	public static function getRoleName(){
		return self::find(self::getRole())->role;
	}
	public static function getRoles($status_id){
		$roles=self::all();
		$roleFiltered=array();
		foreach ($roles as $role)
			if(count(StatusesRoles::find_by_role_id_and_status_id($role->id,$status_id)) == 0)
				$roleFiltered[$role->id]=$role->name;
		return $roleFiltered;
	}
   
}
