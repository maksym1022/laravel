<?php
class Analytic extends Eloquent {
    
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'analytics';
    protected $guarded = array('id');
    public $timestamps = false;
    
}