<?php

use Phalcon\Mvc\Model;

class Articles extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
		$this->belongsTo('created_by', 'users', 'id');
	}
	
	public function onConstruct()
	{
		$this->status      = 0;
		$this->read_cnt    = 0;
		$this->created_at  = date('Y/m/d H:i:s');
		$this->modified_at = date('Y/m/d H:i:s');
	}
}
