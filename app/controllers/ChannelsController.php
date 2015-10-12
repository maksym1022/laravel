<?php



class ChannelsController extends \BaseController {



	/**

	 * Display a listing of the resource.

	 *

	 * @return Response

	 */

	public function index()

	{

	   $channels = Channel::getChannels();

        $data = [];

        $data['statuses'] = DB::table('statuses') ->get();

		$data["channels"]=$channels;

        $data["statuses_roles"] = DB::table('statuses_roles as s')

                    ->join('roles as r', 's.role_id', '=', 'r.id')

                    ->get();

		$data["channels"]=$channels;

        return View::make("ChannelsList",$data);

        

	}





	/**

	 * Show the form for creating a new resource.

	 *

	 * @return Response

	 */

	public function create()

	{

		if(Auth::user()->role =='administrator'){

            $data["statuses"] = DB::table('statuses')->lists('name','id');

            $data["hubs"] = DB::table('hubs')->lists('name', 'id');

            $percentage[0]='Select...';

    		for($i=50;$i<=100;$i=$i+1){

    		  $percentage[$i]=$i;

    		}	

            $data["percentage"] = $percentage;

			return View::make("NewChannel",$data);

		}else return Redirect::to('channels');

        

	}



    public function register(){

        //Proccess

		if(Auth::user()->role =='administrator'){

			if((isset($_REQUEST["hub_id"]) && isset($_REQUEST["channel_name"]) && isset($_REQUEST["channel_email"]) && isset($_REQUEST["full_name"]) && isset($_REQUEST["status"]) && isset($_REQUEST["percentage"])) && (!empty($_REQUEST["hub_id"]) && !empty($_REQUEST["channel_name"]) && !empty($_REQUEST["channel_email"]) && !empty($_REQUEST["full_name"]) && !empty($_REQUEST["status"]) && !empty($_REQUEST["percentage"]))){

				if((is_numeric($_REQUEST["hub_id"]) && is_numeric($_REQUEST["status"]) && is_numeric($_REQUEST["percentage"])) && (strlen($_REQUEST["percentage"]) <= 3 && ($_REQUEST["status"] > 0 ) && $_REQUEST["percentage"] >= 50 && $_REQUEST["percentage"] <= 100)){

					//Tratamento

					$hub_id=$_REQUEST["hub_id"];

					$channel_name=$this->tratar($_REQUEST["channel_name"],"sanitize");

					$channel_email=$this->tratar($_REQUEST["channel_email"],"sl");

					$full_name=$this->tratar($_REQUEST["full_name"]);

					$paypal=((isset($_REQUEST["paypal"]) && !empty($_REQUEST["paypal"])) ? $this->tratar($_REQUEST["paypal"],"sl") : '');

					$status=$_REQUEST["status"];

					$percentage=$_REQUEST["percentage"];

					//Finish

					if(Channel::where('email', '=', $channel_name)->count() == 0){

						$channel =Channel::create(array(

                            'hub_id'=>$hub_id,

                            "user_id"=>Auth::user()->id,

                            "name"=>$channel_name,

                            "email"=>$channel_email,

                            "full_name"=>$full_name,

                            "paypal"=>$paypal,

                            "percentage"=>$percentage,

                            "network"=>$channel_name,

                            "status"=>$status

                        ));

                        

					//	$channel=Channel::where('email', '=', $channel_name)->first();

						DB::table('status_logs')->insert(array(

                            "channel_id"=>$channel->id,

                            "status_id"=>$status,

                            "user_id"=>Auth::user()->id,

                            "date"=>date("Y-m-d H:i:s")

                        ));

						$data["message"]=array("success","Congratulations! Channel created successfully!","All channel data were saved successfully");

					

                    }else $data["message"]=array("danger","Oops! Channel already submitted!","This channel is entered into our database, try again!");

				}else $data["message"]=array("danger","Oops! Invalid Data!","Please, fill in the fields correctly!");

			}else $data["message"]=array("danger","Oops! Fill out all fields!","There are required fields that were not filled, try again!");

		    return Redirect::to('channels')->with($data);

        }else return Redirect::to('channels');

	}       

	



	/**

	 * Display the specified resource.

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function show($id)

	{

		$channels = Channel::getChannels($id);

        $data = [];

        $data['statuses'] = DB::table('statuses') ->get();

		$data["channels"]=$channels;

        $data["statuses_roles"] = DB::table('statuses_roles as s')

                    ->join('roles as r', 's.role_id', '=', 'r.id')

                    ->get();

        return View::make("ChannelsList",$data);

	}





	/**

	 * Show the form for editing the specified resource.

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function edit($id)

	{  

		if(Auth::user()->role =='administrator'|| Manager::validateAccess($id) ){

		    $data["channel"]=Channel::getChannel($id);

            $data["statuses"] = DB::table('statuses')->lists('name','id');

            $data["hubs"] = DB::table('hubs')->lists('name', 'id');

            for($i=50;$i<=100;$i=$i+1){

    		  $percentage[$i]=$i;

    		}	

            $data["capercentage"] = $percentage;

            return View::make("EditChannel",$data);

		}else return Redirect::to('channels');

	}





	/**

	 * Update the specified resource in storage.

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function update($id)

	{

		if(Manager::validateAccess($id)){

			//Proccess

            

			if(isset($_REQUEST["percentage"]) && !empty($_REQUEST["percentage"])){

				if(is_numeric($_REQUEST["percentage"]) && (strlen($_REQUEST["percentage"]) <= 3 && $_REQUEST["percentage"] >= 50 && $_REQUEST["percentage"] <= 90)){

					//Tratamento

					$filters = array

					(

					  	'full_name'=>FILTER_SANITIZE_STRING,

					  	'email'=>FILTER_SANITIZE_EMAIL,

					  	'percentage'=>FILTER_SANITIZE_NUMBER_INT,

					  	'dateofuntying'=>FILTER_SANITIZE_STRING

					);

					$super_global = filter_input_array(INPUT_POST, $filters);

					//Objeto

					$channel=Channel::getChannel($id);



					define ("CONTRACTS",__DIR__."/../../public/uploads/contracts");

					$contract_file_name=$channel->contract;

					if(is_uploaded_file($_FILES['contract']['tmp_name'])){

						if($_FILES['contract']['type'] === "application/pdf"){

							$contract_file_name=md5(rand(0,rand(0,99999)).sha1(date("Y"))).".pdf";

							$contract_path=CONTRACTS."/".$contract_file_name;

							$result = move_uploaded_file($_FILES['contract']['tmp_name'], $contract_path);

							if($result){

								@unlink(CONTRACTS.'/'.$channel->contract);

							}else $data["message"]=array("danger","Oops! Invalid Format!","Please, the contract must be uploaded in PDF format!");

						}else $data["message"]=array("danger","Oops! Invalid Format!","There was a problem uploading the contract. Check that the file is valid and try again!");

					}

					if(!isset($data["message"])){

						$super_global['contract']=$contract_file_name;

						//Finish

                        Channel::where('id', '=', $id)->update(array(

                            'full_name' => $_REQUEST["full_name"],

                            'email' => $_REQUEST["email"],

                            'percentage' => $_REQUEST["percentage"],

                            'dateofuntying' => $_REQUEST["dateofuntying"],

                            'contract' => $contract_file_name,

                        ));

                        return Redirect::to('channels')->with($data);

					}

				}else $data["message"]=array("danger","Oops! Invalid Data!","Please, fill in the fields correctly!");

			}else {

            $data["message"]=array("danger","Oops! Fill out all fields!","There are required fields that were not filled, try again!");

			}

            //Render

            return Redirect::to('channels/edit/'.$id)->with($data);

			}

            elseif(Auth::user()->role=='administrator'){

				//Proccess

				if((isset($_REQUEST["hub_id"]) &&isset($_REQUEST["full_name"]) &&isset($_REQUEST["paypal"]) &&isset($_REQUEST["partner_id"]) &&isset($_REQUEST["cms"]) &&   isset($_REQUEST["percentage"])) && (!empty($_REQUEST["hub_id"]) &&!empty($_REQUEST["full_name"]) && !empty($_REQUEST["cms"]) && !empty($_REQUEST["percentage"]))){

                    if(is_numeric($_REQUEST["hub_id"]) && is_numeric($_REQUEST["cms"]) && is_numeric($_REQUEST["percentage"]) && strlen($_REQUEST["percentage"]) <= 3 && $_REQUEST["percentage"] >= 50 && $_REQUEST["percentage"] <= 100){

						//Tratamento

						$hub_id=$this->tratar($_REQUEST["hub_id"]);

						$full_name=$this->tratar($_REQUEST["full_name"]);

						$paypal=((isset($_REQUEST["paypal"]) && !empty($_REQUEST["paypal"])) ? $this->tratar($_REQUEST["paypal"],"sl") : '');

						$partner_id=$this->tratar($_REQUEST["partner_id"]);

						$banner=$this->tratar($_REQUEST["banner"]);

						$cms=$_REQUEST["cms"];

						$percentage=$_REQUEST["percentage"];

						$dateofuntying=$_REQUEST["dateofuntying"];

                        $bankaccount=$_REQUEST["bankaccount"];

                        $chid=$_REQUEST["chid"];

						//Objeto

						$channel=Channel::getChannel($id);



						define ("CONTRACTS",__DIR__."/../../public/uploads/contracts");

						$contract_file_name=$channel->contract;

						if(is_uploaded_file($_FILES['contract']['tmp_name'])){

							if($_FILES['contract']['type'] === "application/pdf"){

								$contract_file_name=md5(rand(0,rand(0,99999)).sha1(date("Y"))).".pdf";

								$contract_path=CONTRACTS."/".$contract_file_name;

								$result = move_uploaded_file($_FILES['contract']['tmp_name'], $contract_path);

								if($result){

									@unlink(CONTRACTS.'/'.$channel->contract);

								}else $data["message"]=array("danger","Oops! Invalid Format!","Please, the contract must be uploaded in PDF format!");

							}else $data["message"]=array("danger","Oops! Invalid Format!","There was a problem uploading the contract. Check that the file is valid and try again!");

						}

						if(!isset($data["message"])){

							//Finish

							$channel->update(array(

                                "hub_id"=>$hub_id,

                                "partner_id"=>$partner_id,

                                "full_name"=>$full_name,

                                "paypal"=>$paypal,

                                "banner"=>$banner,

                                "cms"=>$cms,

                                "percentage"=>$percentage,

                                "contract"=>$contract_file_name,

                                "dateofuntying"=>$dateofuntying,

                                "bankaccount" => $bankaccount,

                                "chid" => $chid

                            ));

                            $data["message"]=array("success","Congratulations! Channel created successfully!","All channel data were saved successfully");

						      return Redirect::to('channels')->with($data);

						}

					}else $data["message"]=array("danger","Oops! Invalid Data!","Please, fill in the fields correctly!");

				}else $data["message"]=array("danger","Oops! Fill out all fields!","There are required fields that were not filled, try again!");

				//Render

				return Redirect::to('channels/edit/'.$id)->with($data);

			}else return Redirect::to('channels')->with($data);

	}

	/**

	 * Remove the specified resource from storage.

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function destroy($id)

	{

		//

	}

    public function generatestatus(){

    	$html='';

		if(!empty($html)) echo '<option value="">Error! #01</option>';

        else{

            $channel_id=$_REQUEST["channel_id"];

    		$status_id=Channel::find($channel_id)->status;

    		$statuses=DependentStatus::getLinks($status_id);

    		

    		foreach ($statuses as $link) {

    			$status=Status::find($link->status_primary_id);

    			$role_id=Auth::user()->role_id;

    				$html.='<option value="'.$status->id.'">'.$status->name.'</option>';

    		}

    		echo $html;

        }

	}

    public function send($id){

		$channel_id=$id;

		$subject=((isset($_REQUEST["subject"])) ? $_REQUEST["subject"] : null);

		$message=((isset($_REQUEST["message"])) ? $_REQUEST["message"] : null);

        

		if(!empty($channel_id) && !empty($subject) && !empty($message)){

			$channel=Channel::find($channel_id); 

            $message=str_replace("\\", "", $message);

            if(! in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) )

            {

                 

                Mail::send(array($subject,'text'), array('key' => 'value'), function($message)

                {

                    $message->to($channel->email, $channel->name)->subject($subject);

                });

            }

			echo 1;

		}

	}

    



}

