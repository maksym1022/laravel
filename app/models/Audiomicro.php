<?php
class Audiomicro extends Eloquent{
    
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'music';
    protected $guarded = array('id');
    public $timestamps = false;
    	
	static function getMusic()
      {
		$data = self::find("all");
		return $data;
      } 
}
?>