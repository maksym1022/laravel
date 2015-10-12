<?php



class RecruiterController extends \BaseController {



	

	/**

	 * Display the specified resource.

	 *

	 * @param  int  $id

	 * @return Response

	 */

	public function show()

	{

	   $linked=Status::where('slug','linked')->first()->id;

	   $ready=Status::where('slug','ready-for-pay-out')->first()->id;

	   $channels = Channel::getChannels($ready);

        $data = [];

		$data["channels"]=$channels;

        return View::make("Recruiter",$data);

        

	}





	





}

