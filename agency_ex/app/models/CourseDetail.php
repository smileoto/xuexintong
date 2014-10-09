<?php

use Phalcon\Mvc\Model;

class CourseDetail extends Model
{
	public function initialize()
	{
		$this->belongsTo('course_id', 'Courses', 'id');
	}
}
