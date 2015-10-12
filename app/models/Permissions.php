<?php
class Permissions extends Eloquent{
    
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permissions';
    protected $guarded = array('id');
    public $timestamps = false;
    
	public static function getSelectedByUserRoleId($role_id=null){
		if(is_null($role_id)){
			$role_id=Auth::user()->id;
        }            
		//$Permissions=self::find("all",array("conditions"=>array("role_id=?",$role_id))); 
        $Permissions = permissions::where('role_id', $role_id)->get();                 
		$permissionsFiltered=array();
		foreach($Permissions as $permission){		     
			$relation=ActionsToMenus::find($permission->actions_to_menus_id);   
            $slug_actions = DB::table('actions')->where('id', $relation->action_id)->first();             
			if(!is_null($relation->submenu_id) && !is_null($relation->menu_id)){
			     $permission = Menus::get_permissions($relation->submenu_id);			     
				$name=$permission.'->'.SubMenus::find($relation->submenu_id)->titulo.((!is_null($relation->action_id)) ? '->'.$slug_actions->slug : '');
			}elseif(!is_null($relation->menu_id) && is_null($relation->submenu_id)){
			    $menus_titulo = DB::table('menus')->where('id', $relation->menu_id)->first();                  
				$name=Menus::find($relation->menu_id)->titulo.((!is_null($relation->action_id)) ? '->'.$slug_actions->slug : '');
			}
			$permissionsFiltered[$relation->id]=$name;                            
		}        
		return $permissionsFiltered;
	}
	public static function checkPermission($actions){
		$permissions=self::whereIn('actions_to_menus_id',$actions)->where('role_id',Role::getRole())->count();
		return(( $permissions > 0 )? true : false);
	}
	public static function validatePermission($controller,$action=''){
		
		$controller=str_replace('Controller','',$controller);
		$action=str_replace('index_action','',$action);

		$create_actions=array(
			'create',
			'register',
			'csvemails',
			'csvhubs',
			'csvchannels',
			'send',
			'processar',
			'insertvalue'
		);
		
		$read_actions=array(
			'show'
		);
		
		$update_actions=array(
			'edit',
			'update',
			'updatestatus',
			'unlock',
			'lock',
			'processar',
			'bulk',
			'finish',
			'finishhub'
		);
		
		$delete_actions=array(
			'delete'
		);

		if(in_array($action, $create_actions)){
			$slug='create';
		}elseif(in_array($action, $read_actions)){
			$slug='read';
		}elseif(in_array($action, $update_actions)){
			$slug='update';
		}elseif(in_array($action, $delete_actions)){
			$slug='delete';
		}else{
			$slug=null;
		}
		$action_to_menu=null;

		$link=$controller.'/'.$action.'/';

		$menu=Menus::find_by_link($link);
		if(is_null($menu))
			$menu=Menus::find_by_link($controller.'/');
		$submenu=SubMenus::find_by_link($link);
		if(is_null($submenu))
			$submenu=Submenus::find_by_link($controller.'/');

		if(!is_null($slug)){
			$action_obj=Actions::find_by_slug($slug);
			if(!is_null($action_obj)){
				if(!is_null($menu)){
					$action_to_menu=Actions_To_Menus::find_by_menu_id_and_action_id($menu->id,$action_obj->id);
				}
				elseif(!is_null($submenu)){
					$action_to_menu=Actions_To_Menus::find_by_submenu_id_and_action_id($submenu->id,$action_obj->id);
				}
			}
		}

		if((is_null($menu) && is_null($submenu) && is_null($action_to_menu)) || ((!is_null($menu) && !Menus::checkPermission($menu->id)) && (!is_null($submenu) && !Menus::checkPermission($submenu->id,'submenu_id'))) ||  (!is_null($action_to_menu) && is_null(Permissions::find_by_actions_to_menus_id_and_role_id($action_to_menu->id,Roles::getRole()))))
			return generalHelper::go(SITE);

		//Ocultando botões de actions não permitidas
		$actions = Actions::getAll();
		$css = '<style>';

		if(!is_null($menu)){
			foreach ($actions as $id => $slug){
				$action_exact_to_menu=Actions_To_Menus::find_by_menu_id_and_action_id($menu->id, $id);
				if ( !is_null($action_exact_to_menu)) {
					$permission = self::find_by_role_id_and_actions_to_menus_id(Roles::getRole(), $action_exact_to_menu->id);

					$locked = (is_null($permission) ? true : false);
				}else $locked = true;

				$css.='.action-'.$slug.'{'.($locked === false ? 'display:inline-block;' : 'display:none !important;').'}';
			}
		}
		
		if(!is_null($submenu)){
			foreach ($actions as $id => $slug){
				$action_exact_to_menu=Actions_To_Menus::find_by_submenu_id_and_action_id($submenu->id, $id);
				if ( !is_null($action_exact_to_menu)) {
					$permission = self::find_by_role_id_and_actions_to_menus_id(Roles::getRole(), $action_exact_to_menu->id);

					$locked = (is_null($permission) ? true : false);
				}else $locked = true;
	
				$css.='.action-'.$slug.'{'.($locked === false ? 'display:inline-block;' : 'display:none !important;').'}';
			}
		}
		$css.= '</style>';

		return $css;
	}
	public static function deleteRelations($role_id){
		self::delete_all(array('conditions' => array('role_id = ?', $role_id)));
	}
}
