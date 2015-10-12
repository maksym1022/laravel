<?php

class Status extends Eloquent  {

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'statuses';
    protected $guarded = array('id');
    public $timestamps = false;
	
    public static function getAll(){
		$statuses=StatusesRoles::getStatusesIdByRole(Roles::getRoleName());
		return self::find("all",array("conditions"=>array("id IN(?)",$statuses)));
	}
	public static function showAll(){
		$statuses=self::getAll();
		$statusesFiltered=array();
		foreach($statuses as $status)
			$statusesFiltered[$status->id]=$status->name;
		return $statusesFiltered;
	}
	public static function getLast(){
		$statuses=StatusesRoles::getStatusesIdByRole(Roles::getRoleName());
		return max(array_values($statuses));
	}
	public static function countStatus(){
		return count(self::getAll());
	}
    
    public static $rules = array(
        'name'=>'required',       
        'role_id'=>'required',
    );
    
}
