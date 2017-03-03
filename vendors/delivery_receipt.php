<?php
require('formsheet.php');
class DeliveryReceipt extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'P';	
	protected static $curr_page = 1;
	protected static $page_count;
	
	function DeliveryReceipt(){
		$this->showLines = !true;
		$this->FPDF(DeliveryReceipt::$_orient, DeliveryReceipt::$_unit,array(DeliveryReceipt::$_width,DeliveryReceipt::$_height));
		$this->createSheet();
	}
	
	function blue_print(){
		$metrics = array(
			'base_x'=> 0,
			'base_y'=> 0,
			'width'=> 4,
			'height'=> 11,
			'cols'=> 20,
			'rows'=> 3,	
		);	
		$this->section($metrics);
		$this->DrawImage(0,0,8.5,6.375,'../webroot/img/dr.jpg');
		
	}
	
	function data($data){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0,
			'base_y'=> 0,
			'width'=> 8.5,
			'height'=> 6.375,
			'cols'=> 28,
			'rows'=> 28,	
		);	
		$this->section($metrics);
	
	
		$this->GRID['font_size']=8;
		$this->leftText(5.5,7.2, $data['Costumer']['name'],'','');
		$this->leftText(20.2,7.2,date('F d, Y h:i:s A',strtotime($data['Delivery']['date'])),'','');
		
		$this->leftText(5,7.9,$data['Costumer']['address'],'','');
		$this->leftText(20.2,7.9,'Consignment','','');

		$this->leftText(6,8.7,'****','','');
		$this->leftText(20.2,8.7,'******','','');
		//pr($data);exit;
		$y=10.8;
		foreach($data['DeliveryDetail'] as $items){
			$this->centerText(3,$y,$items['deliver'],2,'');
			$this->centerText(5,$y,'Pcs.',2,'');
			$this->leftText(7.2,$y++,$items['Product']['name'],2,'');
		}
	}

}
?>
	