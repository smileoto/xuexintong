<?php

use Phalcon\Mvc\Model;

class Introductions extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id', array(
			'reusable' => true
		));
	}
}
