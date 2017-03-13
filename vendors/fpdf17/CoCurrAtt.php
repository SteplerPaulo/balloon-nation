<?php
include('RawScoreSheet.php');
include('../header.php');
error_reporting(0);
$EGB->db_connect();				//Open database connection
		$info = json_decode($_REQUEST['info'], true);
		$sm=null;
		$rs = json_decode($_REQUEST['rawscores'], true);
		//print_r($rs);exit();
		$hd = json_decode($_REQUEST['headers'], true);
		$tp = json_decode($_REQUEST['toppers'], true);
		$classcode = $info['classcode'];
		$code =  explode("-",$classcode);
		$seccode = $code[0];
		$compcode  = $code[1];
		$sy = (int)$info['sy'];
		$period = (int)$info['period'];
		$level =(int)$info['level'];
		$deptcode = $info['dept'];
		$load = $info['load'];
		$teacher = strtoupper($info['teacher']);
		$head_flg = $info['heading']=='tbCoCurr'?1:0;
		if($head_flg==0){
			$subj_nomen = 'Attendance';
		}
		//$sec = $EGB->get_sec_alias($seccode);
		//$section = $sec[0]['dept'].' '.$sec[0]['level'].' - '.$sec[0]['section'];
		if($deptcode=='PS'){
			$deptalias = 'PRE SCHOOL DEPARTMENT';
			if($head_flg){
				$subj_nomen = 'Character Traits';
			}
		}else if($deptcode=='GS'){
			$deptalias = 'GRADE SCHOOL DEPARTMENT';
			if($head_flg){
				$subj_nomen = 'Character Traits';
			}
		}else if($deptcode=='HS'){
			$deptalias = 'HIGH SCHOOL DEPARTMENT';
			if($head_flg){
				$subj_nomen = 'Co-Curricular';
			}
		}
		
		$load =  $load . ' '.$subj_nomen;
	$rawscoresheet= new RawScoreSheet('L','in',array(14.00,8.5));
	$rawscoresheet->SetLineWidth(0.00001);
	$next_index = 0;
	$g_flg ='';
	$i=0;
	$ROWS = 30;
	$COLS = count($hd)+ count($tp)  + 2;
	$FONT_SIZE  = $COLS<15? 12 : round(100/($COLS*0.40));
	$students =  $EGB->get_stud_nrol($compcode, $seccode, $sy);
	$students_late =  $EGB->get_stud_nrol_late($compcode, $seccode, $sy);
	foreach($students_late as $late_student){
		array_push($students, $late_student);
	}
	$total_page = ceil((count($students)+5)/$ROWS);
	while ($i<$total_page){
		$rawscoresheet->create($$teacher,$sy,$load,$deptalias,$period,$i+1, $total_page);
		$rawscoresheet->DrawRectangle();
		$h_lines=$rawscoresheet->DrawHorLines(0.30,1.00,13.70,1.00,6.30,$ROWS);
		$v_lines=$rawscoresheet->DrawVerLines(2.40,1.00,2.40,7.29,11.30,$COLS);
		$grades=array();
		$rawscoresheet->SetFont('Arial','',10); 
		$rawscoresheet->PlotGrades($grades,$h_lines,$v_lines,0.30,0.10);
		$rawscoresheet->SetFillColor(255); 
		$cellwidth = 11.30/$COLS;
		$cellheight = 6.30/($ROWS+1);
		$col_hdrs = $rawscoresheet->PlotColHeaders($hd, $tp, $v_lines, $h_lines, $cellwidth, $cellheight,true,$FONT_SIZE);
		if(count($students) % 25 < 5){
			$ROW_CTR = $ROWS - 2;
		}else{
			$ROW_CTR = $ROWS;
		}
		$next_index =  $rawscoresheet->PlotStudents($students, 0.35, $h_lines, 2.00, $cellheight,0.01,$rs,$sm, $tp,$v_lines,$col_hdrs,$cellwidth,$cellheight, true, $next_index , $g_flg, $FONT_SIZE,$ROW_CTR);
		$g_flg ='M';
		$i++;
	}	
	$rawscoresheet->output();
?>