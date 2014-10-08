<?php

use Phalcon\Mvc\Model;

class ArticleImages extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
	}
}
