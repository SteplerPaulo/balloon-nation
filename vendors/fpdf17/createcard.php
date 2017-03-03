<?php
include_once('../header.php');
include_once('ReportCard.php');

set_time_limit ( 390 );
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
			$section_alias = $deptcode.'-'.$level.' '.$section[0]['section'];
			
			if($deptcode == 'PS'){
				switch($level){
					case 1:
						$section_alias =  'N '.$section[0]['section'];
					break;
					case 2:
						$section_alias =  'K-I '.$section[0]['section'];
					break;
					case 3:
						$section_alias =  'K-II '.$section[0]['section'];
				}
			
			}
			if( $deptcode=='PS'){
				$dept_alias = 'Pre School';
				if($level==1){
					$dept_alias = 'Nusery';
				}else{
					$dept_alias = 'Kndergarten';
				}
				$addtosubjects =false;
			}else if($deptcode=='GS'){
				$dept_alias = 'Grade School Department';
				$addtosubjects =true;
			}else if($deptcode=='HS'){
				$dept_alias = 'High School Department';
				$addtosubjects =true;
			}
			$adviser = $EGB->get_adviser($seccode, $sy, 1);
			$adviser =$EGB->get_users($adviser['fid']);
			$students = $EGB->get_stud_nrol($compcode, array($seccode), $sy,-1, $sno);
			
			$adviser['full_name'] =utf8_decode($adviser['full_name']);
			
			
			foreach($students as $student){
				$subjects =array();
				$sno=$student['sno'];
				$student['fullname'] =utf8_decode($student['fullname']);
				$period_ctr = 1;
				$GRADES = array();
				$CONDUCT = array();
				
				
				//Grades and Conduct
				
				while($period_ctr<=$period){
					//$default_subjects = $EGB->get_s($sy, $deptcode, $level, $seccode, $period_ctr);	
					
					$default_subjects = $EGB->get_subjects($deptcode, $level, $sy,false,$period_ctr);
					$grades = $EGB->get_final_scores($sy, $period_ctr, array($seccode),$sno);
					$subjects = $default_subjects;
					// MAP GRADES
					for($subject_ctr=0;$subject_ctr<count($subjects);$subject_ctr++){
						$subjects[$subject_ctr]['grades']='NG';
						if(count($grades)){
							for($grade_ctr=0;$grade_ctr<count($grades);$grade_ctr++){
								if($grades[$grade_ctr]['comp_code']==$subjects[$subject_ctr]['comp_code']){
									if(isset($grades[$grade_ctr]['display'])&&$grades[$grade_ctr]['display']!=''){
										$subjects[$subject_ctr]['grades']=$grades[$grade_ctr]['display'];
									}else{
										$subjects[$subject_ctr]['grades'] ='NG';
									}
								}
							}
						}
					}
					if(!$addtosubjects){
						array_push($subjects, array('nomen'=>'GENERAL AVERAGE','grades'=>'  ', 'under'=>'NULL', 'comp_code'=>'', 'period'=>$period_ctr));
					}
					
					$conduct_tmplt = $EGB->get_conduct_tmplt($deptcode, $level, $version, $sy);
					$conduct = $EGB->getconduct_details($period_ctr, $sy, $seccode, $compcode, $sno);
					
					//MAP CONDUCT
					for($contmpl_ctr=0;$contmpl_ctr<count($conduct_tmplt);$contmpl_ctr++){
						if($conduct){
							for($conduct_ctr=0;$conduct_ctr<count($conduct);$conduct_ctr++){
								if($conduct[$conduct_ctr]['hdr']==$conduct_tmplt[$contmpl_ctr]['hdr']){
									$conduct_tmplt[$contmpl_ctr]['score']=$conduct[$conduct_ctr]['score'];
									if($conduct_tmplt[$contmpl_ctr]['hdr']=='Rating' && count($subjects)<=count($default_subjects)){
										if($addtosubjects){
											array_push($subjects, array('nomen'=>strtoupper($conduct_tmplt[$contmpl_ctr]['desc']),'grades'=>$conduct[$conduct_ctr]['score'], 'under'=>'NULL', 'comp_code'=>'', 'period'=>$period_ctr));
										}
									}
								}
							}
						}else{
							$conduct_tmplt[$contmpl_ctr]['score'] = 'XX';
							if($addtosubjects){
								if(count($subjects)<=count($default_subjects)){
									array_push($subjects, array('nomen'=>strtoupper($conduct_tmplt[count($conduct_tmplt)-1]['desc']),'grades'=>'XX', 'under'=>'NULL', 'comp_code'=>'', 'period'=>$period_ctr));
								}
							}
						}
					}
					if($deptcode=='GS' ||$deptcode=='HS'){
						for($i=0;$i<count($conduct_tmplt);$i++){
							$conduct_tmplt[$i]['desc']=' ';
						}
					}
					
					array_push($CONDUCT,$conduct_tmplt);
					array_push($GRADES,$subjects);
					$period_ctr++;
				}
				$period_ctr=0;
				$ATTENDANCE = array();
				
				while($period_ctr<$period){
				
					$attendance_tmplt = $EGB->get_attendance_tmplt($sy, $period_ctr+1);
					$attendance = $EGB->get_attendance($seccode, $sy, $period_ctr+1, $sno);
					
					//MAP ATTENDANCE
					$good=true;
					if(!$attendance){
						$attendance = array();
						$good=false;
					}
					for($atttmpl_ctr=0;$atttmpl_ctr<count($attendance_tmplt);$atttmpl_ctr++){
						$arr= array();
						if($attendance && $good){
							for($attendance_ctr=0;$attendance_ctr<count($attendance_tmplt);$attendance_ctr++){
								if(isset($attendance[$attendance_ctr])){
									if($attendance[$attendance_ctr]['month']==$attendance_tmplt[$atttmpl_ctr]['month']){
										$arr['sno']='';
										$arr['school_days']=$attendance_tmplt[$atttmpl_ctr]['days'];
										$arr['present']=$attendance_tmplt[$atttmpl_ctr]['days'] - $attendance[$attendance_ctr]['absent'];
										$arr['absent']=$attendance[$attendance_ctr]['absent'];
										$arr['month']=$attendance_tmplt[$atttmpl_ctr]['month'];
										array_push($ATTENDANCE, $arr);
									}
								}else{
										$arr['sno']='';
										$arr['school_days']=$attendance_tmplt[$atttmpl_ctr]['days'];
										$arr['present']=$attendance_tmplt[$atttmpl_ctr]['days'];
										$arr['absent']=0;
										$arr['month']=$attendance_tmplt[$atttmpl_ctr]['month'];
										array_push($ATTENDANCE, $arr);
								}
							}		
						}else{
							$arr['sno']='';
							$arr['school_days']='XX';
							$arr['present']='XX';
							$arr['absent']='XX';
							$arr['month']=$attendance_tmplt[$atttmpl_ctr]['month'];
							array_push($ATTENDANCE, $arr);
						}
					}
					$period_ctr++;
				}
				$report_card->create($GRADES,$ATTENDANCE,$CONDUCT,$student,$adviser,$section_alias,$dept_alias, $deptcode,$level);
			}
		}
	}
	$report_card->out();
	$EGB->db_close();
?>