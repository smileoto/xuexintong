<?php

use Phalcon\Mvc\Model;

class NewsImages extends Model
{
	public function initialize()
	{
		$this->belongsTo('news_id', 'News', 'id');
	}
}
