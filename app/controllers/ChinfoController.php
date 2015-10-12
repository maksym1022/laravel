<?php

class ChinfoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$linked=Status::where('slug','linked')->first()->id;
		$ready=Status::where('slug','ready-for-pay-out')->first()->id;
		$channels = Channel::where('status',$linked)
                            ->whereOr('status',$ready)->paginate(15);
		$data=array(
			'channels'=>$channels,
		);
		return  View::make("Chinfo",$data);
	}




}
