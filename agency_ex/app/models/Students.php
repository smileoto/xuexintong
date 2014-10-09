<?php

use Phalcon\Mvc\Model;

class Students extends Model
{
	public function initialize()
	{
		$this->belongsTo('entity_id', 'Entities', 'id');
		
		$this->hasMany('id', 'TopsStudents', 'student_id');
		
		$this->hasMany('id', 'Comments', 'student_id');
		
		$this->hasManyToMany(
            "id",
            "TopsStudents",
            "student_id", "course_id",
            "Courses",
            "id"
        );
	}
}
