<?php

use Phalcon\Mvc\Model;

class TopsStudents extends Model
{
	public function initialize()
    {
        $this->belongsTo('top_id', 'Tops', 'id');
        $this->belongsTo('student_id', 'Students', 'id');
    }
}
