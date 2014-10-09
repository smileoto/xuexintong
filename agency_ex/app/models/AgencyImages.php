<?php

use Phalcon\Mvc\Model;

class AgencyImages extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
	}
}
