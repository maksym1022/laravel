<?php

class StatusesRoles extends Eloquent  {

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'statuses_roles';
    protected $guarded = array('id');
    public $timestamps = false;
	
    public static function getByRole($role){
			$role_id=Roles::find_by_role($role)->id;
			return self::find("all",array("conditions"=>array("role_id=?",$role_id)));
	}
	public static function getSelectedByRole($role){
		$statusesroles=self::getByRole($role);
		$statusFiltered=array();
		foreach($statusesroles as $statusrole){
			$status=Statuses::find($statusrole->status_id);
			$statusFiltered[$status->id]=$status->name;
		}
		return $statusFiltered;
	}
	public static function getStatusesIdByRole($role){
		$statuses=self::getSelectedByRole($role);
		$ids=array();
		foreach($statuses as $key=>$value)
			$ids[$key]=$key;
		return $ids;
	}
	public static function getByStatus($status_id){
		return self::find("all",array("conditions"=>array("status_id=?",$status_id)));
	}
	public static function getSelectedByStatus($status_id){
		$statusesroles=self::getByStatus($status_id);
		$rolesFiltered=array();
		foreach($statusesroles as $statusrole){
			$role=Roles::find($statusrole->role_id);
			$rolesFiltered[$role->id]=$role->role;
		}
		return $rolesFiltered;
	}
	public static function checkLink($status_id,$role_id){
		return ((count(self::whereRaw('status_id > ? and role_id = ?', array($status_id,$role_id))->get()) == 1) ? true : false);
	}
	public static function deleteRelations($status_id){
		self::delete_all(array('conditions' => array('status_id = ?', $status_id)));
	}
}
