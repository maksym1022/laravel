<?php

class BaseController extends Controller {
    
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
    public static function tratar($string,$add="",$html=false){
			if(!empty($add)){
				switch ($add) {
					case 'uw':
						$string=ucwords($string);
						break;
					case 'sl':
						$string=strtolower($string);
						break;
					case 'su':
						$string=strtoupper($string);
						break;
					case 'hash':
						$string=md5(sha1($string."hxcursos"));
						break;
					case 'nl' :
						$string=nl2br($string);
						break;
					case 'slug' :
						$string=strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($string)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ "),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
						$string=str_replace(" ", "_", $string);
						$string=str_replace("&nbsp;", "_", $string);
						break;
					case 'sanitize':
						$string = preg_replace('/[áàãâä]/ui', 'a', $string);
					    $string = preg_replace('/[éèêë]/ui', 'e', $string);
					    $string = preg_replace('/[íìîï]/ui', 'i', $string);
					    $string = preg_replace('/[óòõôö]/ui', 'o', $string);
					    $string = preg_replace('/[úùûü]/ui', 'u', $string);
					    $string = preg_replace('/[ç]/ui', 'c', $string);
					    // $string = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $string);
					    $string = preg_replace('/[^a-z0-9]/i', '', $string);
					    $string = preg_replace('/_+/', '', $string); // ideia do Bacco :)
						break;
				}
			}
			$string=addslashes(trim($string));
			return ($html) ? $string : str_replace("\\","",strip_tags($string));
		}

}
