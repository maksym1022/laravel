<?php
class Actions extends Eloquent{
   
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'actions';
    protected $guarded = array('id');
    public $timestamps = false;   
   
	public static function getAll(){
		$actions=self::all();
		$actionsFiltered=array();
		foreach($actions as $action)
			$actionsFiltered[$action->id]=$action->slug;
		return $actionsFiltered;
	}
}