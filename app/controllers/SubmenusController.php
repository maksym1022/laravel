<?php
class SubMenusController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{	    
	}
    
    public function create($id){
        $data["menus"] = DB::table('menus')->lists('titulo','id');
        $data["menu_id"] = $id;
        $data["actions"] = DB::table('actions')->lists('slug','id');
		return View::make('NewSubMenu',$data);
    }
    
    protected function tratarr($string,$html=false){  
        $string=ucfirst($string);        
        $string=addslashes(trim($string));
		return ($html) ? $string : str_replace("\\","",strip_tags($string));
    }
    
    public function register($id){        
        $validator = Validator::make(Input::all(), SubMenus::$rules);
        if($validator->passes()){
            $submenus = new SubMenus();
            $submenus->titulo = $this->tratarr(Input::get('titulo'));            
            $submenus->link = Input::get('link');
            $submenus->menu_id = Input::get('menu_id');
            $isset = DB::table('submenus')->where('titulo', $menus->titulo)->orWhere('link', $menus->link)->get();            
            if(empty($isset)){
                $submenus->save();
                $actions = Input::get('actions');
                if(is_array($actions)){
                    foreach($actions as $key => $action_id){
                        DB::table('actions_to_menus')->insert(
                            array('menu_id' => $submenus->menu_id,"submenu_id"=>$submenus->id,"action_id"=>$action_id)
                        );    
                    }    
                }
                return Redirect::to('menus')->with('message', 'Menu was created successfully, The menu is now available for use');
            }else {
                return Redirect::to('submenus/create/'.$id)->with('message', 'Oops, there is already a similar menu in the database","Please, try again.');
            }
        }else{
            return Redirect::to('submenus/create/'.$id)->with('message', 'Oops! Invalid Data!","Please, fill in the fields correctly!')->withErrors($validator)->withInput();
        }
    }
    
    public function edit($id){                
        if(isset($id) && is_numeric($id)){                                    
            $data["menu_lists"] = DB::table('menus')->lists('titulo','id');
            $id_menus = DB::table('submenus')->where('id', $id)->select('menu_id')->get();                              
            foreach($id_menus as $id_menu){                
                $menu_id =  $id_menu->menu_id;                                 
            }                         
            $data["menu_id"] = $menu_id;
            $data["menus"] = DB::table('submenus')->where('id', $id)->first();  
            $data["actions"] = DB::table('actions')->lists('slug','id');                
            $action_idss = DB::table('actions_to_menus')->where('submenu_id', $id)->select('action_id')->get();
            $action_ids = array();
            foreach($action_idss as $ac_ids){
                foreach($ac_ids as $a_id){                    
                    $action_ids[] .= $a_id;  
                }                                    
            }
            $data["id_action"] = $action_ids; 
            return View::make("EditSubMenu",$data);       
        }else{
            return Redirect::to('submenus')->with('message', 'Oops, Invalid ID!","Please, enter a valid ID!');
        }
    }
    
    protected function getEditValidator()
    {
        return Validator::make(Input::all(), [
            'menu_id'=>'required',       
            'titulo'=>'required',
            'link'=>'required',
            'actions'=>'required'
        ]);
    }
    
    public function update($id){        
        $validator = $this->getEditValidator();
        if($validator->passes()){
            $titulo = $this->tratarr(Input::get('titulo'));                
            $link = Input::get('link');   
            $menu_id = Input::get('menu_id');
            $isset = DB::table('submenus')->where('titulo', $titulo)->orWhere('link', $link)->get();
            $submenus = SubMenus::find($id);                                               
            if(!empty($isset) && $submenus->id == $id){                   
                $action_to_menus =ActionsToMenus::where('submenu_id', $id)->lists('id');
                              
                DB::table('permissions')->whereIn('actions_to_menus_id',$action_to_menus)->delete();
                $action_to_menus = ActionsToMenus::where('submenu_id', $id)->delete();                                           
                $actions = Input::get('actions');
                if(is_array($actions)){
                    foreach($actions as $key => $action_id){
                        DB::table('actions_to_menus')->insert(
                            array('menu_id' => $menu_id,"submenu_id"=>$id,"action_id"=>$action_id)
                        );    
                    }    
                }
                DB::table('submenus')
                ->where('id', $id)
                ->update(array(
                    'titulo' => $titulo,
                    'menu_id' => $menu_id, 
                    'link' => $link,                 
                ));
                return Redirect::to('menus')->with('message', 'Successfully managed menus');
            }else {
                return Redirect::to('submenus/edit/'.$id)->with('message', '"Oops! Invalid Data!","Please, fill in the fields correctly!"');
            }
        }else {
            return Redirect::to('submenus/edit/'.$id)->with('message', '"Oops! Invalid Data!","Please, fill in the fields correctly!"')->withErrors($validator)->withInput();
        }
    }
    
    public function destroy($id){
        if(isset($id)){
            ActionsToMenus::where('submenu_id', $id)->delete();
            Menus::where('id', $id)->delete();
            SubMenus::where('id', $id)->delete();
            return Redirect::to('menus')->with('message', 'Successfully managed menus');                    	        	
        }        
    }
    
}    