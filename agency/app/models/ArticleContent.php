<?php

use Phalcon\Mvc\Model;

class ArticleContent extends Model
{
	public function initialize()
	{
		$this->belongsTo('article_id', 'Articles', 'id');
	}
}
