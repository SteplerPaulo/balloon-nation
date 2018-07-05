<?php
class Customer extends AppModel {
	var $name = 'Customer';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'customer_id',
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
	
	public function complete_list_of_double_entry(){
		return $this->query(
			"SELECT 
				  product.id,
				  product.name,
				  product.customer_id,
				  customers.id,
				  customers.name,
				  CountOf 
				FROM
				  products `product` 
				  INNER JOIN `customers` 
					ON (
					  `product`.`customer_id` = `customers`.`id`
					) 
				  INNER JOIN 
					(SELECT 
					  `name`,
					  customer_id,
					  COUNT(*) AS CountOf 
					FROM
					  products 
					GROUP BY `name`,
					  customer_id 
					HAVING COUNT(*) > 1) dt 
					ON product.name = dt.name 
					AND product.customer_id = dt.customer_id 
				ORDER BY `product`.`name`,
				  `product`.`customer_id` "
		);
	}
	
	public function deleted_deliveries(){
		return $this->query(
			"SELECT 
				  product.id,
				  product.name,
				  product.customer_id,
				  customers.id,
				  customers.name,
				  delivery_details.*,
				  CountOf 
				FROM
				  products `product` 
				  INNER JOIN `customers` 
					ON (
					  `product`.`customer_id` = `customers`.`id`
					) 
				  INNER JOIN `delivery_details` 
					ON (
					  `product`.`id` = `delivery_details`.`product_id`
					) 
				  INNER JOIN 
					(SELECT 
					  `name`,
					  customer_id,
					  COUNT(*) AS CountOf 
					FROM
					  products 
					GROUP BY `name`,
					  customer_id 
					HAVING COUNT(*) > 1) dt 
					ON product.name = dt.name 
					AND product.customer_id = dt.customer_id 
				WHERE product.id NOT IN (
					1023,
					1032,
					1166,
					1352,
					1277,
					1345,
					1196,
					1332,
					983,
					1005,
					1024,
					1361,
					1376,
					2296,
					2567,
					2497,
					2616,
					1433,
					1036,
					1183,
					1185,
					1326,
					1075,
					1369,
					1384,
					1170,
					1411,
					1363,
					1172,
					1371,
					1350,
					1335,
					1161,
					1252,
					1064,
					1163,
					1406,
					1189,
					1034,
					1181,
					1322,
					1033,
					1179,
					1382,
					1184
				  ) 
				ORDER BY `product`.`name`,
				  `product`.`customer_id` "
		);
	}
	
	public function double_entry_list(){
		return $this->query(
			"SELECT 
			  *,COUNT(*) 
			FROM
			 products 
			 INNER JOIN `customers` 
				ON (
				  `products`.`customer_id` = `customers`.`id`
				) 
			GROUP BY `products`.`name`, `customer_id`
			HAVING COUNT(*) > 1 "
		);			
	}

}
