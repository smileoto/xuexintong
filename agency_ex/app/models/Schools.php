<?php

use Phalcon\Mvc\Model;

class Schools extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
	}
}
