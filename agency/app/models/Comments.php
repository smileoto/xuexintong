<?php

use Phalcon\Mvc\Model;

class Comments extends Model
{
	public function initialize()
	{
		$this->belongsTo('student_id', 'Students', 'id');
	}
}
