<?php

class PayController extends \BaseController {

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
		$channels = DB::table('channels as c')->join('statuses as s', 'c.status', '=', 's.id')
                    ->where('c.status', 4)
                    ->orWhere('c.status', 5)
                    ->select('c.*', 's.name as st')
                    ->paginate(15);
        $data = [];
		$data["channels"]=$channels;
        return View::make("Pay",$data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}



}
