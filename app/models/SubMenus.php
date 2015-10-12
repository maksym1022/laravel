<?php
class SubMenus extends Eloquent{
	
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'submenus';
    protected $guarded = array('id');
    public $timestamps = false;
    
	public static function getAll(){
		$roles=self::all();
		$rolesFiltered=array();
		foreach($roles as $role)
			$rolesFiltered[$role->id]=$role->role;
		return $rolesFiltered;
	}
    
    public static $rules = array(
        'menu_id'=>'required',       
        'titulo'=>'required',
        'link'=>'required',
        'actions'=>'required'
    );
    
}