<?php

class Configs extends Eloquent  {

	public static function getPercentage($channel_percentage=""){
			$multiple=1;
			switch (Auth::user()->role) {
				case 'administrator':
					$max=100;
					break;
				default:
					$max=90;
					break;
			}
			if(empty($channel_percentage))
				$percentage=array(""=>"Select...");
			else
				$percentage[$channel_percentage]=$channel_percentage;
			for($i=50;$i<=$max;$i=$i+$multiple)
				$percentage[$i]=$i;
			return $percentage;
		}

}
