<?php
include_once('../header.php');
include_once('../promote.php');
include_once('ReportCard.php');

set_time_limit ( 390 );
function arraySwap($arr, $src, $dst){
	$tmp = $arr[$dst];
	$arr[$dst] = $arr[$src];
	$arr[$src] = $tmp;
	return $arr; 
}
$PROMOTE->db_connect();
$EGB->db_connect();
	$sno = isset($_REQUEST['prnt_sno'])?$_REQUEST['prnt_sno']:null;
	$classcode= isset($_REQUEST['prnt_classcode'])?$_REQUEST['prnt_classcode']:null;
	$sy =isset($_REQUEST['prnt_sy'])?$_REQUEST['prnt_sy']:null;
	$period = isset($_REQUEST['prnt_period'])?$_REQUEST['prnt_period']:null;
	if($period==4){
		$period=5;
	}
	$mode =  isset($_REQUEST['prnt_mode'])?$_REQUEST['prnt_mode']:null;
	if($classcode!=0){
		$classcode =$_POST['prnt_classcode'];
	}else{
		$classcode = $EGB->get_nrol_section($sno);
	}
	if($sno){
		$sno = $_POST['prnt_sno'];
	}
	$code =  explode("-",$classcode);
	$compcode ='';
	$version=1;
	
	$report_card = new ReportCard('P','in',array(8.5,11));
	for($a=0;$a<count($code);$a++){
		 $seccode=$code[$a];
		if($seccode!=null&& $seccode!=''){
			if($mode=='batch'){
				$sno=null;
			}
			$subjects=null;
			$attendance=null;
			$conduct_tmplt=null;
			$grades =null;
			$addtosubjects=null;
			$section= $EGB->get_sec_alias($seccode);
			$deptcode =$section[0]['dept'];
			$level=$section[0]['level'];
			$gryrlv = array(
			  'PS'=>array('Nursery -','Kinder 1 -','Kinder 2 -'),
			  'GS'=>array('GRADE 1 -', 'GRADE 2 -', 'GRADE 3 -', 'GRADE 4 -', 'GRADE 5 -', 'GRADE 6 -'),
			  'HS'=>array('I -', 'II -', 'III -','IV -'),
			);
			$gryrlv_promote = array(
			  'PS'=>array('Nursery','Kinder 1','Kinder 2','Grade 1'),
			  'GS'=>array('Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6','First Year High School'),
			  'HS'=>array('First Year', 'Second Year', 'Third Year','Fourth Year','First Year College'),
			);
			$section_alias = $gryrlv[$deptcode][$level-1].' '.$section[0]['section'];
			
			if( $deptcode=='PS'){
				$dept_alias = 'Pre School';
				if($level==1){
					$dept_alias = 'Nursery';
				}else{
					$dept_alias = 'Kindergarten';
				}
				$addtosubjects =false;
				$hasgenave  = true;
			}else if($deptcode=='GS'){
				$dept_alias = 'Grade School Department';
				$addtosubjects =true;
				$hasgenave  = true;
			}else if($deptcode=='HS'){
				$dept_alias = 'High School Department';
				$addtosubjects =true;
				$hasgenave  = true;
			}
			$adviser = $EGB->get_adviser($seccode, $sy, 1);
			$adviser =$EGB->get_users($adviser['fid']);
			$students = $EGB->get_stud_nrol($compcode, array($seccode), $sy,-1, $sno);
			
			$adviser['full_name'] =utf8_decode($adviser['full_name']);
		
			foreach($students as $student){
				
				$sno=$student['sno'];
				$student['fullname'] =utf8_decode($student['fullname']);
				$period_ctr = 1;
				$GRADES = array();
				$CONDUCT = array();
				$ATTENDANCE = array();
				$report_card_grades = $EGB->report_card_grades($sy, $student['sno'], $seccode);
				
				$report_card_conduct = $EGB->report_card_conduct($sy, $student['sno'], $seccode);
				$report_card_attendance = $EGB->report_card_attendance($sy, $student['sno'], $seccode);
				$TOTAL_UNITS  = 0;
				$TOTAL_SUBJECTS  = 0;
				$TOTAL_SUM = 0;
				$GEN_AVE = 0;
				$GEN_AVE_ROUND = 2;
				//Grades and Conduct
				$periods = array('fr','se','th','fo','fi');
				//Sanitize grades
				for($p=0;$p<7;$p++){
					$subjects =array();
					$conduct_tmplt =array();
					foreach($report_card_grades as $rcg){
						$final_subjects = array();
						$final_subjects['nomen']=$p>0?' ':$rcg['nomen'];
						$final_subjects['unit']=$rcg['unit'];
						$final_subjects['under']=$rcg['under'];
						$final_subjects['weight']=$rcg['weight'];
						$final_subjects['child']=$rcg['child'];
						if($p<5){
							$final_subjects['period']=$p+1;
							$final_subjects['grades']=$p+1==5?"   ".$rcg[$periods[$p]]:$rcg[$periods[$p]];
							if($final_subjects['grades']==""){
								$final_subjects['grades']='---';
							}
							if($deptcode=='PS'){
								if($rcg['under']!='F'){
									$virtual_subjects = array();
									$virtual_subjects['nomen']=' ';
									$virtual_subjects['unit']='NULL';
									$virtual_subjects['under']='NULL';
									$virtual_subjects['grades']=" ";
									$virtual_subjects['period']=$p+1;
									array_push($subjects,$virtual_subjects);
								}
							}
							if($p==4){
								$final_grade  =  (float)$rcg['fg'];
								$final_unit  =  $rcg['unit'];
								$final_under  =  $rcg['under'];
								$final_compcode  =  $rcg['compcode'];
								$TOTAL_SUBJECTS +=1;
								if($deptcode=='PS'){
									if($final_under!='F'){
										$final_unit=null;
										$final_grade=null;
										$TOTAL_SUBJECTS-=1;
									}
								}
								if($deptcode=='HS'||$deptcode=='GS'){
									if($final_under!='F'){
										$final_grade=null;
										$TOTAL_SUBJECTS-=1;
									}
								}
								$TOTAL_UNITS += $final_unit;								
								$TOTAL_SUM += $final_grade;
							//	echo $TOTAL_SUM.'<br>';
							//	echo $TOTAL_SUBJECTS.'<br>';
								$GEN_AVE = number_format($TOTAL_SUM/$TOTAL_SUBJECTS,$GEN_AVE_ROUND,'.','');
								
							}
						}else{
							if($p==5){
								$final_period = 5;
								$final_subjects['period']=$final_period;
								$final_under  =  $rcg['under'];
								$final_grade  =  (float)$rcg['fg'];
								if($deptcode=='PS'){
									if($rcg['under']!='F'){
										$virtual_subjects = array();
										$virtual_subjects['nomen']=' ';
										$virtual_subjects['unit']='NULL';
										$virtual_subjects['under']='NULL';
										$virtual_subjects['grades']=" ";
										$virtual_subjects['period']=$p+1;
										array_push($subjects,$virtual_subjects);
									}
								}
								if($final_grade){
									$pad=" ";
									if($deptcode!='PS'){
										$pad="       ";
									}
									$final_subjects['grades']=$pad.($final_grade>=75.00?"Passed":"       Failed");
									
								}else{
									$final_subjects['grades']="    ";
								}
							}else if($p==6){
								$final_period = 6;
								$final_subjects['period']=$final_period;
								$final_subjects['grades']="       ".$rcg['unit'];
							}
						}
						array_push($subjects,$final_subjects);	
						
					}
				
					if($p<5){
						
						foreach($report_card_conduct as $rcc){
							if($rcc['period']==$p+1){
								
								$final_conduct = array();
								$final_conduct['hdr']=$rcc['hdr'];
								$final_conduct['desc']=$deptcode=='PS'&&$p==0?$rcc['desc']:' ';
								$final_conduct['score']=$p+1==5?"       ".$rcc['score']:$rcc['score'];
								if($rcc['hdr']=="Rating"){
									$virtual_subjects = array();
									$virtual_subjects['nomen']='DEPORTMENT';
									$virtual_subjects['unit']='NULL';
									$virtual_subjects['under']='NULL';
									$virtual_subjects['grades']=$p+1==5?"   ".$rcc['score']:$rcc['score'];
									$virtual_subjects['period']=$rcc['period'];
									array_push($subjects,$virtual_subjects);
								}
								if($rcc['hdr']=="MAPE"){
									$virtual_subjects = array();
									$virtual_subjects['nomen']=' ';
									$virtual_subjects['unit']='NULL';
									$virtual_subjects['under']='NULL';
									$virtual_subjects['grades']=" ";
									$virtual_subjects['period']=$rcc['period'];
									array_push($subjects,$virtual_subjects);
								}
								array_push($conduct_tmplt,$final_conduct);
							}
						}
						array_push($CONDUCT,$conduct_tmplt);
					}
					
					if($p<6){
						if($hasgenave){
							if($p==0){
								if($deptcode=='PS'){
									array_push($subjects, array('nomen'=>'GENERAL AVERAGE','grades'=>'', 'under'=>'NULL', 'comp_code'=>'', 'period'=>1));
								}else{
									array_push($subjects, array('nomen'=>' ','grades'=>'', 'under'=>'NULL', 'comp_code'=>'', 'period'=>1));
								}
							}
							if($p==4){
								if($deptcode=='PS'){
									$GEN_AVE_DISP = '   '.$EGB->get_letter_grade(round($GEN_AVE,0),true);
								}else{
									$GEN_AVE_DISP = $GEN_AVE;
								}
								array_push($subjects, array('nomen'=>'','grades'=>$GEN_AVE_DISP , 'under'=>'', 'comp_code'=>'', 'period'=>6));
							}
						}
					}
					array_push($GRADES,$subjects);
					
					
				}
				$BUFF_SUBJ = $LAST_SUBJ = $GRADES[6][count($GRADES[6])-1];
				if(!$hasgenave||$TOTAL_UNITS==0){
					$TOTAL_UNITS = ' ';
				}				
				$LAST_SUBJ['grades']="       ".$TOTAL_UNITS;
				$BUFF_SUBJ['grades']="";
				array_push($GRADES[6],$BUFF_SUBJ);
				array_push($GRADES[6],$LAST_SUBJ);
				$ATTENDANCE= $report_card_attendance;
				
				$BUFF_ATT = $ATTENDANCE[count($ATTENDANCE)-1];
			
				$BUFF_ATT['school_days']=' ';
				$BUFF_ATT['present']=' ';
				$BUFF_ATT['absent']=' ';
				array_push($ATTENDANCE,$BUFF_ATT);
				
				$BUFF_ATT['school_days']='-';
				$BUFF_ATT['present']='-';
				$BUFF_ATT['absent']='-';
				array_push($ATTENDANCE,$BUFF_ATT);
				$ATTENDANCE = arraySwap($ATTENDANCE,count($ATTENDANCE)-3, count($ATTENDANCE)-1);
			

				$date= "MARCH 30,2012";
				
				if($GEN_AVE>75.00){
					$promote = $gryrlv_promote[$deptcode][$level];
					$nxt_level = $level+1;
					$ispromote = true;
				}else{
					$promote = $gryrlv_promote[$deptcode][$level-1];
					$nxt_level = $level;
					$ispromote = false;
				}
				$nxt_deptcode =$deptcode;
				if($ispromote){
					if($deptcode=='PS'&&$nxt_level==4){
						$nxt_deptcode='GS';
						$nxt_level=1;
					}else if($deptcode=='GS'&&$nxt_level==7){
						$nxt_deptcode='HS';
						$nxt_level=1;
					}else if($deptcode=='HS'&&$nxt_level==4){
						$nxt_deptcode='TS';
						$nxt_level=1;
					}
				}
				
				$PROMOTE->promote($sno, $sy,$GEN_AVE, $nxt_deptcode, $nxt_level, $ispromote);
				$report_card->create($GRADES,$ATTENDANCE,$CONDUCT,$student,$adviser,$section_alias,$dept_alias, $deptcode,$level,$date,$promote);
			}
		}
	}

	$report_card->out();
	$PROMOTE->db_close();
	$EGB->db_close();
?>