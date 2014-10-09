<?php

use Phalcon\Mvc\Model;

class WorkContent extends Model
{
	public function initialize()
	{
		$this->belongsTo('work_id', 'Works', 'id');
	}
}
