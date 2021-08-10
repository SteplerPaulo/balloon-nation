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
		//$this->DrawImage(0,0,8.5,11,'../webroot/img/drnew.jpg');
	}
	
	function data($data,$dt){
		//pr($data);
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0,
			'base_y'=> 0,
			'width'=> 8.5,
			'height'=> 6.25,
			'cols'=> 28,
			'rows'=> 29,	
		);	
		$this->section($metrics);
	
		$this->GRID['font_size']=8;
		$this->leftText(4,5.8, $data['Customer']['name'],'','');
		$this->leftText(20.2,5.8,date('F d, Y h:i:s A',strtotime($data['Delivery']['date'])),'','');
		
		$this->leftText(4,6.7,$data['Customer']['address'],'','');
		$this->leftText(20.2,6.7,'Consignment','','');

		$this->leftText(6,7.4,'****'.$data['Delivery']['delivery_receipt_no'],'','');
		$this->leftText(20.2,7.4,'******','','');
		//pr($data);exit;
		$y=9.6;
		$this->GRID['font_size']=6.5;
		foreach($dt as $k => $items){
			if($k < 36){
				if($items['deliver'] && $items['bad_item']){
					$this->rightText(2.15,$y,$items['deliver'].' |','','');
					$this->SetTextColor(255,0,0);
					$this->leftText(2.15,$y,' -'.$items['bad_item'],'','');
					$this->SetTextColor(0,0,0);
				}else if($items['deliver']){
					$this->centerText(1.4,$y,$items['deliver'],2,'');
				}else if($items['bad_item']){
					$this->SetTextColor(255,0,0);
					$this->centerText(1.4,$y,'-'.$items['bad_item'],2,'');
					$this->SetTextColor(0,0,0);
				}
				$this->centerText(3,$y,'Pcs.',2,'');
				$this->leftText(5.8,$y,isset($items['Product']['name'])?$items['Product']['name']:'',2,'');
				$this->leftText(5.8,$y+0.5,isset($items['Product']['item_code'])?$items['Product']['item_code']:'',2,'');
				$y+=1;
			}else{
				if($k == 36) $y=9.6;
				
				if($items['deliver'] && $items['bad_item']){
					$this->rightText(14.75,$y,$items['deliver'].' |','','');
					$this->SetTextColor(255,0,0);
					$this->leftText(14.75,$y,' -'.$items['bad_item'],'','');
					$this->SetTextColor(0,0,0);
					
				}else if($items['deliver']){
					$this->centerText(15,$y,$items['deliver'],2,'');
				}else if($items['bad_item']){
					$this->SetTextColor(255,0,0);
					$this->centerText(15,$y,'-'.$items['bad_item'],2,'');
					$this->SetTextColor(0,0,0);
				}
				$this->centerText(17,$y,'Pcs.',2,'');
				$this->leftText(19.2,$y,isset($items['Product']['name'])?$items['Product']['name']:'',2,'');
				$this->leftText(19.2,$y+0.5,isset($items['Product']['item_code'])?$items['Product']['item_code']:'',2,'');
				$y+=1;
			}
		}
	}
}
?>
	