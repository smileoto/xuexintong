<?php

use Phalcon\Mvc\Model;

class FeedbackReply extends Model
{
	public function initialize()
	{
		$this->belongsTo('feedback_id', 'Feedbacks', 'id');
	}
}
