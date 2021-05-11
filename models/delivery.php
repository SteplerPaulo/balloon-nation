<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	var $virtualFields = array(
		'formated_date' => 'DATE_FORMAT(Delivery.date,"%M %d,%Y %h:%i:%s %p")',
	);
	
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'DeliveryDetail' => array(
			'className' => 'DeliveryDetail',
			'foreignKey' => 'delivery_id',
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
