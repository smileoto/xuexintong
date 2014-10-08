<?php

use Phalcon\Mvc\Model;

class Courses extends Model
{
	public function initialize()
	{
		$this->belongsTo('class_id', 'Classes', 'id');
		
		$this->hasOne('id', 'CourseDetail', 'course_id');
		
		$this->hasMany('id', 'StudentsCourses', 'course_id');
	}
}
