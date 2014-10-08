<?php

use Phalcon\Mvc\Model;

class Articles extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id', array(
			'reusable' => true
		));
		
		$this->hasOne('id', 'ArticleContent', 'article_id');
		
		$this->hasMany('id', 'ArticleImages', 'article_id');
	}
}
