<?php

class FinanceController extends \BaseController {

    private $channels_file_path= 'public/files/excel/channels.csv';
    private $hubs_file_path='public/files/excel/hubs.csv';
    
    public function __construct(){
		parent::__construct();
        fopen($this->channels_file_path, "w+");
		fopen($this->hubs_file_path, "w+");
	}
    /**
	 * Display the table payments with channels name.
	 *
	 * @return Response
	 */
    public function channelspayments($month=NULL,$year=NULL){
        
		$data=array(
			'channels'=>Channel::getChannels(),
            'month'=>((($month) && is_numeric($month)) ? $month : date("m")),
			'year'=>((($year) && is_numeric($year)) ? $year : date("Y")),
			'first_year'=>DB::table('payments')->first()->year,
		);
		return View::make("ChannelsPayments",$data);
	}
    /**
	 * Display buton download CSV channels and write data file.
	 *
	 * @return string
	 */
    public function csvchannels($month=NULL,$year=NULL){
		$return=0;
        if(isset($month) && isset($year)){
			$file_path = $this->channels_file_path;
			if(is_numeric($month) && is_numeric($year) && file_exists($file_path)){
				$PendingPayments=Payment::getPaymentsToExport($month,$year);
				if(count($PendingPayments) > 0){
					$dados = '';  
					# Colunas 
					$dados .= '"Recipient ID",';  
					$dados .= '"Payment",';
					$dados .= '"Currency",';
					$dados .= '"Note"';
					$dados .="\n";  
					  
					# Dados
				   	foreach($PendingPayments as $payment){
				   		$channel=Channel::find($payment->channel_id);
				   		$hub=Hub::find($channel->hub_id);
				   		$dados.='"'.$channel->paypal.'","'.number_format(($payment->value*($channel->percentage/100)), 2, '.', ',').'","USD","'.$hub->name.' - channel: '.$channel->name.'"'."\n";
				   	}

				   	# Processamento
					if(fwrite($file=fopen($file_path,'w+'),$dados)) {  
						fclose($file);  
						$return=asset('').$file_path; 
					}
				}
			}
		}echo $return;
	}
    /**
	 * Show the table payments with hubs name.
	 *
	 * @return Response
	 */
	public function hubspayments($month=NULL,$year=NULL){
		# Info
		$data["month"]=((isset($month) && is_numeric($month)) ?$month : date("m"));
		$data["year"]=((isset($year) && is_numeric($year)) ? $year : date("Y"));
		$data["payments"]=Payment::getHubsPaymentsToExport($data["month"],$data["year"]);
		$data["first_year"]=Payment::getFirstYear();
		# Render
        return View::make("HubsPayments",$data);
	}
    
     /**
	 * Display buton download CSV hubs and write data file.
	 *
	 * @return string
	 */
    public function csvhubs($month=NULL,$year=NULL){
		$return=0;
		if(isset($month) && isset($year)){
			$file_path = $this->hubs_file_path;
			if(is_numeric($month) && is_numeric($year) && file_exists($file_path)){
				$PendingPayments=Payment::getHubsPaymentsToExport($month,$year);
				if(count($PendingPayments) > 0){
					$dados = '';  
					# Colunas 
					$dados .= '"Recipient ID",';  
					$dados .= '"Payment",';
					$dados .= '"Currency",';
					$dados .= '"Note"';
					$dados .="\n";  
					  
					# Dados
				   	foreach($PendingPayments as $hub_id => $value){
				   		if($value > 0){
				   			$hub=Hub::find($hub_id);
				   			$dados.='"'.$hub->paypal.'","'.number_format($value, 2, '.', ',').'","USD","'.$hub->name.' - '.count(Channel::where('hub_id',$hub_id)->get()).' Channels"'."\n";
				   		}
				   	}

				   	# Processamento
					if(fwrite($file=fopen($file_path,'w+'),$dados)) {  
						fclose($file);  
						$return=asset('').$file_path; 
					}
				}
			}
		}
		echo $return;
	}
    //Multiple
	public function bulk($params1,$month,$year){
	   if(empty($_REQUEST['bulk'])){
	       $type=(($params1 == 1) ? 'channel' : 'hub');
           if($type=='channel'){
                return Redirect::to('finance/channelspayments');
           }else{
                return Redirect::to('finance/hubspayments');
           }
	       
	   }
	   switch ($_REQUEST["action"]) {
			case 'finish':
				$x=0;
				$type=(($params1 == 1) ? 'channel' : 'hub');
				if($type == "channel"){
					foreach($_REQUEST["bulk"] as $key=>$value)
						$this->finish($value);
                    $data["message"]=array("success","Congratulations! Payments updated successfully!","All payment details have been changed successfully");
                    return Redirect::to('finance/channelspayments/month/'.$month.'/year/'.$year)->with($data);
                }
				else{
					foreach($_REQUEST["bulk"] as $key=>$value)
						$this->finishhub($value);
                    $data["message"]=array("success","Congratulations! Payments updated successfully!","All payment details have been changed successfully");
                    return Redirect::to('finance/hubspayments/month/'.$month.'/year/'.$year)->with($data);
                }
                    break;
		}
	}
    public function finish($value=NULL,$id=NUll,$month=NULL,$year=NULL){
		if(!is_numeric($value)){
		  $data=explode("/",$value);
		}else{
		  $data = array($id,$month,$year,$value);
		}
        $id =  $data[0];
		$month  =  $data[1];
		$year   =  $data[2];
		$value  =  $data[3];
		if(isset($id) && isset($month) && isset($year) && is_numeric($id) && is_numeric($month) && is_numeric($year)){
			$month=((isset($month) && is_numeric($month)) ? $month : (date("m")-1));
			$year=((isset($year) && is_numeric($year)) ? $year : date("Y"));
			$pagamento=(($value != 0) ? Payment::getPaymentFromChannel($id,$month,$year) : Payment::getPaymentFromHub($id,$month,$year));
			if($pagamento->value > 1 && $pagamento->status == 0){
				$pagamento->status = 1;
                $pagamento->save();
				echo $pagamento->updated_at;
			}else echo 0;
		}else echo 0;
	}
    public function insertvalue(){
			$data=explode("/",$_REQUEST["id"]);
			if(count($data) == 3 && is_numeric($data[0]) && is_numeric($data[1]) && is_numeric($data[2])  && is_numeric($data[0]) && $data[1] > 0 && $data[1] <= 12 && strlen($data[2]) == 4){
				$_REQUEST["value"]=trim($_REQUEST["value"]);
				$valor=str_replace("US$","",$_REQUEST["value"]);
				$valor=str_replace(" ","",$valor);
				$valor=str_replace("&nbsp;","",$valor);
				$payment=Payment::getPaymentFromChannel($data[0],$data[1],$data[2]);
				if(count($payment) == 1 && $payment->status == 0)
					$payment->update_attributes(array("value"=>$valor));
				else Payment::create(array("
                    channel_id"=>$data[0],
                    "user_id"=>Auth::user()->id,
                    "value"=>$valor,
                    "IP"=>$_SERVER["REMOTE_ADDR"],
                    "month"=>$data[1],
                    "year"=>$data[2],
                    "type"=>1,
                    "status"=>0
                ));
				echo $valor;
			}else echo 0;
		}
    public function finishhub($id=NUll,$month=NULL,$year=NULL,$value=NULL){
		if(!is_numeric($id)){
		  $data=explode("/",$id);
		}else{
		  $data = array($id,$month,$year,$value);
		}
        # hubid/month/year/value
		# Get Data
		$hub_id =  $data[0];
		$month  =  $data[1];
		$year   =  $data[2];
		$value  =  $data[3];
		$PendingPayments=Payment::getHubsPaymentsToExport($month,$year);
		if($PendingPayments[$hub_id] == $value){
			Payment::create(array("hub_id"=>$hub_id,
                "user_id"=>Auth::user()->id,
                "value"=>$value,
                "IP"=>$_SERVER['REMOTE_ADDR'],
                "month"=>$month,
                "year"=>$year,
                "type"=>2,
                "status"=>1
            ));
			echo date("Y-m-d H:i:s");
		}else echo 0;
	}
    /**
    * Show the table MCN Earnings
    *
    * @return Response
    */
    public function mcnearnings($month=NULL,$year=NULL){
		# Info
		$data["month"]=((isset($month) && is_numeric($month)) ? $month : date("m"));
		$data["year"]=((isset($year) && is_numeric($year)) ? $year : date("Y"));
		$data["payments"]=Payment::getHubsPaymentsToExport($data["month"],$data["year"]);
		$data["first_year"]=Payment::getFirstYear();
		# Render
        return View::make("MCNEarnings",$data);
	}


}
