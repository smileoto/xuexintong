<?php

use Phalcon\Mvc\Model;

class Items extends Model
{
	public function initialize()
	{
		$this->belongsTo('student_id', 'Students', 'id');
	}
}
