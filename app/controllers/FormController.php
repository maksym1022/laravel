<?php
class FormController extends \BaseController {

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
	public function show($id)
	{	   	                  
        //Captcha			
		$data["publickey"] = "6LfKUwwTAAAAAJ4FV3r0x8SkUT9e4ZfbTz-9TlDm";
		$data["error"] = null;
		//Data
		$data["hub_id"]=((!isset($id)) ? 1 : $id);
		$data["user_id"]=('' ? '' : '');
        Session::put('hub_id', $data["hub_id"]);
        Session::put('referral', $data["user_id"]);				     
        return View::make("Form", $data);
	}
    
    public function show_user($id)
	{	   	          
        //Captcha			
		$data["publickey"] = "6LfKUwwTAAAAAJ4FV3r0x8SkUT9e4ZfbTz-9TlDm";
		$data["error"] = null;
		//Data		
        $data["hub_id"]=('' ? 1 : '');
		$data["user_id"]=((!isset($id)) ? '' : $id);
        Session::put('hub_id', $data["hub_id"]);
        Session::put('referral', $data["user_id"]);				     
        return View::make("Form", $data);
	}
    
    protected function tratarr($string,$html=false){  
        $string=ucfirst($string);        
        $string=addslashes(trim($string));
		return ($html) ? $string : str_replace("\\","",strip_tags($string));
    }
    
    public function send(){
			$data["hub_id"]=((isset($_SESSION["hub_id"]) && !empty($_SESSION["hub_id"])) ? $_SESSION["hub_id"] : 0);
			$data["user_id"]=((isset($_SESSION["referral"]) && !empty($_SESSION["referral"])) ? $_SESSION["referral"] : 0);
            $hub_id = Session::get('hub_id');
            $user_id = Session::get('referral');
            $channel_name = Input::get('channel_name');	
            $first_name = Input::get('first_name');	
            $last_name = Input::get('last_name');
            $channel_email = Input::get('channel_email');
            $confirm_email = Input::get('confirm_email');			
            
			if(empty($hub_id)){
                return Redirect::to('form/hub//ref/'.$user_id);  
			}
            
			if((isset($hub_id) && isset($channel_name) && isset($first_name) && isset($last_name) && isset($channel_email) && isset($confirm_email)) && (!empty($hub_id) && !empty($channel_name) && !empty($first_name) && !empty($last_name) && !empty($channel_email) && !empty($confirm_email))){
				if(is_numeric($hub_id)){
					if(filter_var($channel_email,FILTER_VALIDATE_EMAIL)){
						//Tratamento
                        
                        $h_id = DB::table('hubs')->where('id',$hub_id)->first();  
                        $user_i = DB::table('users')->where('id',$user_id)->first();                         
						$hub_id=((count($h_id->id) == 0) ? 1 : $this->tratarr($hub_id));
						$user_id=((isset($user_id) && is_numeric($user_id) && $user_i) ? $this->tratarr($user_id) : '');
						$channel_name=$this->tratarr($channel_name);
						$first_name=$this->tratarr($first_name);
						$last_name=$this->tratarr($last_name);
						$channel_email=BaseController::tratar($channel_email,"sl");
						$confirm_email=BaseController::tratar($confirm_email,"sl");
                        $paypals = Input::get('paypal');
                        $agree_views = Input::get('agree_views');
                        $agree_copyright = Input::get('agree_copyright');
                        $agree_quota = Input::get('agree_quota');
						$paypal=((isset($paypals) && !empty($paypals)) ? BaseController::tratar($paypals,"sl") : '');
						$agree_views=((isset($agree_views) && !empty($agree_views)) ? 1 : 0);
						$agree_copyright=((isset($agree_copyright) && !empty($agree_copyright)) ? 1 : 0);
						$agree_quota=((isset($agree_quota) && !empty($agree_quota)) ? 1 : 0);                        						
                        
						if($channel_email == $confirm_email){	
						    
							$data["publickey"] = "6LfKUwwTAAAAAJ4FV3r0x8SkUT9e4ZfbTz-9TlDm";
							$privatekey = "6LfKUwwTAAAAANVHPWqF7iT1n8QtgyZR5gDgMTxE";
							$resp = null;
							$data["error"] = null;
							$resp = Recaptchalib::recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
                            $channels_email = DB::table('channels')->where('email',$channel_email)->orWhere('name',$channel_name)->first();
                               
					        if ($resp->is_valid) {
					           
					            if(count($channels_email) == 0){					            	
					            	$percentage=((empty($h_id->percentage_form)) ? 60 : $h_id->percentage_form);
					            	$contract_url_form=((empty($hub->contract_url_form)) ? $this->success() : $hub->contract_url_form);									
                                    DB::table('channels')->insert(
                                        array("hub_id"=>$hub_id,"name"=>$channel_name,"full_name"=>$first_name." ".$last_name,"email"=>$channel_email,"paypal"=>$paypal,"percentage"=>$percentage,"cms"=>1,"network"=>$channel_name,"status"=>1,"agree_views"=>$agree_views,"agree_copyright"=>$agree_copyright,"agree_quota"=>$agree_quota)
                                    );   
									if(!empty($user_id))
										//Channels::find_by_email_and_name($channel_email,$channel_name)->update_attributes(array("user_id"=>$user_id));
                                        DB::table('channels')
                                        ->where('email', $channel_email)
                                        ->orWhere('name',$channel_name)
                                        ->update(array(
                                            'user_id' => $user_id,                                                            
                                        ));									
                                    return Redirect::to($contract_url_form);
								}else $data["message"]=array("danger","Oops! Channel already submitted!","This channel is entered into our database, try again!");   
					        }else{
					            $data["error"] = $resp->error;
					            $data["message"]=array("danger","Oops! Invalid verification code!","Enter a valid verification code, try again!");
					        }
						}else $data["message"]=array("danger","Oops! Email do not match!","The email does not match confirmation, try again!");
					}else $data["message"]=array("danger","Oops! Invalid Email!","Enter a valid Email, try again!");
				}else $data["message"]=array("danger","Oops! Invalid Hub ID!","Enter a valid ID, try again!");
			}else $data["message"]=array("danger","Oops! Fill out all fields!","There are required fields that were not filled, try again!");
			
            return View::make("Form", $data);
		}
    public function success(){
        $hub_id = Session::get('hub_id');
        $h_id = DB::table('hubs')->where('id',$hub_id)->first();  
        $hub_name=$h_id->name;
		$data["message"]=array("success","Congratulations! Channel submitted successfully!","Thank you for applying the network ".$hub_name.". Soon you will receive a confirmation email if we accept your application channel.");
        $data["publickey"] = "6LfKUwwTAAAAAJ4FV3r0x8SkUT9e4ZfbTz-9TlDm";
    	$data["error"] = null;   				     
        return View::make("Form", $data);    
    }    
    
}    