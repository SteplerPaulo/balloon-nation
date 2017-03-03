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
	
	function hdr(){
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
		
	}
	
	function dtls(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 1.5,
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
		$this->drawLine(1,'h',array(16,18));
		$this->drawLine(16,'v');
		$this->drawLine(19,'v',array(1,$metrics['rows']-1));
		$this->drawLine(22,'v',array(1,$metrics['rows']-1));
		$this->drawLine(25,'v',array(1,$metrics['rows']-1));
		$this->drawLine(28,'v');
		$this->drawLine(31,'v',array(1,$metrics['rows']-1));
		$this->drawLine(34,'v');
		$this->drawLine(37,'v');
		$y=1;
		$this->centerText(0.2,1.2,'Item',16,'b');
		
		$this->centerText(16,0.8,'Quantity',12,'b');
		$this->centerText(16,1.8,'Delivered',3,'');
		$this->centerText(19,1.8,'Returned',3,'');
		$this->centerText(22,1.8,'Current',3,'');
		$this->centerText(25,1.8,'Missing',3,'');
		
		$this->centerText(28,0.8,'Sale',6,'b');
		$this->centerText(28,1.8,'S.C',3,'');
		$this->centerText(31,1.8,'Actual',3,'');
		
		
		$this->centerText(34,1.2,'Cost',3,'b');
		$this->centerText(37,1.2,'Profit',3,'b');
	
	}

}
?>
	