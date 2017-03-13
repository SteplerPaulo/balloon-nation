<?php
class InquiryFile extends AppModel {
	var $name = 'InquiryFile';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Inquiry' => array(
			'className' => 'Inquiry',
			'foreignKey' => 'inquiry_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
