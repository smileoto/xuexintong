<?php

use Phalcon\Mvc\Model;

class Feedbacks extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
		
		$this->hasMany('id', 'FeedbackReply', 'feedback_id');
	}
}
