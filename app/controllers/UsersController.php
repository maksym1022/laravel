<?php



class UsersController extends \BaseController {

    

    

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

	 * Show the form for creating a new resource.

	 *

	 * @return Response

	 */

	public function create()

	{

        $data["roles"] = DB::table('roles')->lists('name','id');

        $data["hubs"] = DB::table('hubs')->lists('name', 'id');

        return View::make('Newuser',$data);

	}

    public function register(){

        $validator = Validator::make(Input::all(), User::$rules);

        if ($validator->passes()) {

            $random_salt = Hash::make(uniqid());

			$password = Hash::make('123456');

            $role = Role::find(Input::get('role_id'));

            $user = new User;

            $user->first_name = Input::get('first_name');

            $user->last_name = Input::get('last_name');

            $user->username = Input::get('username');

            $user->paypal = Input::get('paypal');

            $user->email = Input::get('email');

            $user->role_id = Input::get('role_id');

            $user->role = $role->role;

            $user->avatar = Input::get('avatar');

            $user->salt = $random_salt;

            $user->password = $password;

            $user->status = 0;

            $user->save();;

            $user_data=User::where('username',$user->username)->first();

            $id_user=$user_data->id;

            Manager::create(array("user_id"=>$id_user,"hub_id"=>Input::get('hub_id')));

            $data["message"]=array("success","Congratulations! User registered successfully!".$id_user,"The user was added successfully!");

            return Redirect::to('users')->with($data);

        } else {

           return Redirect::to('users/create')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();  

        }

	}

    

	/**

	 * Display the specified resource.

	 *

	 * @return Response

	 */

	public function show()

	{  

	    $users = User::getAll();

        $data = [];

		$data["users"]=$users;

        return View::make("UsersList",$data);

	}

    protected function getEditValidator()

    {

        return Validator::make(Input::all(), [

        'first_name'=>'required|alpha',

        'last_name'=>'required|alpha',

        'avatar'=>'required',

        'paypal'=>'required',

        'role_id'=>'required',

        'hub_id'=>'required',

        ]);

    }



	/**

	 * Show the form for editing the specified resource.

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function edit($id)

	{

	   if(Auth::user()->role=='administrator' || Manager::validatePrivileges($id)||1){

    		$data = [];

    		$data["user"] = DB::table('users')

                ->where('id', $id)->first();

            $data["managers"] = DB::table('managers')

                ->where('user_id', $id)->first();

            $data["roles"] = DB::table('roles')->lists('name','id');

            $data["hubs"] = DB::table('hubs')->lists('name', 'id');

            return View::make("EditUser",$data);

        }else{

            $data['message']=(array("danger","Oops! Permission denied!","You do not have permission to perform this action!"));

    		return Redirect::to('users')->with($data);

        }

	}





	/**

	 * Update user

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function update($id)

	{

	    if(Auth::user()->role=='administrator' || Manager::validatePrivileges($id)||1){
    	    $validator = $this->getEditValidator();
            $password = Hash::make(Input::get('password'));
            if ($validator->passes()||1) {
                $role = Role::find(Input::get('role_id'));
                DB::table('users')
                    ->where('id', $id)
                    ->update(array(
                        'first_name' => Input::get('first_name'),
                        'last_name' => Input::get('last_name'),
                        'paypal' => Input::get('paypal'),
                        'role_id' => Input::get('role_id'),
                        'role' => $role->role,
                        'avatar' => Input::get('avatar'),
                        'password'=>$password,
                    ));
                $hub_id=((Auth::user()->role == 'administrator') ? $_REQUEST["hub_id"] : Manager::getManagerByUser(Auth::user()->id)->hub_id);
                Manager::where('user_id',$id)->delete();
				Manager::create(array("user_id"=>$id,"hub_id"=>$hub_id));
          
                    $data['message']=array("success","Congratulations! User updated successfully!","All user data were changed successfully");
                if(Auth::user()->id==$id){
                    return Redirect::to('/')->with($data);
               }else{
                    return Redirect::to('users')->with($data);
               }
                
            } else {
                $data['message']=array("danger","Oops! Permission denied!","You do not have permission to perform this action!");
    		    return Redirect::to('users')->with($data);   
            }
       }else{
            $data['message']=array("danger","Oops, Invalid ID!","Please, enter a valid ID!");
    		return Redirect::to('users')->with($data);
        }
	}




	/**

	 * Remove user

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function destroy($id)

    {       

        if(Auth::user()->role=='administrator' || Manager::validatePrivileges($id)){

            $user = User::find($id);

            $user->delete();

            $data['message']=array("success","User successfully deleted!","All records this user have been deleted in the system!");

            return Redirect::to('users')->with($data);

        }else{

            $data['message']=array("danger","Oops, Invalid ID!","Please, enter a valid ID!");

    		return Redirect::to('users')->with($data);

        }

	}

    public function lock($id){

        if(Auth::user()->role=='administrator' || Manager::validatePrivileges($id)){                

            DB::table('users')

                    ->where('id', $id)

                    ->update(array(

                        'status' => 2

                    ));

            $data['message']=array("success","User successfully blocked!","This user can not access the platform without the release of an administrator!");

        	return Redirect::to('users')->with($data);

        }else{

            $data['message']=array("danger","Oops, Invalid ID!","Please, enter a valid ID!");

    		return Redirect::to('users')->with($data);

        }

	}

    public function unlock($id){

        if(Auth::user()->role=='administrator' || Manager::validatePrivileges($id)){

            DB::table('users')

                    ->where('id', $id)

                    ->update(array(

                        'status' => 1

                    ));

            $data['message']=array("success","User successfully unlocked!","You had your free access!");

        	return Redirect::to('users')->with($data);

        }else{

            $data['message']=array("danger","Oops, Invalid ID!","Please, enter a valid ID!");

    		return Redirect::to('users')->with($data);

        }

	}





}

