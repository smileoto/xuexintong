<?php

use Phalcon\Mvc\Model;

class Agencies extends Model
{
	public function initialize()
	{
		$this->hasMany('id', 'Entities', 'agency_id', array(
        	'foreignKey' => array(
        		'message' => 'Product Type cannot be deleted because it\'s used on Products'
        	)
        ));
		$this->hasOne('id', 'Introductions', 'agency_id');
		$this->hasOne('id', 'Contacts', 'agency_id');
		
		$this->hasMany('id', 'AgencyImages', 'agency_id');
	}
}
