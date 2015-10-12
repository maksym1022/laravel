<?php
class homepartnerController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->show();
	}
    
    /**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show()
	{  
	    $users = DB::table('users')->get();
        $data = [];
		$data["users"]=$users;
        //
        $h_id =  DB::table('managers')->where('user_id',Auth::user()->id)->get();
        //$data["hub_id"] 
        //$hub = $h_id[0]->hub_id;
        if(!empty($h_id[0]->hub_id)){
            $data["hub_id"] = $h_id[0]->hub_id;
        }else{
            $data["hub_id"] = 0;
        }                  
        return View::make("Homepartner",$data);
	}
    
}    