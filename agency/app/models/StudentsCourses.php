<?php

use Phalcon\Mvc\Model;

class StudentsCourses extends Model
{
	public function initialize()
    {
        $this->belongsTo('student_id', 'Students', 'id');
        $this->belongsTo('course_id',  'Courses',  'id');
    }
}
