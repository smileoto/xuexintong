<?php

use Phalcon\Mvc\Model;

class Contacts extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id', array(
			'reusable' => true
		));
	}
}
