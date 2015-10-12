<?php



class HubsController extends \BaseController {

    private $emails_file_path='public/files/excel/emails.csv';

    public function __construct(){

		parent::__construct();

		fopen($this->emails_file_path, "w+");

	}

	/**

	 * Display Select the hubs to edit or delete.

	 *

	 * @return Response

	 */

	public function index()

	{

		$itens=Hub::getAll();

		$data["hubs"]=$itens;

		//Render

        return  View::make("HubsList",$data);

	}





	/**

	 * Show the form for creating a new resource.

	 *

	 * @return Response

	 */

	public function create()

	{

		if(Auth::user()->role=='administrator'){

            $data["channel"] = Channel::where('user_id', Auth::user()->id)->firstOrFail();

//            $data['managers'] = DB::table('managers as m')->join('hubs as h','m.hub_id','=','h.id')

 //           ->where('m.user_id',Auth::user()->id)->lists('m.hub_id');

			$data["percentage"]=Configs::getPercentage($data["channel"]->percentage);

			return View::make("NewHub",$data);

		}else {

            $data['message']=(array("danger","Oops! Permission denied!","You do not have permission to perform this action!"));

    		return Redirect::to('hubs')->with($data);

        }

	}





	/**

    * register a new hub.

    *

    * @return Response

    */

	public function register(){

			if(Auth::user()->role=='administrator'){

				//Proccess

				if((isset($_REQUEST["name"]) && isset($_REQUEST["email"]) && isset($_REQUEST["website"]) && isset($_REQUEST["paypal"]) && isset($_REQUEST["percentage"])) && (!empty($_REQUEST["name"]) && !empty($_REQUEST["email"]) && !empty($_REQUEST["website"]) && !empty($_REQUEST["percentage"]))){

					if(is_numeric($_REQUEST["percentage"]) && strlen($_REQUEST["percentage"]) <= 3){

						//Tratamento

						$name=$this->tratar($_REQUEST["name"]);

						$email=$this->tratar($_REQUEST["email"],"sl");

						$website=$this->tratar($_REQUEST["website"]);

						$paypal=((isset($_REQUEST["paypal"]) && !empty($_REQUEST["paypal"])) ? $this->tratar($_REQUEST["paypal"],"sl") : '');

						$percentage=$_REQUEST["percentage"];

						//$manager=$_REQUEST["manager"];

						//Finish

						if(Hub::where('email',$email)->where('name',$name)->count() == 0){

							Hub::create(array(

                                "name"=>$name,

                                "email"=>$email,

                                "website"=>$website,

                                "paypal"=>$paypal,

                                "percentage"=>$percentage

                            ));

							$data["message"]=array("success","Congratulations! Hub created successfully!","All hub data were saved successfully");

							if(isset($_REQUEST["manager"]) && !empty($_REQUEST["manager"])){

								$manager=$_REQUEST["manager"];

								if(count(User::find($manager)) == 1){

									$Getid=Hub::where('email',$email)->where('name',$name)->first()->id;

									Manager::create(array("hub_id"=>$Getid,"user_id"=>$manager));

								}else $data["message"]=array("danger","Oops! Manager does not exist!","The referenced manager was not found in the database, make sure that the ID reported correctly.");

							}

						}else $data["message"]=array("danger","Oops! Hub already exists!","This hub is entered into our database, try again!");

					}else $data["message"]=array("danger","Oops! Invalid Data!","Please, fill in the fields correctly!");

				}else $data["message"]=array("danger","Oops! Fill out all fields!","There are required fields that were not filled, try again!");

				return Redirect::to('hubs')->with($data);

			}else {

		        $data['message']=(array("danger","Oops! Permission denied!","You do not have permission to perform this action!"));

    			return Redirect::to('hubs')->with($data);

			}

		}





	/**

	 * Show the form for editing the hub.

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function edit($id)

	{

		if((Manager::validateManager(Auth::user()->id,$id)) || (Auth::user()->role=='administrator')){

			$data=array(

				'id'=>$id,

				'hub'=>Hub::find($id),

				'percentage'=>Configs::getPercentage(Hub::find($id)->first()->percentage),

				'percentage_form'=>Configs::getPercentage(),

				'selected'=>Manager::getManagersByHub($id),

				'managers'=>User::getManagers()

			);

			return View::make('EditHub',$data);

		}else {

	        $data['message']=(array("danger","Oops! Permission denied!","You do not have permission to perform this action!"));

			return Redirect::to('hubs')->with($data);

		}

	}





	/**

	 * Update request form edit hub 

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function update($id)

	{

		

			if(isset($id) && is_numeric($id)){

				if(Auth::user()->role=='administrator'){

					//Proccess

					if((isset($_REQUEST["managers"]) && isset($_REQUEST["name"]) && isset($_REQUEST["email"]) && isset($_REQUEST["website"]) && isset($_REQUEST["paypal"]) && isset($_REQUEST["percentage"])) && (!empty($_REQUEST["managers"]) && !empty($_REQUEST["name"]) && !empty($_REQUEST["email"]) && !empty($_REQUEST["website"]) && !empty($_REQUEST["percentage"]))){

						if(is_array($_REQUEST["managers"]) && is_numeric($_REQUEST["percentage"]) && strlen($_REQUEST["percentage"]) <= 3){

							//Tratamento

							$name=$this->tratar($_REQUEST["name"]);

							$email=$this->tratar($_REQUEST["email"],"sl");

							$website=$this->tratar($_REQUEST["website"]);

							$contract_url_form=$this->tratar($_REQUEST["contract_url_form"]);

							$paypal=((isset($_REQUEST["paypal"]) && !empty($_REQUEST["paypal"])) ? $this->tratar($_REQUEST["paypal"],"sl") : '');

							$percentage=$_REQUEST["percentage"];

							$percentage_form=$_REQUEST["percentage_form"];

							$managers=$_REQUEST["managers"];

							//Managers

							Manager::deleteManagers($id);

							foreach($managers as $key => $user_id){

								Manager::create(array("user_id"=>$user_id,"hub_id"=>$id));

							}

							//Objeto

							$hub=Hub::find($id);   

							define ("LOGOS",base_path().'/public/uploads/logos');

							$logo_name=$hub->logo;

							if(is_uploaded_file($_FILES['logo']['tmp_name'])){

							    $filename = $_FILES['logo']['name'];

                                $extensao = pathinfo($filename, PATHINFO_EXTENSION);

								$extensoes = array('gif', 'jpeg', 'jpg', 'png');

								if(in_array($extensao, $extensoes)){

									$logo_name=md5(rand(0,rand(0,99999)).sha1(date("Y"))).".png";

									$logo_path=LOGOS."/".$logo_name;

									$result = move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path);

									if($result){

										@unlink(LOGOS.'/'.$hub->logo);

									}else $data["message"]=array("danger","Oops! Invalid Format!","Please, the logo must be uploaded in PNG/JPG/GIF format!");

								}else $data["message"]=array("danger","Oops! Invalid Format!","There was a problem uploading the logo. Check that the file is valid and try again!");

							}

							if(!isset($data["message"])){

								//Finish

								Hub::find($id)->update(array(

                                    "name"=>$name,

                                    "logo"=>$logo_name,

                                    "email"=>$email,

                                    "paypal"=>$paypal,

                                    "percentage"=>$percentage,

                                    "website"=>$website,

                                    "contract_url_form"=>$contract_url_form,

                                    "percentage_form"=>$percentage_form

                                ));

								$data['message']=(array("success","Congratulations! Hub updated successfully!","All hub data were changed successfully"));

			                     return Redirect::to('hubs')->with($data);

			 				}

						}else $data["message"]=array("danger","Oops! Invalid Data!","Please, fill in the fields correctly!");

					}else $data["message"]=array("danger","Oops! Fill out all fields!","There are required fields that were not filled, try again!");

					//Render

                    return Redirect::to('hubs/edit/'.$id)->with($data);

				}elseif(Manager::validateManager(Auth::user()->id,$id)){

					//Proccess

					if((isset($_REQUEST["email"]) && isset($_REQUEST["website"]) && isset($_REQUEST["paypal"])) && (!empty($_REQUEST["email"]) && !empty($_REQUEST["website"]) && !empty($_REQUEST["paypal"]))){

						//Tratamento

						$contract_url_form=$this->tratar($_REQUEST["contract_url_form"]);

						$email=$this->tratar($_REQUEST["email"],"sl");

						$website=$this->tratar($_REQUEST["website"]);

						$paypal=((isset($_REQUEST["paypal"]) && !empty($_REQUEST["paypal"])) ? $this->tratar($_REQUEST["paypal"],"sl") : '');

/*						$percentage_form=$_REQUEST["percentage_form"];*/

						//Objeto

						$hub=Hub::find($id);



						define ("LOGOS",base_path()."/public/uploads/logos");

						$logo_name=$hub->logo;

						if(is_uploaded_file($_FILES['logo']['tmp_name'])){

							$filename = $_FILES['logo']['name'];

                            $extensao = pathinfo($filename, PATHINFO_EXTENSION);

							$extensoes = array('gif', 'jpeg', 'jpg', 'png');

							if(in_array($extensao, $extensoes)){

								$logo_name=md5(rand(0,rand(0,99999)).sha1(date("Y"))).".png";

								$logo_path=LOGOS."/".$logo_name;

								$result = move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path);

								if($result){

									@unlink(LOGOS.'/'.$hub->logo);

								}else $data["message"]=array("danger","Oops! Invalid Format!","Please, the logo must be uploaded in PNG/JPG/GIF format!");

							}else $data["message"]=array("danger","Oops! Invalid Format!","There was a problem uploading the logo. Check that the file is valid and try again!");

						}

						if(!isset($data["message"])){

							//Finish

							$hub=Hub::find($id);

                            $hub->update(array(

                                "logo"=>$logo_name,

                                "email"=>$email,

                                "paypal"=>$paypal,

                                "website"=>$website,

                                "contract_url_form"=>$contract_url_form,

                               /* "percentage_form"=>$percentage_form*/

                            ));

							$data['message']=(array("success","Congratulations! Hub updated successfully!","All hub data were changed successfully"));

			                 return Redirect::to('hubs')->with($data);

						}

					}else $data["message"]=array("danger","Oops! Fill out all fields!","There are required fields that were not filled, try again!");

					//Render

					return Redirect::to('hubs/edit/'.$id)->with($data);

				}else return Redirect::to('hubs/edit/'.$id)->with($data);

			}else {

			 $data['message']=(array("danger","Oops, Invalid ID!","Please, enter a valid ID!"));

			 return Redirect::to('hubs')->with($data);

			}

	}

    /**

	 * Genegate emails.

	 *

	 * @param  int  $id

	 * @return Response

	 */

    public function csvemails($id){

		$return=0;

		$file_path = $this->emails_file_path;

		if(isset($id) && is_numeric($id) && file_exists($file_path)){

			if((Manager::validateManager(Auth::user()->id,$id)) || (Auth::user()->role=='administrator')){

				$linked_id=Status::where('slug','linked')->first()->id;

				$ready_id=Status::where('slug','ready-for-pay-out')->first()->id;

				$channels=Channel::where("hub_id",$id)

                                ->where("status",$linked_id)

                                ->whereOr("status",$ready_id)->get();

				if(count($channels) > 0){

					$dados = '';  

					# Colunas 

				    # \$dados .= '"Channel Name",'; 

					$dados .= 'Channel Email,'; 

					$dados .="\n";  

					foreach($channels as $channel)

						$dados.='"'.$channel->email.'"'."\n";

					# Processamento

					if(fwrite($file=fopen($file_path,'w+'),$dados)) {  

						fclose($file);  

						$return=url().'/'.$file_path; 

					}

				}

			}

		}

		echo $return;

	}

	/**

	 * Remove hubs

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function destroy($id)

	{

		if(isset($id) && is_numeric($id)){

				if(Auth::user()->role=='administrator'){

					$hub=Hub::find($id);

					if(!is_null($hub)){

					   //get all row channels form hub_id

						$channels=Channel::where('hub_id',$hub->id)->get();

						foreach($channels as $channel)

							$channel->update_attributes(array("hub_id"=>1));

						Manager::deleteManagers($hub->id);

						$hub->delete();

						$data['message']=(array("success","Congratulations, the HUB has been successfully deleted!","All channels were assigned to main HUB"));

					    return Redirect::to('hubs')->with($data);

                    }else {

					    $data['message']=(array("danger","Oops, Invalid ID!","Please, enter a valid ID!"));

                        return Redirect::to('hubs')->with($data);

					}

				}

                else {

					    $data['message']=(array("danger","Oops! Permission denied!","You do not have permission to perform this action!"));

                        return Redirect::to('hubs')->with($data);

                }

			}else {

			     $data['message']=(array("danger","Oops, Invalid ID!","Please, enter a valid ID!"));

                 return Redirect::to('hubs')->with($data);

            }

	}





}

