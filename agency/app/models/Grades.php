<?php

use Phalcon\Mvc\Model;

class Grades extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
	}
}
