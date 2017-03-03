<?php
include('RawScoreSheet.php');
include('../header.php');
error_reporting(0);
$EGB->db_connect();				//Open database connection
		$info = json_decode($_REQUEST['info'], true);
		$sm=null;
		$rs = json_decode($_REQUEST['dataset'], true);
		$sbjs = json_decode($_REQUEST['alias'], true);
		$mos = json_decode($_REQUEST['months'], true);
		$raw=array();
		$rank_index = count($rs[0])-2;
		for($indx=0;$indx<count($rs);$indx++){
			$r=$rs[$indx];
			$obj =  array();
			//Rank fix
			$r[count($sbjs)+6]=$r[$rank_index];
			$obj['fullname']=$r[2];
			$obj['gender']=$r[0];
			$obj['status']=null;
			$obj['grades']=array();
			for($i=3;$i<count($r);$i++){
				if($i!=count($sbjs)+3){
					array_push($obj['grades'],$r[$i]);
				}
			}
			array_push($raw,$obj);
		}
		$rs= $raw;
		$hd = array();
		$disp_flg = array();
		foreach($sbjs  as $s){
			array_push($hd,$s);
			array_push($disp_flg,0);
		}
		array_push($hd,'Period');
		array_push($hd,'Cumm');
		array_push($hd,'Rank');
		array_push($disp_flg,0);
		$tp = array(array ( 'desc' => $info[4], 'count' => count($hd)));
		
		$sy = $info[0];
		$period = $info[1];
		$teacher = strtoupper($info[3]);		
		$section = $info[5];
		
		$subj_nomen = ' ';
	
	$rawscoresheet= new RawScoreSheet('L','in',array(14.00,8.5));
	$rawscoresheet->SetLineWidth(0.00001);
	$next_index = 0;
	$g_flg ='';
	$i=0;
	$ROWS = 30;
	$COLS = (count($hd)-1)+ count($tp);

	$FONT_SIZE  = $COLS<18? 12 : round(100/($COLS*0.50));
	$students = array();
	if($period=='FINAL GRADING'){
		$FONT_SIZE  = $COLS<12? 12 : round(100/($COLS*0.76));
	}
	
	foreach($rs  as $stud){
	$s =array();
		$s['fullname']=$stud['fullname'];
		$s['gender']=$stud['gender'];
		$s['status']=$stude['status'];
		array_push($students,$s);
	}

	$total_page = ceil((count($students)+5)/$ROWS);
	while ($i<$total_page){
		$rawscoresheet->create($teacher,$sy,$section,$deptalias,$subj_nomen,$period, $i+1, $total_page);
		$rawscoresheet->DrawRectangle();
		$h_lines=$rawscoresheet->DrawHorLines(0.30,1.00,13.70,1.00,6.30,$ROWS);
		$v_lines=$rawscoresheet->DrawVerLines(2.40,1.00,2.40,7.29,11.30,$COLS);
		$rawscoresheet->SetFont('Arial','',10); 
		
		$rawscoresheet->SetFillColor(255); 
		$cellwidth = 11.30/$COLS;
		$cellheight = 6.30/($ROWS+1);
		$col_hdrs = $rawscoresheet->PlotColHeaders($hd, $tp, $v_lines, $h_lines, $cellwidth, $cellheight,true,$FONT_SIZE,$disp_flg);
		if(count($students) % 25 < 5){
			$ROW_CTR = $ROWS - 2;
		}else{
			$ROW_CTR = $ROWS;
		}
		$next_index =  $rawscoresheet->PlotStudents($students, 0.35, $h_lines, 2.00, $cellheight,0.01,$rs,$sm, $tp,$v_lines,$col_hdrs,$cellwidth,$cellheight, true, $next_index , $g_flg, $FONT_SIZE,$ROW_CTR,false,$disp_flg);
		$g_flg ='';
		$i++;
	}	

	$rawscoresheet->output();
?>