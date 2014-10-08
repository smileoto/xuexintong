<?php

use Phalcon\Mvc\Model;

class Works extends Model
{
	public function initialize()
	{
		$this->belongsTo('entity_id', 'Entities', 'id');
	}
}
