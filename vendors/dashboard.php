<?php
require('formsheet.php');
class Dashboard extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'P';	
	protected static $over_all_estimated_cost;
	protected static $over_all_projected_revenue;
	
	function Dashboard(){
		$this->showLines = !true;
		$this->FPDF(Dashboard::$_orient, Dashboard::$_unit,array(Dashboard::$_width,Dashboard::$_height));
		$this->createSheet();
	}
	
	function hdr($year){
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
		$this->leftText(0,$y,'Projected Revenue for Year '.$year,'','b');
		//$this->leftText(4,$y,$data['Customer']['name'],'','');
		//$this->leftText(20,$y,'Date:','','b');
		//$this->leftText(22,$y++,date("M d", strtotime($data['Sale']['from_date'])).' - '.date("d, Y", strtotime($data['Sale']['to_date'])),'','');
	}
	
	function data($data,$page,$total_page){
		$this->showLines = !true;
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 1.8,
			'width'=> 8,
			'height'=> 8.8,
			'cols'=> 46,
			'rows'=> 44,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=8;
		$this->drawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->drawMultipleLines(3,43,1,'h');
		$this->drawLine(2,'h');
		//$this->drawLine(13,'v',array(0,$metrics['rows']-1));
		$this->drawLine(24,'v',array(0,$metrics['rows']-1));
		$this->drawLine(28,'v',array(0,$metrics['rows']-1));
		$this->drawLine(32,'v',array(0,$metrics['rows']-1));
		$this->drawLine(36,'v');
		$this->drawLine(41,'v');
		
		$y=1;
		$this->centerText(0,1.2,'Item Description',13,'b');
		
		$this->centerText(24,0.9,'Delivered',4,'b');
		$this->centerText(24,1.7,'Qty',4,'b');
		
		$this->centerText(28,0.9,'Purchase',4,'b');
		$this->centerText(28,1.7,'Price',4,'b');
		
		$this->centerText(32,0.9,'Selling',4,'b');
		$this->centerText(32,1.7,'Price',4,'b');
		
		$this->centerText(36,0.9,'Estimated',5,'b');
		$this->centerText(36,1.7,'Cost',5,'b');
		
		$this->centerText(41,0.9,'Projected',5,'b');
		$this->centerText(41,1.7,'Revenue',5,'b');
		
		$y=2.8;
		$this->GRID['font_size']=8;
		$total_cost = 0;
		$total_profit = 0;
		foreach($data as $d){
			if(!empty($d['products'])){
				$this->leftText(0.2,$y,$d['products']['name'],'','');
				$this->centerText(24,$y,$d[0]['total_qty_delivered'],4,'');
				//$this->centerText(26,$y,$d[0]['no_of_times_delivered'],4,'');
				$this->rightText(31.9,$y,$d['delivery_details']['purchase_price'],'','');
				$this->rightText(35.9,$y,$d['delivery_details']['selling_price'],'','');
			
				$cost = $d['delivery_details']['purchase_price']*$d[0]['total_qty_delivered'];
				$profit = ($d['delivery_details']['selling_price']*$d[0]['total_qty_delivered'])-$cost;
				$total_cost+=$cost;
				$total_profit+=$profit;
				$this->rightText(40.9,$y,number_format($cost,2),'','');
				$this->rightText(45.9,$y,number_format($profit,2),'','');
				Dashboard::$over_all_estimated_cost+=$cost;
				Dashboard::$over_all_projected_revenue+=$profit;
				$y++;
			}
		} 
		$this->GRID['font_size']=12;
		//$this->centerText(0,$y,'********** END OF REPORT **********',40,'');
		$y = 43.8;
		$this->GRID['font_size']=8;
		$this->rightText(35.7,$y,'PAGE '.$page.' TOTAL','','b');
		$this->rightText(40.9,$y,number_format($total_cost,2),'','b');
		$this->rightText(45.9,$y++,number_format($total_profit,2),'','b');
		$this->leftText(0,$y,'Page '.$page.' of '. $total_page,'','');
		
		if($page == $total_page){
			$this->rightText(35.7,$y,'OVERALL TOTAL','','b');
			$this->rightText(40.9,$y,number_format(Dashboard::$over_all_estimated_cost,2),'','b');
			$this->rightText(45.9,$y,number_format(Dashboard::$over_all_projected_revenue,2),'','b');
		}
	}

}
?>
	