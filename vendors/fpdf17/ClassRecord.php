<?php
include('RawScoreSheet.php');
include('../header.php');
include('../curriculum.php');
session_start();
$CURRI->db_connect();
$EGB->db_connect();				//Open database connection
		$info = json_decode($_POST['info'], true);
		$rs = json_decode($_POST['rawscores'], true);
		$sm = json_decode($_POST['summary'], true);
		$classcode = $info['classcode'];
		$code =  explode("-",$classcode);
		$seccode = $code[0];
		$compcode  = $code[1];
		$classtype  =isset($code[2])?$code[2]:'null';	
		if($classtype=='null'){
			$classtype =null;
		}
		$sy = (int)$info['sy'];
		$period = (int)$info['period'];
		$level =(int)$info['level'];
		$deptcode = $info['dept'];
		$teacher = strtoupper($info['teacher']);
		$subj_nomen = $EGB->get_sub_nomen($compcode);
		$sec = $EGB->get_sec_alias($seccode);
		$section = $sec[0]['dept'].' '.$sec[0]['level'].' - '.$sec[0]['section'];
		if($sec[0]['dept']=='PS'){
			$deptalias = 'PRE SCHOOL DEPARTMENT';
		}else if($sec[0]['dept']=='GS'){
			$deptalias = 'GRADE SCHOOL DEPARTMENT';
		}else if($sec[0]['dept']=='HS'){
			$deptalias = 'HIGH SCHOOL DEPARTMENT';
		}
		$version =1;
		$components_rec = $EGB->get_components_rec($compcode,$seccode,$sy, $period,$classtype);
		$items = $EGB->get_components();
		$index = 0;
		if($components_rec!=null){
			foreach($components_rec as $component){
				foreach($items as $item){
					if($item['code']==$component['ccode']){
						$components_rec[$index]['desc'] = $item['desc'];
					}
				}
				$index+=1;			
			}
		}
		$measurables = $EGB->get_measurables_rec($compcode,$seccode,$sy, $period,$classtype);
		
		for($j=0; $j<count($measurables); $j++){
			for($i=0; $i<count($components_rec); $i++){
				if($components_rec[$i]['ccode']==$measurables[$j]['ccode']){
					if(isset($components_rec[$i]['count'])){
						$components_rec[$i]['count']+=1;
					}else{
						$components_rec[$i]['count']=1;
					}
				}
			}
		}
	$rawscoresheet= new RawScoreSheet('L','in',array(14.00,8.5));
	$rawscoresheet->SetLineWidth(0.00001);
	$next_index = 0;
	$g_flg ='';
	$i=0;
	$ROWS = 30;
	$COLS = count($measurables)+(2 * count($components_rec) ) + 2;

	$FONT_SIZE  = $COLS<15? 17 : round(100/($COLS*0.40));
	//$students =  $EGB->get_stud_nrol($compcode, $seccode, $sy);
	$students =  $CURRI->get_stud_nrol($compcode, $seccode, $sy, $classtype);
	/*$students_late =  $EGB->get_stud_nrol_late($compcode, $seccode, $sy);

	foreach($students_late as $late_student){
		array_push($students, $late_student);
	}*/
	$total_page = ceil((count($students)+5)/$ROWS);
	while ($i<$total_page){
		$rawscoresheet->create($teacher,$sy,$section,$deptalias,$subj_nomen,$period, $i+1, $total_page);
		$rawscoresheet->DrawRectangle();
		$h_lines=$rawscoresheet->DrawHorLines(0.30,1.00,13.70,1.00,6.30,$ROWS);
		$v_lines=$rawscoresheet->DrawVerLines(2.40,1.00,2.40,7.29,11.30,$COLS);
		$grades=array();
		$rawscoresheet->SetFont('Arial','',10); 
		$rawscoresheet->PlotGrades($grades,$h_lines,$v_lines,0.30,0.10);
		$rawscoresheet->SetFillColor(255); 
		$cellwidth = 11.30/$COLS;
		$cellheight = 6.30/($ROWS+1);
		$col_hdrs = $rawscoresheet->PlotColHeaders($measurables, $components_rec, $v_lines, $h_lines, $cellwidth, $cellheight,false,$FONT_SIZE);
		if(count($students) % 25 < 5){
			$ROW_CTR = $ROWS - 2;
		}else{
			$ROW_CTR = $ROWS;
		}
		$next_index =  $rawscoresheet->PlotStudents($students, 0.35, $h_lines, 2.00, $cellheight,0.01,$rs,$sm, $components_rec,$v_lines,$col_hdrs,$cellwidth,$cellheight, false, $next_index , $g_flg, $FONT_SIZE,$ROW_CTR);
		$g_flg ='';
		$i++;
	}	
	$EGB->add_log($_SESSION['faculty_id'], 'prntclsrec'.$seccode.$compcode, $_SERVER['REMOTE_ADDR'], time());	
	$rawscoresheet->output();
?>