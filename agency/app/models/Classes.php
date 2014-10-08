<?php

use Phalcon\Mvc\Model;

class Classes extends Model
{
	public function initialize()
	{
		$this->belongsTo('entity_id', 'Entities', 'id');
		
		$this->hasOne('id', 'ClassDetail', 'class_id');
	}
}
