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
		$this->leftText(0,$y,'Customer:','','b');
		$this->leftText(4,$y,$data['Customer']['name'],'','');
		$this->leftText(20,$y,'Date:','','b');
		$this->leftText(22,$y++,date("M d", strtotime($data['Sale']['from_date'])).' - '.date("d, Y", strtotime($data['Sale']['to_date'])),'','');
		//$this->leftText(0,$y,'Posted:','','b');
		//$this->leftText(3,$y,($data['Sale']['is_posted'] == 1)?'True':'False','','');
	}
	
	function dtls($data,$page){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 1.8,
			'width'=> 8,
			'height'=> 8.8,
			'cols'=> 43,
			'rows'=> 44,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=8;
		$this->drawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->drawMultipleLines(3,43,1,'h');
		$this->drawLine(2,'h');
		$this->drawLine(13,'v',array(0,$metrics['rows']-1));
		$this->drawLine(15,'v',array(0,$metrics['rows']-1));
		$this->drawLine(17,'v',array(0,$metrics['rows']-1));
		$this->drawLine(19,'v',array(0,$metrics['rows']-1));
		$this->drawLine(21,'v',array(0,$metrics['rows']-1));
		$this->drawLine(24,'v',array(0,$metrics['rows']-1));
		$this->drawLine(27,'v',array(0,$metrics['rows']-1));
		$this->drawLine(29,'v',array(0,$metrics['rows']-1));
		$this->drawLine(31,'v',array(0,$metrics['rows']-1));
		$this->drawLine(34,'v',array(0,$metrics['rows']-1));
		$this->drawLine(37,'v');
		$this->drawLine(40,'v');
		$y=1;
		$this->centerText(0,1.2,'Item Description',10,'b');
		
		
		$this->centerText(13,0.9,'Beg.',2,'');
		$this->centerText(13,1.8,'Inv.',2,'');
		
		$this->centerText(15,1.8,'Del.',2,'');
		$this->centerText(17,1.8,'Ret.',2,'');
		$this->centerText(19,1.8,'Sold',2,'');
		
		
		$this->centerText(21,0.9,'Ending',3,'');
		$this->centerText(21,1.8,'Inventory',3,'');
		
		$this->centerText(24,0.9,'Actual',3,'');
		$this->centerText(24,1.8,'Count',3,'');
		
		
		$this->centerText(27,0.9,'Over',2,'');
		$this->centerText(27,1.8,'Sold',2,'');
		
		$this->centerText(29,0.9,'Mis.',2,'');
		$this->centerText(29,1.8,'Qty',2,'');
		
		
		$this->centerText(31,0.9,'Purchase',3,'');
		$this->centerText(31,1.7,'Price',3,'');
		
		$this->centerText(34,0.9,'Selling',3,'');
		$this->centerText(34,1.7,'Price',3,'');
		
		$this->centerText(37,1.2,'Cost',3,'');
		$this->centerText(40,1.2,'Profit',3,'');
		$y=2.8;
		$this->GRID['font_size']=8;
		$total_cost = 0;
		$total_profit = 0;
		foreach($data as $itm){
			//pr($itm);
			if(!empty($itm['Product'])){
				//($itm['']!=0)?$itm['']:'--'
				$this->leftText(0.2,$y,$itm['Product']['name'],'','');
				$this->centerText(13,$y,$itm['beginning_inventory'],2,'');
				$this->centerText(15,$y,($itm['delivered']!=0)?$itm['delivered']:'--',2,'');
				$this->centerText(17,$y,($itm['returned']!=0)?$itm['returned']:'--',2,'');
				$this->centerText(19,$y,($itm['sold']!=0)?$itm['sold']:'--',2,'');
				$this->centerText(21,$y,$itm['ending_inventory'],3,'');
				//$this->centerText(24,$y,$itm['Product']['beginning_inventory'],3,'');
				$this->centerText(24,$y,$itm['actual_inventory'],3,'');
				$this->centerText(27,$y,($itm['over_sold']!=0)?$itm['over_sold']:'--',2,'');
				$this->centerText(29,$y,($itm['missing_qty']!=0)?$itm['missing_qty']:'--',2,'');
		
				
				$cost = $itm['Product']['purchase_price']*$itm['sold'];
				$profit = ($itm['Product']['selling_price']*$itm['sold'])-$cost;
				$total_cost+=$cost;
				$total_profit+=$profit;
				$this->rightText(30.9,$y,$itm['Product']['purchase_price'],3,'');
				$this->rightText(33.9,$y,$itm['Product']['selling_price'],3,'');
				$this->rightText(39.9,$y,number_format($cost,2),'','');
				$this->rightText(42.9,$y,number_format($profit,2),'','');
				
				$y++;
			}
		}
		//$y++;
		$this->GRID['font_size']=12;
		//$this->centerText(0,$y,'********** END OF REPORT **********',40,'');
		$y = 43.8;
		$this->GRID['font_size']=8;
		$this->rightText(36.7,$y,'PAGE '.$page.' TOTAL','','b');
		$this->rightText(39.9,$y,number_format($total_cost,2),'','b');
		$this->rightText(42.9,$y++,number_format($total_profit,2),'','b');
		$this->leftText(0,$y,'Page '.$page,'','b');
	}

}
?>
	