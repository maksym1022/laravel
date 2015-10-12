<?php
class MenusController extends \BaseController {

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
	    $data["menus"] = DB::table('menus')->get();      
        return View::make("MenuList", $data);
	}
    
    public function create()
	{
        $data["actions"] = DB::table('actions')->lists('slug','id');
        return View::make('NewMenu',$data);
	}
    
    protected function tratarr($string,$html=false){  
        $string=ucfirst($string);        
        $string=addslashes(trim($string));
		return ($html) ? $string : str_replace("\\","",strip_tags($string));
    }
    
    public function register(){
        $validator = Validator::make(Input::all(), Menus::$rules);
        if($validator->passes()){
            $menus = new Menus();
            $menus->titulo = $this->tratarr(Input::get('titulo'));    
            $menus->icon = Input::get('icon');
            $menus->link = Input::get('link');            
            $isset = DB::table('menus')->where('titulo', $menus->titulo)->orWhere('link', $menus->link)->get();            
            if(empty($isset)){
                $menus->save();
                $actions = Input::get('actions');
                if(is_array($actions)){
                    foreach($actions as $key => $action_id){
                        DB::table('actions_to_menus')->insert(
                            array('menu_id' => $menus->id, 'action_id' => $action_id)
                        );    
                    }    
                }
                return Redirect::to('menus')->with('message', 'Menu was created successfully, The menu is now available for use');
            }else {
                return Redirect::to('menus/create')->with('message', 'Oops, there is already a similar menu in the database","Please, try again.')->withErrors($validator)->withInput();
            }
        }
    }
    
    public function edit($id){
        if(isset($id)){
            $data["actions"] = DB::table('actions')->lists('slug','id');
            $action_idss = DB::table('actions_to_menus')->where('menu_id', $id)->select('action_id')->get();
            $action_ids = array();
            foreach($action_idss as $ac_ids){
                foreach($ac_ids as $a_id){                    
                    $action_ids[] .= $a_id;  
                }                                    
            }               
            $data["id_action"] = $action_ids;
            $data["menus"] = DB::table('menus')->where('id',$id)->first();   
            return View::make("EditMenu",$data); 
        }else {
            return Redirect::to('menus')->with('message', 'Oops, Invalid ID!","Please, enter a valid ID!');
        }
    }
    
    protected function getEditValidator()
    {
        return Validator::make(Input::all(), [
            'titulo'=>'required',       
            'icon'=>'required',
            'link'=>'required',
            'actions'=>'required'
        ]);
    }
    
    public function update($id){
        $validator = $this->getEditValidator();
        if($validator->passes()){
            $titulo = $this->tratarr(Input::get('titulo'));    
            $icon = Input::get('icon');
            $link = Input::get('link');   
            $isset = DB::table('menus')->where('titulo', $titulo)->orWhere('link', $link)->get();            
            if(!empty($isset)){
                $action_to_menus =ActionsToMenus::where('menu_id', $id)->lists('id');
                DB::table('permissions')->whereIn('actions_to_menus_id',$action_to_menus)->delete();
                $action_to_menus = ActionsToMenus::where('menu_id', $id)->delete();
                $actions = Input::get('actions');
                if(is_array($actions)){
                    foreach($actions as $key => $action_id){
                        DB::table('actions_to_menus')->insert(
                            array('menu_id' => $id, 'action_id' => $action_id)
                        );    
                    }    
                }
                DB::table('menus')
                ->where('id', $id)
                ->update(array(
                    'titulo' => $titulo,
                    'icon' => $icon, 
                    'link' => $link,                 
                ));
                return Redirect::to('menus')->with('message', 'Successfully managed menus');
            }else{
                return Redirect::to('menus/edit/'.$id)->with('message', '"Oops! Invalid Data!","Please, fill in the fields correctly!"');
            } 
        }else{
            return Redirect::to('menus/edit/'.$id)->with('message', '"Oops! Invalid Data!","Please, fill in the fields correctly!"')->withErrors($validator)->withInput();
        }
    }
    
    public function destroy($id){
        if(isset($id)){
            $action_to_menus =ActionsToMenus::where('menu_id', $id)->lists('id');
            DB::table('permissions')->whereIn('actions_to_menus_id',$action_to_menus)->delete();
            ActionsToMenus::where('menu_id', $id)->delete();
            Menus::where('id', $id)->delete();
            SubMenus::where('menu_id', $id)->delete();
            return Redirect::to('menus')->with('message', 'Successfully managed menus');                    	        	
        }
    }
    
}    