<?php

use Phalcon\Mvc\Model;

class ClassDetail extends Model
{
	public function initialize()
	{
		$this->belongsTo('class_id', 'Classes', 'id');
	}
}
