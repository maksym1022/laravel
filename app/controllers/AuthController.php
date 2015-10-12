<?php



class AuthController extends Controller {



	/**

	 * Display a listing of the resource.

	 *

	 * @return Response

	 */

	

    public function login()

    {

        

        if ($this->isPostRequest()) {

            $validator = $this->getLoginValidator();

            

            if ($validator->passes()) {

                $credentials = $this->getLoginCredentials();

                

                if (Auth::attempt($credentials)) {

                    return Redirect::to('/');

                }

                return Redirect::back()->withErrors([

                    "password" => ["Credentials invalid."]

                ]);

            } else {

            return Redirect::back()

              ->withInput()

              ->withErrors($validator);

            }

        }

        return View::make("Login");

    }

    

    protected function isPostRequest()

    {

        return Input::server("REQUEST_METHOD") == "POST";

    }

    

    protected function getLoginValidator()

    {

        return Validator::make(Input::all(), [

        "username" => "required",

        "password" => ""

        ]);

    }

    public function logout()

    {

        Auth::logout();

        return Redirect::to('login');

    }

    protected function getLoginCredentials()

    {

        return [

        "username" => Input::get("username"),

        "password" => Input::get("password"),

        ];

    }



}

