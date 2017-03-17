<?php
class Sale extends AppModel {
	var $name = 'Sale';
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
		'SaleDetail' => array(
			'className' => 'SaleDetail',
			'foreignKey' => 'sale_id',
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
	
	public function get_data($costumer_id=null,$from=null,$to=null){
		return $this->query(
			"SELECT 
			  `delivery_details`.`in_stock`,
			  SUM(`delivery_details`.`bad_item`) AS total_returned,
			  SUM(`delivery_details`.`deliver`) AS total_delivered,
			 (SUM(`delivery_details`.`deliver`) - (SUM(`delivery_details`.`bad_item`) + `products`.`current_quantity`)) AS system_count,
			  `delivery_details`.`purchase_price`,
			  `products`.`id`,
			  `products`.`name`,
			  `products`.`item_code`,
			  `products`.`current_quantity`,
			  `costumers`.`id`,
			  `costumers`.`name`
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
			  INNER JOIN `costumers` 
				ON (
				  `products`.`costumer_id` = `costumers`.`id`
				) 
			WHERE (
					`costumers`.`id` = '$costumer_id'
					AND `deliveries`.`date` >= '$from' 
					AND `deliveries`.`date` <= '$to' 
					) 
			GROUP BY `products`.`id`,
			  `products`.`costumer_id` ;
			"
		);
	}


}
