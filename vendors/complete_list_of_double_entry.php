<?php
require('formsheet.php');
class CompleteListOfDoubleEntry extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'P';	
	protected static $curr_page = 1;
	protected static $page_count;
	
	function CompleteListOfDoubleEntry(){
		$this->showLines = !true;
		$this->FPDF(CompleteListOfDoubleEntry::$_orient, CompleteListOfDoubleEntry::$_unit,array(CompleteListOfDoubleEntry::$_width,CompleteListOfDoubleEntry::$_height));
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
		$this->GRID['font_size']=11;
		$y=1;
		$this->centerText(0,$y++,'Balloon Republic General Merchandise',$metrics['cols'],'b');
		$y++;
		$this->GRID['font_size']=14;
		$this->centerText(0,$y++,'Complete List of Double Entry',$metrics['cols'],'b');
		
	
	}
	
	function dtls($data){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 1,
			'width'=> 8,
			'height'=> 9.6,
			'cols'=> 14,
			'rows'=> 48,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=8;
		$this->drawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->drawMultipleLines(3,48,1,'h');
		$this->drawLine(1,'h',array(0,12));
		$this->drawLine(2,'h');
		$this->drawLine(1,'v',array(1,$metrics['rows']-1));
		$this->drawLine(6,'v');
		$this->drawLine(7,'v',array(1,$metrics['rows']-1));
		$this->drawLine(12,'v');
	
		$y=1;
		$this->leftText(0.2,0.8,'CUSTOMERS','','b');
		$this->centerText(0,1.8,'C.ID',1,'b');
		$this->centerText(1,1.8,'NAME',5,'b');
		
		$this->leftText(6.2,0.8,'PRODUCTS','','b');
		$this->centerText(6,1.8,'P.ID',1,'b');
		$this->centerText(7,1.8,'DESCRIPTION',5,'b');
		
		$this->centerText(12,1.2,'Remarks',2,'b');
		
		$y=2.8;
		$i=1;
		$total = 0;
		foreach($data as $d){
			$this->centerText(0,$y,$d['customers']['id'],1,'');
			$this->centerText(1,$y,$d['customers']['name'],5,'');
			
			$this->centerText(6,$y,$d['product']['id'],1,'');
			$this->centerText(7,$y,$d['product']['name'],5,'');
			$y++;
			
		}
		
	}

}
?>
	