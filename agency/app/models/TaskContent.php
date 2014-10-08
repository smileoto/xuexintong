<?php

use Phalcon\Mvc\Model;

class Tasks extends Model
{
	public function initialize()
	{
		$this->belongsTo('task_id', 'Tasks', 'id');
	}
}
