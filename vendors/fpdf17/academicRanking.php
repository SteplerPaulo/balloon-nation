<?php
require('formsheet.php');
class academicRanking extends Formsheet{
	protected static $_width = 5.75;
	protected static $_height = 8.5;
	protected static $_unit = 'in';
	protected static $_orient = 'P';
	protected static $_allot_subjects = 15;
	protected $info;
	function academicRanking($data=null){
		$this->data =$data;
		$this->showLines = !true;
		$this->FPDF(academicRanking::$_orient, academicRanking::$_unit,array(academicRanking::$_width,academicRanking::$_height));
		$this->createSheet();
	}
	function hdr($info){
		$this->info = $info;
		$metrics = array(
			'base_x'=> 0.23,
			'base_y'=> 0,
			'width'=> 5.29,
			'height'=> 0.8,
			'cols'=> 23,
			'rows'=> 4,
		);
		$this->section($metrics);
		$this->GRID['font_size']=15;
		$this->centerText(0,2,$info[4],23);
		$this->GRID['font_size']=9.5;
		$this->centerText(0,3,'SY '.$info['sy'] . ', '.$info['period'],23);
		$this->leftText(0,4.5,$info['yr_sec'],23);
		$this->rightText(0,4.5,'ADVISER: '.$info['adviser'],23);
		
	}
	function table($data,$start_index, $ROWS){
		$metrics = array(
			'base_x'=> 0.23,
			'base_y'=> 1,
			'width'=> 5.29,
			'height'=> 7,
			'cols'=> 23,
			'rows'=> 35,
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;
		$this->drawBox(0,0,23,35);
		$this->drawLine(2,'h');
		$this->drawLine(15,'v');
		$this->drawLine(19,'v');
		$this->leftText(0.5,1.3,'Student Name','');
		$this->centerText(15,1.3,'Rating',4);
		$this->centerText(19,1.3,'Rank',4);
		if(isset($data)){
			$line_ctr=1;
			for($ln=3.2,$index=$start_index;$index<count($data);$index++,$ln=$ln+1.2){
				if($line_ctr>=$ROWS){
					return $index;
				}
				$a = $data[$index];
				$name = utf8_decode($a[2]);
				$rate_indx =  3 +count($this->info['alias'])+2;
				$rating = $a[$rate_indx];
				$rank = $a[(count($a)-2)];
				$this->leftText(0.5,$ln,$name,'');
				$this->centerText(15,$ln,$rating,4);
				$this->centerText(19,$ln,$rank,4);
				$line_ctr++;
			}
		}
	}
	
}