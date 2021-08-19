<?php
class Api extends AppModel {
	var $name = 'Api';
	var $useTable = false;
	
	function projected_revenue($year){
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

	//ADDED CUSTOMER PER YER
	function customers_graph(){
		return $this->query(
			"SELECT 
			  YEAR(customers.created) AS `year`,
			  COUNT(*) AS added_customers
			FROM
			  customers 
			GROUP BY YEAR(customers.created)"
		);
	}
	
}