<?php
class Sale extends AppModel {
	var $name = 'Sale';
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
		'SaleDetail' => array(
			'className' => 'SaleDetail',
			'foreignKey' => 'sale_id',
			'dependent' => true,
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
	
	public function get_data($customer_id=null,$from=null,$to=null){
		return $this->query(
			"SELECT 
			  `products`.`id`,
			  SUM(`delivery_details`.`bad_item`) AS total_returned,
			  SUM(`delivery_details`.`deliver`) AS total_delivered,
			  `delivery_details`.`purchase_price`
			  
			FROM
			  `deliveries` 
			  INNER JOIN `delivery_details` 
				ON (
				  `deliveries`.`id` = `delivery_details`.`delivery_id`
				) 
			  INNER JOIN `products` 
				ON (
				  `delivery_details`.`product_id` = `products`.`id`
				) 
			  INNER JOIN `customers` 
				ON (
				  `products`.`customer_id` = `customers`.`id`
				) 
			WHERE (
					`customers`.`id` = '$customer_id'
					AND `deliveries`.`date` >= '$from' 
					AND `deliveries`.`date` <= '$to' 
					) 
			GROUP BY `products`.`id`,
			  `products`.`customer_id` 
			ORDER BY `products`.`name`;
			"
		);
	}
	
	public function unpost($customer_id = 2){
		$query = array();
		$query['ResetProduct'] =  $this->query("
					UPDATE 
					  products 
					SET
					  beginning_inventory = initial_inventory,
					  missing_qty = 0
					WHERE customer_id = $customer_id 
					ORDER BY NAME"
				);
				
		$query['UnpostSale'] =  $this->query("UPDATE sales SET is_posted= 0 WHERE customer_id = $customer_id");
	
		return $query;
	}
	

}
