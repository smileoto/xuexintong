<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
	}
}
