<?php

use Phalcon\Mvc\Model;

class Entities extends Model
{
	public function initialize()
	{
		$this->belongsTo('agency_id', 'Agencies', 'id');
		
		$this->hasMany('id', 'Classes', 'entity_id', array(
        	'foreignKey' => array(
        		'message' => 'Product Type cannot be deleted because it\'s used on Products'
        	)
        ));
		
		$this->hasMany('id', 'Students', 'entity_id', array(
        	'foreignKey' => array(
        		'message' => 'Product Type cannot be deleted because it\'s used on Products'
        	)
        ));
	}
}
