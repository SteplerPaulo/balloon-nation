<?php
include('RawScoreSheet.php');
include('../header.php');
include('../curriculum.php');
session_start();
$CURRI->db_connect();
$EGB->db_connect();				//Open database connection
		$info = json_decode($_REQUEST['info'], true);
		$sm=null;
		$rs = json_decode($_REQUEST['overall'], true);
		//average
		for($x =0;$x<count($rs);$x++){
			$ave = 0;
			$base = 1;
			$psum =0;
			if($rs[$x]['grades'][4]==''){
				if($rs[$x]['grades'][0]!=''&&$rs[$x]['grades'][1]!=''&&$rs[$x]['grades'][2]!=''&&$rs[$x]['grades'][3]!=''){
					$base = 4;
				}else if($rs[$x]['grades'][0]!=''&&$rs[$x]['grades'][1]!=''&&$rs[$x]['grades'][2]!=''&&$rs[$x]['grades'][3]==''){
					$base = 3;
				}else if($rs[$x]['grades'][0]!=''&&$rs[$x]['grades'][1]&&$rs[$x]['grades'][2]==''&&$rs[$x]['grades'][3]==''){
					$base = 2;
				}else if($rs[$x]['grades'][0]!=''&&$rs[$x]['grades'][1]==''&&$rs[$x]['grades'][2]==''&&$rs[$x]['grades'][3]==''){
					$base = 1;
				}
				$psum =$rs[$x]['grades'][0]+$rs[$x]['grades'][1]+$rs[$x]['grades'][2]+$rs[$x]['grades'][3];
				$ave = $psum/$base;
				$rs[$x]['grades'][4]=number_format($ave,2,'.','');
			}
		}
		//echo "<pre>";print_r($rs);exit();
		$hd = array('First', 'Second', 'Third', 'Fourth', 'Average');
		$tp = array(array ( 'desc' => 'Grade Sheet', 'count' => 5 ));
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
		$teacher = utf8_decode(strtoupper($info['teacher']));
		$head_flg = 0;
		if($head_flg==0){
			$subj_nomen = $EGB->get_sub_nomen($compcode);
		}
		$sec = $EGB->get_sec_alias($seccode);
		$section = $sec[0]['dept'].' '.$sec[0]['level'].' - '.$sec[0]['section'];
		if($sec[0]['dept']=='PS'){
			$deptalias = 'PRE SCHOOL DEPARTMENT';
			if($head_flg){
				$subj_nomen = 'Character Traits';
			}
		}else if($sec[0]['dept']=='GS'){
			$deptalias = 'GRADE SCHOOL DEPARTMENT';
			if($head_flg){
				$subj_nomen = 'Character Traits';
			}
		}else if($sec[0]['dept']=='HS'){
			$deptalias = 'HIGH SCHOOL DEPARTMENT';
			if($head_flg){
				$subj_nomen = 'Co-Curricular';
			}
		}
	$rawscoresheet= new RawScoreSheet('P','in',array(13.00,8.5));
	$rawscoresheet->SetLineWidth(0.00001);
	$next_index = 0;
	$g_flg ='';
	$i=0;
	$ROWS = 40;
	$COLS = count($hd)+ count($tp);

	$FONT_SIZE  = $COLS<15? 12 : round(100/($COLS*0.40));
	//$students =  $EGB->get_stud_nrol($compcode, $seccode, $sy);
	$students =  $CURRI->get_stud_nrol($compcode, $seccode, $sy, $classtype);
	/*	$students_late =  $EGB->get_stud_nrol_late($compcode, $seccode, $sy);
	foreach($students_late as $late_student){
		array_push($students, $late_student);
	}
	*/
	$total_page = ceil((count($students)+5)/$ROWS);
	while ($i<$total_page){
		$rawscoresheet->create($teacher,$sy,$section,$deptalias,$subj_nomen,$period, $i+1, $total_page,1);
		$rawscoresheet->DrawRectangle(10.50,7.90);
		$h_lines=$rawscoresheet->DrawHorLines(0.30,1.00,8.20,1.00,10.50,$ROWS);
		$v_lines=$rawscoresheet->DrawVerLines(2.80,1.00,2.80,11.49,6.50,$COLS);
		$grades=array();
		$rawscoresheet->SetFont('Arial','',10); 
		$rawscoresheet->PlotGrades($grades,$h_lines,$v_lines,0.30,0.10);
		$rawscoresheet->SetFillColor(255); 
		$cellwidth = 6.50/$COLS;
		$cellheight = 10.50/($ROWS+1);
		$col_hdrs = $rawscoresheet->PlotColHeaders($hd, $tp, $v_lines, $h_lines, $cellwidth, $cellheight,true,$FONT_SIZE);
		if(count($students) % 25 < 5){
			$ROW_CTR = $ROWS - 2;
		}else{
			$ROW_CTR = $ROWS;
		}
		$next_index =  $rawscoresheet->PlotStudents($students, 0.35, $h_lines, 4.00, $cellheight,0.01,$rs,$sm, $tp,$v_lines,$col_hdrs,$cellwidth,$cellheight, true, $next_index , $g_flg, $FONT_SIZE,$ROW_CTR,true);
		$g_flg ='';
		$i++;
	}	

	$rawscoresheet->output();
?>