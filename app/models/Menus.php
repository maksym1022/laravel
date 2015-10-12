<?php
class Menus extends Eloquent{
		        
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menus';
    protected $guarded = array('id');
    public $timestamps = false;
    
	public static function getAll(){
		$menus=self::all();
		$menusFiltered=array();
		foreach($menus as $menu)
			$menusFiltered[$menu->id]=$menu->titulo;
		return $menusFiltered;
	}
	public static function getMenuStructure(){
		$menus=self::all();
		$structure=array();
		foreach($menus as $menu){
			if(self::checkPermission($menu->id))
				$structure[$menu->titulo.'/'.$menu->icon]=$menu->link;
			else continue;
			$submenus=SubMenus::all(array("conditions"=>array("menu_id=?",$menu->id)));
			if(!empty($submenus)){
				$structure[$menu->titulo.'/'.$menu->icon]=array();
				foreach($submenus as $submenu){
					if(Menus::checkPermission($submenu->id,'submenu_id'))
						$structure[$menu->titulo.'/'.$menu->icon][$submenu->titulo]=$submenu->link;
				}
			}
		}
		return $structure;
	}
	public static function checkPermission($menu_id,$field='menu_id'){
		$actions=ActionsToMenus::getSelectOptions($menu_id,$field);
		return ((!empty($actions) && Permissions::checkPermission($actions)) ? true : false);
	}
    
    public static $rules = array(
        'titulo'=>'required',       
        'icon'=>'required',
        'link'=>'required',
        'actions'=>'required'
    );
    
    public static function get_permissions($submenu_id){
        $pers = DB::table('menus as m')
        ->join('submenus as sb', 'm.id', '=', 'sb.menu_id')                              
        ->where('sb.id', $submenu_id)                    
        ->select('m.titulo')
        ->get(); 
        $permission = '';
        foreach($pers as $per => $value){
            $permission = $value->titulo;
        }        
        
        return $permission;
    }
    
}