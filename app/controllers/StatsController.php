<?php

class StatsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
    	$linked=Status::where('slug','linked')->first()->id;
		$ready=Status::where('slug','ready-for-pay-out')->first()->id;
    	$data=array(
    		'channels'=>Channel::where('status',$linked)->whereOr('status',$ready)->get(),
    	);
    	return View::make('Stats',$data);
	}




}
