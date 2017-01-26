<?php
class User extends AppModel {
	var $name = 'User';
	
	var $virtualFields = array(
		'full_name' => 'CONCAT(User.first_name, " " ,User.last_name)',
	);
		
	var $hasOne = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
