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
	}
	
	function hdr(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 0.75,
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
		
		
		$y=6.5;
		$this->GRID['font_size']=13;
		$this->centerText(0,$y++,'REPORT CARD',$metrics['cols'],'b');
		$this->GRID['font_size']=11;
		$this->centerText(0,$y++,'School Year: 2019 -2020',$metrics['cols'],'b');
	}
	
	function learning_areas(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 2.3,
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
		$this->centerText(10,0.8,'1st Semester',4,'b');
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
			'base_y'=> 5.5,
			'width'=> 7,
			'height'=> 2.2,
			'cols'=> 20,
			'rows'=> 11,	
		);	
		$this->section($metrics);
		$y = 1;
		$this->GRID['font_size']=10;
		$this->centerText(0,-0.5,'OBSERVED VALUES',$metrics['cols'],'b');
		
		$this->DrawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->DrawLine(3,'v');
		$this->DrawLine(16,'v');
		$this->DrawLine(18,'v',array(1,10));
		
		
		$this->DrawLine(1,'h',array(16,4));
		$this->DrawLine(2,'h');
		
		$this->DrawLine(3,'h',array(3,17));
		$this->DrawLine(4,'h');
		$this->DrawLine(5,'h',array(3,17));
		$this->DrawLine(6,'h');
		$this->DrawLine(7,'h');
		$this->DrawLine(9,'h',array(3,17));
		
		$this->GRID['font_size']=9;
		$this->centerText(0,0.9,'CORE',3,'b');
		$this->centerText(0,1.7,'VALUES',3,'b');
		
		$this->centerText(3,1.2,'BEHAVIOR STATEMENTS',15,'b');
		$this->centerText(16,1.8,'Mid Term',2,'b');
		$this->centerText(18,1.8,'Final Term',2,'b');
		$this->GRID['font_size']=7;
		$this->centerText(16,0.8,'1st Semester',4,'b');
		
		$this->GRID['font_size']=8;
		$this->leftText(0.2,3,'1. Maka-Diyos','','');
		$this->leftText(0.2,5,'2. Maka-Tao','','');
		$this->leftText(0.2,6.7,'3. Makakalikasan','','');
		$this->leftText(0.2,9,'4. Makabansa','','');
		
		$y = 2.8;
		$this->leftText(3.2,$y++,'Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others','','');
		$this->leftText(3.2,$y++,'Shows adherence to ethical principles by upholding truth','','');
		$this->leftText(3.2,$y++,'Is sensitive to individual, social, and cultural differences','','');
		$this->leftText(3.2,$y++,'Demonstrate contributions toward solidarity','','');
		$this->leftText(3.2,$y++,'Cares for the environment and utilizes resources wisely, judiciously and economically','','');
		$this->leftText(3.2,$y++,'Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino','','');
		$this->leftText(3.2,$y++,'Citizen','','');
		$this->leftText(3.2,$y++,'Demonstrates appropriate behavior in carrying out activities in the school, community,','','');
		$this->leftText(3.2,$y++,'and country','','');
	
		//VALUE 1st Semester
		$this->GRID['font_size']=8;
		$x = 16;
		$this->centerText($x,3,'***',2,'');
		$this->centerText($x,4,'***',2,'');
		$this->centerText($x,5,'***',2,'');
		$this->centerText($x,6,'***',2,'');
		$this->centerText($x,7,'***',2,'');
		$this->centerText($x,8.2,'***',2,'');
		$this->centerText($x,10.2,'***',2,'');
		
		//VALUE 2nd Semester
		$this->GRID['font_size']=8;
		$x = 18;
		$this->centerText($x,3,'***',2,'');
		$this->centerText($x,4,'***',2,'');
		$this->centerText($x,5,'***',2,'');
		$this->centerText($x,6,'***',2,'');
		$this->centerText($x,7,'***',2,'');
		$this->centerText($x,8.2,'***',2,'');
		$this->centerText($x,10.2,'***',2,'');
	
	}
	
	function attendance(){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.75,
			'base_y'=> 8,
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
		$this->centerText(0,$y++,'Days of School',4,'b');
		$this->centerText(0,$y++,'Days Present',4,'b');
		$this->centerText(0,$y++,'Days Tardy',4,'b');
		
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
			'base_y'=> 9,
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
		$this->centerText(3,$y++,'Always Observed',3,'b');
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
		
	
		$this->GRID['font_size']=7;
		$this->centerText(0,9,'"That in all things GOD may be glorified"',$metrics['cols'],'bi');
		$this->leftText(-1.2,10,'Date Printed:','','');
		
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
	