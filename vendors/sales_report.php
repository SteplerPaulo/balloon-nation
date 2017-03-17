<?php
require('formsheet.php');
class SalesReport extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'P';	
	protected static $curr_page = 1;
	protected static $page_count;
	
	function SalesReport(){
		$this->showLines = !true;
		$this->FPDF(SalesReport::$_orient, SalesReport::$_unit,array(SalesReport::$_width,SalesReport::$_height));
		$this->createSheet();
	}
	
	function hdr($data){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 0.25,
			'width'=> 8,
			'height'=> 1,
			'cols'=> 40,
			'rows'=> 5,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=14;
		$y=1;
		$this->centerText(0,$y++,'Balloon Republic General Merchandise',$metrics['cols'],'b');
		$this->GRID['font_size']=9;
		$this->centerText(0,$y++,'187B D. Tuazon St. Maharlika Quezon City',$metrics['cols'],'');
		$this->centerText(0,$y++,'Camille Alyssa P. Chua - Prop.',$metrics['cols'],'');
		$this->centerText(0,$y,'VAT Reg. TIN: 411-758-371-000',$metrics['cols'],'');
		
		$y+=1.8;
		$this->GRID['font_size']=10;
		$this->leftText(0,$y,'Costumer:','','b');
		$this->leftText(4,$y,$data['Costumer']['name'],'','');
		$this->leftText(20,$y,'Date:','','b');
		$this->leftText(22,$y++,date("M d", strtotime($data['Sale']['from_date'])).' - '.date("d, Y", strtotime($data['Sale']['to_date'])),'','');
		$this->leftText(0,$y,'Posted:','','b');
		$this->leftText(3,$y,($data['Sale']['is_posted'] == 1)?'True':'False','','');
	}
	
	function dtls($data){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 1.8,
			'width'=> 8,
			'height'=> 8,
			'cols'=> 40,
			'rows'=> 40,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;
		$this->drawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->drawMultipleLines(3,39,1,'h');
		$this->drawLine(2,'h');
		$this->drawLine(1,'h',array(13,15));
		$this->drawLine(13,'v',array(0,$metrics['rows']-1));
		$this->drawLine(16,'v',array(1,$metrics['rows']-2));
		$this->drawLine(19,'v',array(1,$metrics['rows']-2));
		$this->drawLine(22,'v',array(0,$metrics['rows']-2));
		$this->drawLine(25,'v',array(1,$metrics['rows']-2));
		$this->drawLine(28,'v',array(0,$metrics['rows']-1));
		$this->drawLine(31,'v',array(0,$metrics['rows']-1));
		$this->drawLine(34,'v');
		$this->drawLine(37,'v');
		$y=1;
		$this->centerText(0.2,1.2,'Item Description',16,'b');
		
		$this->centerText(13,0.8,'Quantity',9,'b');
		$this->centerText(13,1.8,'Delivered',3,'');
		$this->centerText(16,1.8,'Returned',3,'');
		$this->centerText(19,1.8,'Sold',3,'');
		
		$this->centerText(22,0.8,'Notation',6,'b');
		$this->centerText(22,1.8,'+',3,'');
		$this->centerText(25,1.8,'-',3,'');
		
		
		$this->centerText(28,0.9,'Purchase',3,'b');
		$this->centerText(28,1.7,'Price',3,'b');
		
		$this->centerText(31,0.9,'Selling',3,'b');
		$this->centerText(31,1.7,'Price',3,'b');
		
		$this->centerText(34,1.2,'Cost',3,'b');
		$this->centerText(37,1.2,'Profit',3,'b');
		$y=2.8;
		$this->GRID['font_size']=8;
		$total_cost = 0;
		$total_profit = 0;
		foreach($data['SaleDetail'] as $itm){
			$this->leftText(0.2,$y,$itm['Product']['name'],'','');
			$this->centerText(13,$y,$itm['delivered'],3,'');
			$this->centerText(16,$y,$itm['returned'],3,'');
			$this->centerText(19,$y,$itm['sold'],3,'');
			if($itm['delivered'] > $itm['sold']){
				$this->centerText(22,$y,'0',3,'');
				$this->centerText(25,$y,$itm['delivered']-$itm['sold'],3,'');
			}else if($itm['delivered'] < $itm['sold']){
				$this->centerText(22,$y,$itm['sold'] - $itm['delivered'],3,'');
				$this->centerText(25,$y,'0',3,'');
			}else{
				$this->centerText(22,$y,'0',3,'');
				$this->centerText(25,$y,'0',3,'');
			}
			
			$cost = $itm['Product']['purchase_price']*$itm['sold'];
			$profit = ($itm['Product']['selling_price']*$itm['sold'])-$cost;
			$total_cost+=$cost;
			$total_profit+=$profit;
			$this->rightText(27.9,$y,$itm['Product']['purchase_price'],3,'');
			$this->rightText(30.9,$y,$itm['Product']['selling_price'],3,'');
			$this->rightText(36.9,$y,number_format($cost,2),'','');
			$this->rightText(39.9,$y,number_format($profit,2),'','');
			
			$y++;
		}
		//$y++;
		$this->GRID['font_size']=12;
		//$this->centerText(0,$y,'********** END OF REPORT **********',40,'');
		$y = 39.8;
		$this->GRID['font_size']=8;
		$this->leftText(0.2,$y,'TOTAL','','b');
		$this->rightText(36.9,$y,number_format($total_cost,2),'','b');
		$this->rightText(39.9,$y,number_format($total_profit,2),'','b');
	}

}
?>
	