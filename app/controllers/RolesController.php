<?php

class RolesController extends \BaseController {
    public function __construct(){

        parent::__construct();
        if(Auth::user()->role!=='administrator')
        return Redirect::to('')->send();

    }
    
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
	    $data["roles"] = DB::table('roles')->get();              

        return View::make("RolesList", $data);  

	}

    

    public function create()

	{

	    $data["roles"] = DB::table('roles')->lists('role','id');

        $data["relations"] = DB::table('actions_to_menus')->orderBy('id', 'ASC')->get(); 

        $data["general"]   = array(

                            		"0" => "No",

                            		"1"=>"Yes"

                            	  ); 

        return View::make('NewRole',$data);

	}

    

    protected function tratarr($string,$add ="",$html=false){         

        $string=ucfirst($string);        

        $string=addslashes(trim($string));

		return ($html) ? $string : str_replace("\\","",strip_tags($string));

    }

    

    protected function trata($string,$html=false){

        $string=strtolower( preg_replace("[^a-zA-Z0-9-]", "-", $string));

		$string=str_replace(" ", "-", $string);

		$string=str_replace("&nbsp;", "_", $string);

        $string=addslashes(trim($string));

		return ($html) ? $string : str_replace("\\","",strip_tags($string));

    }

    

    public function register(){        

		$name=$this->tratarr(Input::get('name'));

		$slug=$this->trata($name);

        $isset = DB::table('roles')->where('name', $name)->get();                   

		if(!empty($name)){		  

			if(empty($isset)){			     

				$roles = new Role();

				$roles->role=$slug;

				$roles->name=$name;

				$roles->general = intval(substr(Input::get('general'), 0, 1));

				$roles->save();

				$roles = Input::get('roles');

                if(is_array($roles)){

                    foreach($rolesns as $key => $role_id){

                        DB::table('roles_to_users')->insert(

                            array('user_role_id' => $roles->id, 'role_id' => $role_id)

                        );    

                    }    

                }

				$permissions = Input::get('permissions');                

				if(is_array($permissions)){

                    foreach($permissions as $key => $permission_id){                        

                        DB::table('permissions')->insert(

                            array('role_id' => $roles->id, 'actions_to_menus_id' => $permission_id)

                        );    

                    }    

                }

				return Redirect::to('roles')->with('message', 'Role was created successfully, The role is now available for use');				

			}else {

			    return Redirect::to('roles')->with('message', 'Oops, there is already a similar role in the database, Please, try again.');   

			}

		}

    }

    

    public function edit($id){

		if(isset($id) && is_numeric($id)){ 		    

			$i=0;

			$roles = array();

            $selected = array();

            $permitted_roles = DB::table('roles_to_users')->where("user_role_id", $id)->get();                               					

			if(!is_null($permitted_roles)){

				foreach($permitted_roles as $allowed_role){						  

					$i++;

					$roles[] .= Role::find($allowed_role->role_id)->id;

                                                               

				}				             

			}            

            $data["selected"] = $roles;            

            $data["roles"] = DB::table('roles')->lists('role','id');

            $data["relations"] = DB::table('actions_to_menus')->orderBy('id', 'ASC')->get(); 

            $data["permissions"] = Permissions::getSelectedByUserRoleId($id);  

            $data["role"] = DB::table('roles')->where('id',$id)->first();            

			return View::make("EditRole",$data); 			

		}

	}

    

    public function update($id){

        if(isset($id) && is_numeric($id)){	

            $name=$this->tratarr(Input::get('name'));

    		$slug=$this->trata($name);            		

			if(!empty($name)){

			    $roles_to_users = RolesToUsers::where('user_role_id', $id)->delete();

                $permissions = Permissions::where('role_id', $id)->delete();				

				$roles = Input::get('roles');

                if(is_array($roles)){

                    foreach($roles as $key => $role_id){

                        DB::table('roles_to_users')->insert(

                            array('user_role_id' => $id, 'role_id' => $role_id)

                        );    

                    }    

                }				

				$permissions = Input::get('permissions'); 

                if(is_array($permissions)){

                    foreach($permissions as $key => $permission_id){                        

                        DB::table('permissions')->insert(

                            array('role_id' => $id, 'actions_to_menus_id' => $permission_id)

                        );    

                    }    

                }   

				$general = intval(substr(Input::get('general'), 0, 1));

				DB::table('roles')

                ->where('id', $id)

                ->update(array(

                    'name' => $name,

                    'role' => $slug, 

                    'general' => $general,                 

                ));								

                return Redirect::to('roles')->with('message', 'Roles was updated successfully');

			}

		}

    }

    

    public function destroy($id){        

        $permissions = Permissions::where('role_id', $id)->delete();	

		$roles_to_users = RolesToUsers::where('user_role_id', $id)->delete();

		$roles = roles::where('id', $id)->delete();		

        return Redirect::to('roles')->with('message', 'Roles was deleted successfully');  

    }

    

}    