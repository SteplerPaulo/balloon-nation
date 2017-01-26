<?php
class Inquiry extends AppModel {
	var $name = 'Inquiry';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'InquiryFile' => array(
			'className' => 'InquiryFile',
			'foreignKey' => 'inquiry_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
