<?php

use Phalcon\Mvc\Model;

class Guests extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
	}
}
