<?php

use Phalcon\Mvc\Model;

class News extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
	}
	
	public function onConstruct()
	{
		$this->status      = 0;
		$this->read_cnt    = 0;
		$this->created_at  = date('Y/m/d H:i:s');
		$this->modified_at = date('Y/m/d H:i:s');
	}
}
