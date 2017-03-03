<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Costumer' => array(
			'className' => 'Costumer',
			'foreignKey' => 'costumer_id',
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
