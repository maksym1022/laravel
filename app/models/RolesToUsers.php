<?php
class RolesToUsers extends Eloquent{	    
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles_to_users';
    protected $guarded = array('id');
    public $timestamps = false;
    
    
	public static function getOptions($menu_id,$field){
		return self::find("all",array("conditions"=>array("$field=?",$menu_id)));
	}
	public static function getSelectOptions($menu_id,$field){
		$options=self::getOptions($menu_id,$field);
		$filtered=array();
		foreach($options as $option){
			$filtered[$option->id]=$option->id;
		}
		return $filtered;
	}
	public static function getSelected($submenu_id,$field='menu_id'){
		$actionstomenus=self::getOptions($submenu_id,$field);
		$actionsFiltered=array();
		foreach($actionstomenus as $action){
			$action=Actions::find($action->action_id);
			$actionsFiltered[$action->id]=$action->slug;
		}
		return $actionsFiltered;
	}
	public static function deleteRelations($menu_id,$field='menu_id'){
		$relations=self::find("all",array('conditions' => array("$field = ?", $menu_id)));
		foreach($relations as $relation){
			Permissions::delete_all(array("conditions"=>array("actions_to_menus_id=?",$relation->id)));
		}

		self::delete_all(array('conditions' => array("$field = ?", $menu_id)));
	}
    public static function getSelectedByUserRoleId($user_role_id=null){
			if(is_null($user_role_id))
				$user_role_id=Auth::user()->role_id;
			$rolestousers=self::where('user_role_id',$user_role_id)->get();
			$rolesFiltered=array();
			foreach($rolestousers as $role){
				$role=Role::find($role->role_id);
				$rolesFiltered[$role->id]=$role->name;
			}
			return $rolesFiltered;
		}
}