<?php
require('formsheet.php');
class ReportCard extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'P';	
	protected static $curr_page = 1;
	protected static $page_count;
	
	function ReportCard(){
		$this->showLines = !true;
		$this->FPDF(ReportCard::$_orient, ReportCard::$_unit,array(ReportCard::$_width,ReportCard::$_height));
		$this->createSheet();
	}
	
	function box(){
		//$this->showLines = true;
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 0.25,
			'width'=> 8,
			'height'=> 10.5,
			'cols'=> 40,
			'rows'=> 52,	
		);	
		$this->section($metrics);
		$this->DrawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->DrawBox(0.2,0.2,$metrics['cols']-0.4,$metrics['rows']-0.4);
		$this->GRID['font_size']=7;
		$this->leftText(1,52.7,'Date Printed: '.date("F d,Y h:i:s"),'','');
	}
	
	function hdr(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 1.6,
			'width'=> 7,
			'height'=> 1.4,
			'cols'=> 35,
			'rows'=> 7,	
		);	
		$this->section($metrics);
		$y = 2;
		$this->GRID['font_size']=9;
		
		$this->leftText(0,$y,'LRN:','','b');
		$this->leftText(21,$y++,'Track/Strand:','','b');
		$this->leftText(0,$y,'Student No.:','','b');
		$this->leftText(21,$y++,'Class Adviser:','','b');
		$this->leftText(0,$y,'Student Name:','','b');
		$this->leftText(21,$y++,'Principal:','','b');
		$this->leftText(0,$y++,'Year/Section:','','b');
		
		//VALUE COl 1
		$y = 2;
		$x = 6;
		$this->leftText($x,$y++,'***','','');
		$this->leftText($x,$y++,'***','','');
		$this->leftText($x,$y++,'***','','');
		$this->leftText($x,$y++,'***','','');
		
		//VALUE COL 2
		$y = 2;
		$x = 26;
		$this->leftText($x,$y++,'***','','');
		$this->leftText($x,$y++,'***','','');
		$this->leftText($x,$y++,'***','','');
		
		
		$y=7.5;
		$this->GRID['font_size']=13;
		$this->centerText(0,$y++,'REPORT CARD',$metrics['cols'],'b');
		$this->GRID['font_size']=11;
		$this->centerText(0,$y++,'School Year: 2019 -2020',$metrics['cols'],'b');
	}
	
	function learning_areas($y=0,$sem="1st Semester"){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 3.5+$y,
			'width'=> 7,
			'height'=> 2.6,
			'cols'=> 20,
			'rows'=> 13,	
		);	
		$this->section($metrics);
		$y = 1;
		$this->GRID['font_size']=9;
		$this->DrawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->DrawLine(10,'v');
		$this->DrawLine(12,'v',array(1,$metrics['rows']-1));
		$this->DrawLine(14,'v');
		$this->DrawLine(17,'v');
		
		$this->DrawLine(2,'h');
		$this->DrawLine(1,'h',array(10,4));
		
		$this->DrawLine(14,'h',array(14,6));
		$this->DrawLine(14,'v',array(13,1));
		$this->DrawLine(20,'v',array(13,1));
		
		$this->drawMultipleLines(3,12,1,'h');
		
		$this->centerText(0,1.2,'LEARNING AREAS',10,'b');
		$this->centerText(10,0.8,$sem,4,'b');
		$this->centerText(10,1.8,'Mid Term',2,'b');
		$this->centerText(12,1.8,'Final Term',2,'b');
		$this->centerText(14,0.8,'SEMESTRAL',3,'b');
		$this->centerText(14,1.8,'GRADE',3,'b');
		$this->GRID['font_size']=8;
		$this->centerText(17,0.7,'RECOMPUTED',3,'b');
		$this->centerText(17,1.2,'FINAL',3,'b');
		$this->centerText(17,1.8,'GRADE',3,'b');
	
		$this->rightText(13.75,13.8,'GENERAL AVERAGE:','','b');
		$this->leftText(14.2,13.8,'***','','b');
	
		//VALUE
		$y=2.8;
		for($i = 1;$i<12;$i++){
			$this->leftText(0.2,$y,'Subject '.$i,10,'');
			$this->centerText(10,$y,'***',2,'');
			$this->centerText(12,$y,'***',2,'');
			$this->centerText(14,$y,'***',3,'');
			$this->centerText(17,$y,'***',3,'');
			$y++;
		}
	
	}
	
	function observed_values(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 2.3,
			'width'=> 7,
			'height'=> 2.4,
			'cols'=> 20,
			'rows'=> 12,	
		);	
		$this->section($metrics);
		$y = 1;
		$this->GRID['font_size']=10;
		$this->centerText(0,-0.5,'OBSERVED VALUES',$metrics['cols'],'b');
		
		$this->DrawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->DrawLine(3,'v');
		$this->DrawLine(16,'v');
		$this->DrawLine(17,'v',array(2,10));
		$this->DrawLine(18,'v');
		$this->DrawLine(19,'v',array(2,10));
		
		
		$this->DrawLine(2,'h',array(16,4));
		$this->DrawLine(3,'h');
		
		$this->DrawLine(4,'h',array(3,17));
		$this->DrawLine(5,'h');
		$this->DrawLine(6,'h',array(3,17));
		$this->DrawLine(7,'h');
		$this->DrawLine(8,'h');
		$this->DrawLine(10,'h',array(3,17));
		
		$this->GRID['font_size']=9;
		$this->centerText(0,1.2,'CORE',3,'b');
		$this->centerText(0,2.2,'VALUES',3,'b');
		
		$this->centerText(4,1.8,'BEHAVIOR STATEMENTS',12,'b');
		$this->centerText(16,2.8,'1',1,'b');
		$this->centerText(17,2.8,'2',1,'b');
		$this->centerText(18,2.8,'1',1,'b');
		$this->centerText(19,2.8,'2',1,'b');
		$this->GRID['font_size']=7;
		$this->centerText(16,0.8,'First',2,'b');
		$this->centerText(16,1.6,'Semester',2,'b');
		$this->centerText(18,0.8,'Second',2,'b');
		$this->centerText(18,1.6,'Semester',2,'b');
		
		$this->GRID['font_size']=8;
		$this->leftText(0.2,4,'1. Maka-Diyos','','');
		$this->leftText(0.2,6,'2. Maka-Tao','','');
		$this->leftText(0.2,7.7,'3. Makakalikasan','','');
		$this->leftText(0.2,10,'4. Makabansa','','');
		
		$y = 3.8;
		$this->leftText(3.2,$y++,'Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others','','');
		$this->leftText(3.2,$y++,'Shows adherence to ethical principles by upholding truth','','');
		$this->leftText(3.2,$y++,'Is sensitive to individual, social, and cultural differences','','');
		$this->leftText(3.2,$y++,'Demonstrate contributions toward solidarity','','');
		$this->leftText(3.2,$y++,'Cares for the environment and utilizes resources wisely, judiciously and economically','','');
		$this->leftText(3.2,$y++,'Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino','','');
		$this->leftText(3.2,$y++,'Citizen','','');
		$this->leftText(3.2,$y++,'Demonstrates appropriate behavior in carrying out activities in the school, community,','','');
		$this->leftText(3.2,$y++,'and country','','');
	
		//First Sem Value
		//Mid Term
		$this->GRID['font_size']=8;
		$x = 16;
		$this->centerText($x,4,'***',1,'');
		$this->centerText($x,5,'***',1,'');
		$this->centerText($x,6,'***',1,'');
		$this->centerText($x,7,'***',1,'');
		$this->centerText($x,8,'***',1,'');
		$this->centerText($x,9.2,'***',1,'');
		$this->centerText($x,11.2,'***',1,'');
		//Final Term
		$this->GRID['font_size']=8;
		$x = 17;
		$this->centerText($x,4,'***',1,'');
		$this->centerText($x,5,'***',1,'');
		$this->centerText($x,6,'***',1,'');
		$this->centerText($x,7,'***',1,'');
		$this->centerText($x,8,'***',1,'');
		$this->centerText($x,9.2,'***',1,'');
		$this->centerText($x,11.2,'***',1,'');
		
		
		//Second Sem Value
		//Mid Term
		$this->GRID['font_size']=8;
		$x = 18;
		$this->centerText($x,4,'***',1,'');
		$this->centerText($x,5,'***',1,'');
		$this->centerText($x,6,'***',1,'');
		$this->centerText($x,7,'***',1,'');
		$this->centerText($x,8,'***',1,'');
		$this->centerText($x,9.2,'***',1,'');
		$this->centerText($x,11.2,'***',1,'');
		//Final Term
		$this->GRID['font_size']=8;
		$x = 19;
		$this->centerText($x,4,'***',1,'');
		$this->centerText($x,5,'***',1,'');
		$this->centerText($x,6,'***',1,'');
		$this->centerText($x,7,'***',1,'');
		$this->centerText($x,8,'***',1,'');
		$this->centerText($x,9.2,'***',1,'');
		$this->centerText($x,11.2,'***',1,'');
	
	
	}
	
	function attendance(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 1,
			'width'=> 7,
			'height'=> 0.8,
			'cols'=> 17,
			'rows'=> 4,	
		);	
		$this->section($metrics);
		$y = 1;
		$this->GRID['font_size']=10;
		$this->centerText(0,-0.5,'REPORT ON ATTENDANCE',$metrics['cols'],'b');
		$this->DrawBox(0,0,$metrics['cols'],$metrics['rows']);
	
		$this->DrawLine(1,'h');
		$this->DrawLine(2,'h');
		$this->DrawLine(3,'h');
		$x=4;
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		$this->DrawLine($x++,'v');
		
		$y = 1.8;
		$this->GRID['font_size']=8;
		$this->leftText(0.2,$y++,'Days of School','','b');
		$this->leftText(0.2,$y++,'Days Present','','b');
		$this->leftText(0.2,$y++,'Days Tardy','','b');
		
		$x = 4;
		$this->centerText($x++,0.8,'Jul',1,'b');
		$this->centerText($x++,0.8,'Aug',1,'b');
		$this->centerText($x++,0.8,'Sep',1,'b');
		$this->centerText($x++,0.8,'Oct',1,'b');
		$this->centerText($x++,0.8,'Nov',1,'b');
		$this->centerText($x++,0.8,'Dec',1,'b');
		$this->centerText($x++,0.8,'Jan',1,'b');
		$this->centerText($x++,0.8,'Feb',1,'b');
		$this->centerText($x++,0.8,'Mar',1,'b');
		$this->centerText($x++,0.8,'Apr',1,'b');
		$this->centerText($x++,0.8,'May',1,'b');
		$this->centerText($x++,0.8,'Jun',1,'b');
		$this->centerText($x++,0.8,'Total',1,'b');
		
		$x = 4;
		for($i=1;$i<14;$i++){
			
			$this->centerText($x,1.8,'DS'.$i,1,'');
			$this->centerText($x,2.8,'DP'.$i,1,'');
			$this->centerText($x++,3.8,'DT'.$i,1,'');
			
		}
	}
	
	function legend(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 4.9,
			'width'=> 7,
			'height'=> 1.5,
			'cols'=> 18,
			'rows'=> 8,	
		);	
		$this->section($metrics);
		$y = 1;
		$this->GRID['font_size']=10;
		$this->DrawBox(0,0,$metrics['cols'],$metrics['rows']);
		
		$this->GRID['font_size']=7;
		$y = 1;
		$this->centerText(0,$y++,'OBSERVED VALUES:',3,'b');
		$this->centerText(0,$y++,'Marking',3,'b');
		$this->centerText(0,$y++,'AO',3,'');
		$this->centerText(0,$y++,'SO',3,'');
		$this->centerText(0,$y++,'RO',3,'');
		$this->centerText(0,$y++,'NO',3,'');
		
		$y = 2;
		$this->centerText(3,$y++,'Non-Numerical Rating',3,'b');
		$this->centerText(3,$y++,'Always Observed',3,'');
		$this->centerText(3,$y++,'Sometimes Observed',3,'');
		$this->centerText(3,$y++,'Rarely Observed',3,'');
		$this->centerText(3,$y++,'Not Observed',3,'');
		
		
		
		$y = 1;
		$this->centerText(7,$y++,'LEARNING PROGRESS AND ACHIEVEMENT:',5,'b');
		$this->leftText(8,$y++,'Description','','b');
		$this->leftText(8,$y++,'Outstanding','','');
		$this->leftText(8,$y++,'Very Satisfactory','','');
		$this->leftText(8,$y++,'Satisfactory','','');
		$this->leftText(8,$y++,'Fairly Satisfactory','','');
		$this->leftText(8,$y++,'Did Not Meet Expectation',4,'');
		
		$y = 2;
		$this->leftText(12,$y++,'Grade Scale','','b');
		$this->leftText(12,$y++,'90 - 100','','');
		$this->leftText(12,$y++,'85 - 89.99','','');
		$this->leftText(12,$y++,'80 - 84.99','','');
		$this->leftText(12,$y++,'75 - 79.99','','');
		$this->leftText(12,$y++,'Below 75','','');
		
		$y = 2;
		$this->leftText(15,$y++,'Remarks','','b');
		$this->leftText(15,$y++,'Passed','','');
		$this->leftText(15,$y++,'Passed','','');
		$this->leftText(15,$y++,'Passed','','');
		$this->leftText(15,$y++,'Passed','','');
		$this->leftText(15,$y++,'Failed','','');
	
		
	}
	
	function certificate_of_transfer(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 7.4,
			'width'=> 7,
			'height'=> 1.5,
			'cols'=> 36,
			'rows'=> 8,	
		);	
		$this->section($metrics);
		$y = 1;
		$this->GRID['font_size']=12;
		$this->centerText(0,1,'CERTIFICATE OF TRANSFER',36,'b');
		$this->GRID['font_size']=10;
		$this->rightText(16,3,'LUNA, DESIREE M.','','b');
		$this->leftText(15,3,'is eligible for transfer and admission to','','');
		$this->DrawLine(4,'h',array(3,7));
		
		$this->leftText(8,6,'Issued this 27th day of February 2020.','','');
		
		
		$this->centerText(24,10,'VISIMAR C. MORRES',8,'b');
		$this->centerText(24,11,'Registrar',8,'');
	}
	
	
	function nodata(){
		$metrics = array(
			'base_x'=> 0,
			'base_y'=> 0,
			'width'=> 8.5,
			'height'=> 11,
			'cols'=> 4,
			'rows'=> 3,	
		);	
		$this->section($metrics);
		$y = 1;
		$this->GRID['font_size']=16;
		$this->centerText(0,1,'NO DATA AVAILABLE',$metrics['cols'],'b');
	}
	
}
?>
	