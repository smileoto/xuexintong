<?php

use Phalcon\Mvc\Model;

class SignupInfor extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
	}
}
