<?php

use Phalcon\Mvc\Model;

class Tasks extends Model
{
	public function initialize()
	{
		$this->belongsTo('entity_id', 'Entities', 'id');
		$this->hasOne('id', 'TaskContent', 'task_id');
	}
}
