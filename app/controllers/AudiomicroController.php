<?php
class audiomicroController extends \BaseController {

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
	    $data["musicas"] = DB::table('music')->get();             
        return View::make("Audiomicro", $data);
	}
    
}    