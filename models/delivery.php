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
	
	
	public function dashboard($year){
		return $this->query(
			"SELECT 
			  products.id,
			  products.name,
			  customers.name,
			  SUM(delivery_details.deliver) AS total_qty_delivered,
			  delivery_details.purchase_price,
			  delivery_details.selling_price,
			  COUNT(*) AS no_of_times_delivered
			FROM
			  `deliveries` 
			  INNER JOIN `delivery_details` 
				ON (
				  `deliveries`.`id` = `delivery_details`.`delivery_id`
				) 
			  INNER JOIN `customers` 
				ON (
				  `deliveries`.`customer_id` = `customers`.`id`
				) 
			  INNER JOIN `products` 
				ON (
				  `delivery_details`.`product_id` = `products`.`id`
				) 
			WHERE deliveries.created LIKE '%$year%' 
			GROUP BY products.name,
			  delivery_details.purchase_price,
			  delivery_details.selling_price 
			ORDER BY products.name 
			"
		);
	}

}
