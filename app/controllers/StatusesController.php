<?php
class StatusesController extends \BaseController {

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
	    $data["Statuses"] = DB::table('statuses')->get();      
        return View::make("StatusesList", $data);
	}
    
    public function create()
	{
        $data["roles"] = DB::table('roles')->lists('name','id');
        return View::make('NewStatus',$data);
	}
    
    protected function tratarr($string,$html=false){
        $string=strtolower( preg_replace("[^a-zA-Z0-9-]", "-", $string));
		$string=str_replace(" ", "-", $string);
		$string=str_replace("&nbsp;", "_", $string);
        $string=addslashes(trim($string));
		return ($html) ? $string : str_replace("\\","",strip_tags($string));
    }
    
    public function register(){     
        $validator = Validator::make(Input::all(), Status::$rules);
        if ($validator->passes()) {
            $status = new Status();
            $status->name = Input::get('name');
            $status->slug = $this->tratarr($status->name);            
            $status->save();
            $roles = Input::get('role_id');                                
            if(is_array($roles)){
                foreach($roles as $key => $role_id){
                    DB::table('statuses_roles')->insert(
                        array('role_id' => $role_id, 'status_id' => $status->id)
                    );    
                }    
            }
			return Redirect::to('statuses')->with('message', 'Status was created successfully. The status is now available for use');		
        }else{
            return Redirect::to('statuses/create')->with('message', 'Oops! Invalid Data! Please, fill in the fields correctly!')->withErrors($validator)->withInput();
        }                        
    }
    public function invalidData(){
		$this->show(array("danger","Oops! Invalid Data!","Please, fill in the fields correctly!"));
	}
    
    public function edit($id)
	{	    
	    if(isset($id) && is_numeric($id)){	       
	        $name = DB::table('statuses')->where('id',$id)->first();            
            $rolls = DB::table('statuses as s')
            ->join('statuses_roles as st', 's.id', '=', 'st.status_id')
            ->join('roles as r', 'st.role_id', '=', 'r.id')                   
            ->where('s.id', $id)                    
            ->select('r.id')
            ->get(); 
            $dp_ids = DB::table('statuses as s')
            ->join('dependent_status as dp', 's.id', '=', 'dp.status_primary_id')                            
            ->where('s.id', $id)                    
            ->select('dp.status_dependent_id')
            ->get();           
                
            $role_id = array();            
            foreach($rolls as $role){                
                $role_id[] .= $role->id;
            }
            $dp_idss = array();
            foreach($dp_ids as $dp_id){
                foreach($dp_id as $d_id){                    
                    $dp_idss[] .= $d_id;  
                }                                    
            }     
            $data["roles"] = DB::table('roles')->lists('name','id');    
            $data["roles_id"] = $role_id; 
            $data["depents"] = DB::table('statuses')->lists('name','id');
            $data["depent_id"] =  $dp_idss;                                               
            $data["name"] = $name;                                   
            return View::make("EditStatus",$data); 
	    }else{
	       return Redirect::to('statuses')->with('message', 'Oops, Invalid ID!","Please, enter a valid ID!');
	    }
    }   
    
    protected function getEditValidator()
    {
        return Validator::make(Input::all(), [
        'name'=>'required',                
        'role_id'=>'required',
        'Dependent'=>'required',
        ]);
    }
    
    public function update($id)
	{	    
        $validator = $this->getEditValidator();
        if($validator->passes()){
            $status_roles = StatusesRoles::where('status_id',$id)->delete();
            $depentdent_status = DependentStatus::where('status_primary_id',$id)->delete();
            
            $name = Input::get('name');
            $slug = $this->tratarr($name);            
            
            DB::table('statuses')
                ->where('id', $id)
                ->update(array(
                    'name' => $name,
                    'slug' => $slug,                  
                ));
            $roles = Input::get('role_id');    
            if(is_array($roles)){
                foreach($roles as $key => $role_id){
                    DB::table('statuses_roles')->insert(
                        array('role_id' => $role_id, 'status_id' => $id)
                    );    
                }    
            }
            $dependents = Input::get('Dependent');
            if(is_array($dependents)){
                foreach($dependents as $key => $dependent_id){
                    DB::table('dependent_status')->insert(
                        array('status_dependent_id' => $dependent_id, 'status_primary_id' => $id)
                    );    
                }    
            }
            return Redirect::to('statuses')->with('message', 'Status was updated successfully, All channels that are configured to receive this status updates');
        }else {
            return Redirect::to('statuses/edit/'.$id)->with('message', 'Oops! Invalid Data! Please, fill in the fields correctly!')->withErrors($validator)->withInput();
        }
    }
}    