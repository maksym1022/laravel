<?php

class AnalyticsController extends \BaseController {

	/**
	 * Display Analytics
	 *
	 * @return Response
	 */
	public function index()
    {
        
	    $linked=Status::where('slug','linked')->first()->id;
		$ready=Status::where('slug','ready-for-pay-out')->first()->id;
		$data=array(
			'channels'=>Channel::where('status',$linked)->whereOr('status',$ready)->get()
		);
        return View::make('Analytics',$data);
	}


	/**
	 * Show Graphic
	 *
	 * @return Response
	 */
	public function showGraphic(){
		if(isset($_POST['channel_id']) && is_numeric($_POST['channel_id'])){
			$id = (int) $_POST['channel_id'];
            $linked=Status::where('slug','linked')->first()->id;
		    $ready=Status::where('slug','ready-for-pay-out')->first()->id;
			$data=array(
				'channel_id' => $id,
				'channels'=>Channel::where('status',$linked)->whereOr('status',$ready)->get(),
			);
            return View::make('AnalyticsGraphic',$data);
		}else return View::make('Analytics',$data);
	}


	/**
	 * get data Analytics Graphic
	 *
	 * @return Response
	 */
	public function getData(){
	
			$grafico = array(
			    'dados' => array(
			        'cols' => array(
			            array('type' => 'string', 'label' => 'Month'),
			            array('type' => 'number', 'label' => 'Views')
			        ),  
			        'rows' => array()
			    ),
			    'config' => array(
			        'title' => 'Views monthly',
			        'width' => '600',
			        'height' => 260,
			        'hAxis' => array(
			        	'title' => 'Month'
			        ),
			        'vAxis' => array(
			        	'title' => 'Views'
			        )
			    )
			);

			// Consultar dados no BD
			$views = Analytic::where("channel_id",$_POST['channel_id'])->where("year",date("Y"))->get();
            
			foreach ($views as $view) {
				$dateObj   = DateTime::createFromFormat('!m', $view->month);
			    $grafico['dados']['rows'][] = array('c' => array(
			        array('v' => $dateObj->format('F')),
			        array('v' => (int)$view->views)
			    ));
			}
			// Enviar dados na forma de JSON
			echo json_encode($grafico);
		
	}



}
