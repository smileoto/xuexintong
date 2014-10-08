<?php

use Phalcon\Mvc\Model;

class Tops extends Model
{
	public function initialize()
	{
		$this->belongsTo('entity_id', 'Entities', 'id');
		
		$this->hasManyToMany(
            "id",
            "TopsStudents",
            "top_id", "student_id",
            "Students",
            "id"
        );
	}
}
