<?php

class DependentStatus extends Eloquent  {

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dependent_status';
    protected $guarded = array('id');
    public $timestamps = false;
    public static function getSelected($status_id){
		$dependents=self::find("all",array("conditions"=>array("status_primary_id=?",$status_id)));
		$statusesFiltered=array();
		foreach($dependents as $selected)
			$statusesFiltered[$selected->status_dependent_id]=Statuses::find($selected->status_dependent_id)->name;
		return $statusesFiltered;
	}
	public static function getLinks($status_dependent_id){
		return self::where("status_dependent_id","=",$status_dependent_id)->get();
	}
	public static function deleteRelations($status_id){
		self::delete_all(array('conditions' => array('status_primary_id = ?', $status_id)));
	}

}
