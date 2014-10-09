<?php

use Phalcon\Mvc\Model;

class TopContent extends Model
{
	public function initialize()
	{
		$this->belongsTo('top_id', 'Tops', 'id');
	}
}
