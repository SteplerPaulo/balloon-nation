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
	
	//MOST SOLD PRODUCTS based on delivered qty
	function most_sold_products($year=2021, $limit=25){
		return $this->query(
			"SELECT 
			  products.name,
			  SUM(delivery_details.deliver) AS total_qty_delivered
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
			WHERE deliveries.created LIKE '%$year%' 
			GROUP BY products.name
			ORDER BY total_qty_delivered DESC LIMIT $limit"
		);
	}
	
	//MOST PROFITABLE PRODUCTS based on delivered qty and markup price
	function most_profitable_products($year=2021, $limit=25){ 
		return $this->query(
			"SELECT 
			  products.name,
			  SUM(delivery_details.deliver) AS total_qty_delivered,
			  delivery_details.purchase_price,
			  delivery_details.selling_price,
			  (
				delivery_details.selling_price - delivery_details.purchase_price
			  ) AS markup,
			  (
				SUM(delivery_details.deliver) * (
				  delivery_details.selling_price - delivery_details.purchase_price
				)
			  ) AS revenue 
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
			WHERE deliveries.created LIKE '%$year%' 
			GROUP BY products.name
			ORDER BY revenue DESC  LIMIT $limit"
		);
	}
	
	//MOST SOLD PRODUCTS BY CUSTOMER based on delivered qty
	function most_sold_products_by_customer($year=2021, $limit=25, $compcode=2333){//MOST SOLD PRODUCTS based on delivered qty
		return $this->query(
			"SELECT 
			  products.name,
			  SUM(delivery_details.deliver) AS total_qty_delivered,
			  delivery_details.purchase_price,
			  delivery_details.selling_price,
			  (
				delivery_details.selling_price - delivery_details.purchase_price
			  ) AS markup,
			  (
				SUM(delivery_details.deliver) * (
				  delivery_details.selling_price - delivery_details.purchase_price
				)
			  ) AS revenue 
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
				  `deliveries`.`customer_id` = `customers`.`id`
				) 
			WHERE deliveries.created LIKE '%2021%' 
			  AND customers.compcode =  '$compcode' 
			GROUP BY products.name 
			ORDER BY revenue DESC "
		);
	}
}