<?php
require('fpdf.php');
class ReportCard extends FPDF{
	var $showLines;
	var $line_ctr=0;
	var $record_index=0;
	var $sheet_max_record =45;
	var $paper_width = 8.5;
	var $PASS = array('r'=>0,'g'=>0, 'b'=>0);
	var $FAIL = array('r'=>255,'g'=>0, 'b'=>0);
	
	function create($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias,$deptcode,$level,$date='MARCH 30,2012',$promote='GRADE TWO'){
		//Prepare page
		$this->AddPage();
		$this->SetMargins(0,0);
		
		//Prepare Graphics
		$this->SetFillColor(255); // Color white
		$this->SetFont('Arial','',6); //Font
		
		if($deptcode=='HS'||$deptcode=='GS'){
			$this->draw_hs_gs($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias);
			$this->draw_footer_hs_gs(-0.25,$date,$promote);
		}else{
			$this->draw_ps($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias,$level,$date,$promote);
			
		}
	}
	private function draw_ps($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias,$level,$date,$promote){
		$offset = 0;
		if($level==1){
			$this->draw_nursery($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias);
			$offset = -1.00;
		}else{
		
			$this->draw_kinder($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias);	
		}
		$this->draw_footer($offset,$date,$promote);
	}
	private function draw_footer_hs_gs($offset,$date,$promote){
		
		$this->SetFont('Arial','B',9); //Font
		$this->Text(3.48,9.51+$offset, $promote);
		$this->Text(6.5,9.51+$offset, $date);
		
		}
	
	private function draw_footer($offset,$date,$promote){
		$this->SetFont('Arial','B',8.5); //Font
		$this->center_text(8.5/2,7.80+$offset, "EVALUATION CODE");
		$this->SetFont('Arial','',8.5); //Font
		$this->Rect(0.48,7.94+$offset,7.33,0.61); // Skills
		$this->right_text(1.40,8.10+$offset, "O");
		$this->right_text(1.40,8.25+$offset, "VG");
		$this->right_text(1.40,8.40+$offset, "G");
		$this->Text(1.92,8.10+$offset, "Oustanding");
		$this->Text(1.92,8.25+$offset, "Very Good");
		$this->Text(1.92,8.40+$offset, "Good");
		$this->Text(3.06,8.10+$offset, "96-99");
		$this->Text(3.06,8.25+$offset, "91-95");
		$this->Text(3.06,8.40+$offset, "86-90");
		$this->right_text(4.16,8.10+$offset, "S");
		$this->right_text(4.16,8.25+$offset, "F");
		$this->right_text(4.16,8.40+$offset, "NI");
		$this->Text(4.62,8.10+$offset, "Satisfactory");
		$this->Text(4.62,8.25+$offset, "Fair");
		$this->Text(4.62,8.40+$offset, "Needs Improvement");
		$this->Text(6.29,8.10+$offset, "80-85");
		$this->Text(6.29,8.25+$offset, "75-79");
		$this->Text(6.29,8.40+$offset, "74-below");
		$this->SetFont('Arial','B',8.5); //Font
		$this->center_text(8.5/2,8.78+$offset, "TO PARENTS");
		$this->SetFont('Arial','',8.5); //Font
		$this->Text(0.94,8.95+$offset, "This Report Card is issued at the end of each grading period to keep you  informed of the progress of your child. Please");
		$this->Text(0.48,9.10+$offset, "examine it carefully and keep this copy for your reference. Sign the acknowledgment slip and return to the Adviser.");
		$this->SetFont('Arial','B',9); //Font
		$this->Text(0.48,9.51+$offset, "PROMOTED TO / RETAINED IN:");
		$this->Line(2.50,9.53+$offset,5.03,9.53+$offset);
		$this->Text(5.48,9.51+$offset, "DATE:");
		$this->Line(5.90,9.53+$offset,7.81,9.53+$offset);
		$this->Line(0.48,9.70+$offset,0.48+7.33,9.70+$offset);
		$this->center_text(8.5/2,9.90+$offset, "CERTIFICATE OF TRANSFER ELIGIBILITY");
		$this->SetFont('Arial','',9); //Font
		$this->Text(0.73,10.11+$offset, "This is to certify that");
		$this->Line(2.00,10.11+$offset,4.25,10.11+$offset);
		$this->Text(4.32,10.11+$offset, "is eligble to transfer and admission to");
		$this->Line(6.50,10.11+$offset,7.23,10.11+$offset);
		$this->Text(7.27,10.11+$offset, "on");
		$this->Line(0.48,10.30+$offset,2.26,10.30+$offset);	
		$this->Text(5.30,10.50+$offset,"NERISSA M. GUILLERMO");
		$this->SetFont('Arial','',8); //Font
		$this->center_text(5.30+(($this->GetStringWidth("NERISSA M. GUILLERMO"))/2),10.60+$offset,"Principal");
		
			$this->SetFont('Arial','B',9); //Font
		$this->Text(3.48,9.51+$offset, $promote);
		$this->Text(6.5,9.51+$offset, $date);
		
		}
	private function draw_kinder($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias){
		$this->showLines =true;
		
		$this->Image('template/images/logo.gif',(($this->paper_width/2 )-(5.00/2)),0.50,5.00,0.70);
		
		//Main Boxes
		if($this->showLines){
			$this->Rect(0.48,2.55,7.33,1.89); // Grades
			$this->Rect(0.48,2.55,7.33,0.30); // Grades Header
			$this->Rect(0.48,4.57,7.33,1.02); // Skills
			$this->Rect(0.48,4.57,7.33,0.22); // Skills Header 
			$this->Rect(0.48,5.78,7.33,0.64); // Conduct Development
			$this->Rect(0.48,5.78,7.33,0.23); // Conduct Header
			$this->Rect(0.48,6.55,7.33,0.98); // Attendance
			$this->Rect(0.48,6.55,7.33,0.31 ); // Attendance Header
		}
		//Grades
		//Line Constants
		$grades_hlines_const['base'] = 2.55 + 0.30;
		$grades_hlines_const['max'] = count($subjects[0])+1;
		$grades_hlines_const['height'] =1.40/count($subjects[0]);
		$grades_hlines_const['startX'] = 0.48;
		$grades_hlines_const['endX']=0.48+7.33;
		$grades_vlines_const['base'] = 3.46;
		$grades_vlines_const['max'] = 8;
		$grades_vlines_const['width'] = 4.35/6;
		$grades_vlines_const['startY'] = 2.55;
		$grades_vlines_const['endY'] = 2.55+1.89;
		//Header Constants
		$periods = array('1','2','3','4', 'FINAL','','');
		$disp_x = 0.60;
		$disp_y = 2.74;
		$disp_until = 1;
		
		//Build Lines
		$grades_lines = $this->build_lines($grades_hlines_const, $grades_vlines_const);
		
		//Build Headers
		if($this->showLines){$this->build_headers($grades_lines['v'], $periods, $disp_y, $disp_until);}
		
		//Build grades 
		//$x =  $grades_lines['v'][1] +(($grades_lines['v'][1]-$grades_lines['v'][2])*0.5);
		//$this->build_grades($subjects, $disp_x, $x, $grades_lines, 'nomen','grades', 'under', array( '','NULL'));
		for($p=0;$p<count($subjects)-1;$p++){
			$x =  $grades_lines['v'][$p+1] +(($grades_lines['v'][$p+1]-$grades_lines['v'][$p+2])*0.5);
			$this->build_grades($subjects[$p], $disp_x, $x, $grades_lines, 'nomen','grades', 'under', array( '','NULL'));
		}
		
		//Skills
		//Line Constants
		$affdvt_hlines_const['base'] = 4.57 + 0.22;
		$affdvt_hlines_const['max'] = 5;
		$affdvt_hlines_const['height'] =0.75/4;
		$affdvt_hlines_const['startX'] = 0.48;
		$affdvt_hlines_const['endX']=0.48+7.33;
		
		$affdvt_vlines_const['base'] = 3.46;
		$affdvt_vlines_const['max'] = 7;
		$affdvt_vlines_const['width'] = 4.35/6;
		$affdvt_vlines_const['startY'] = 4.57;
		$affdvt_vlines_const['endY'] = 4.57+1.02;
		
		//Build Lines
		$affdvt_lines = $this->build_lines($affdvt_hlines_const, $affdvt_vlines_const);
		
		//Build Grades
		//$x = $affdvt_lines['v'][1] +(($affdvt_lines['v'][1]-$affdvt_lines['v'][2])*0.5);
		//$this->build_grades($conduct_tmplt, $disp_x, $x, $affdvt_lines, 'desc','score', 'hdr',array('A','F'),0,0.07);
		
		for($p=0;$p<count($conduct_tmplt);$p++){
			$x = $affdvt_lines['v'][$p+1] +(($affdvt_lines['v'][$p+1]-$affdvt_lines['v'][$p+2])*0.5);
			$this->build_grades($conduct_tmplt[$p],$disp_x, $x, $affdvt_lines, 'desc','score', 'hdr',array('A','F'),0,0.07,true,1);
		}
		
		//Conduct
		//Line Constants
		$psydvt_hlines_const['base'] = 5.78 + 0.23;
		$psydvt_hlines_const['max'] = 3;
		$psydvt_hlines_const['height'] =0.60/3;
		$psydvt_hlines_const['startX'] = 0.48;
		$psydvt_hlines_const['endX']=0.48+7.33;
		
		$psydvt_vlines_const['base'] = 3.46;
		$psydvt_vlines_const['max'] = 7;
		$psydvt_vlines_const['width'] = 4.35/6 ;
		$psydvt_vlines_const['startY'] = 5.78;
		$psydvt_vlines_const['endY'] = 5.78+0.64;
		
		//Build Lines
		$psydvt_lines = $this->build_lines($psydvt_hlines_const, $psydvt_vlines_const);
		
		//Build Grades
		//$x = $psydvt_lines['v'][1] +(($psydvt_lines['v'][1]-$psydvt_lines['v'][2])*0.5);
		//$this->build_grades($conduct_tmplt, $disp_x, $x, $psydvt_lines, 'desc','score', 'hdr',array('A','F'),4,0.07);

		for($p=0;$p<count($conduct_tmplt);$p++){
			$x = $psydvt_lines['v'][$p+1] +(($psydvt_lines['v'][$p+1]-$psydvt_lines['v'][$p+2])*0.5);
			$this->build_grades($conduct_tmplt[$p],$disp_x, $x, $psydvt_lines, 'desc','score', 'hdr',array('A','F'),4,0.07,true,1);
		}
		//Attendance
		//Line Constants
		$attend_hlines_const['base'] = 6.55 + 0.31;
		$attend_hlines_const['max'] = 4;
		$attend_hlines_const['height'] = 0.65 / 3;
		$attend_hlines_const['startX'] = 0.48;	
		$attend_hlines_const['endX']=0.48 +7.33; 
		$attend_vlines_const['base'] = 1.88;
		$attend_vlines_const['max'] = 12;
		$attend_vlines_const['width'] = 5.49/12;
		$attend_vlines_const['startY'] =6.55;
		$attend_vlines_const['endY'] =6.55+0.98;
		//Header Constants
		$months = array('J', 'J', 'A', 'S', 'O', 'N', 'D', 'J', 'F', 'M', 'A', 'M',' ');
		$disp_x = 0.60;
		$disp_y = 6.77;
		$disp_until = 1;
		
		//Build Lines
		$attend_lines = $this->build_lines($attend_hlines_const, $attend_vlines_const);
		
		//Build Headers
		
		if($this->showLines){$this->build_headers($attend_lines['v'], $months, $disp_y, $disp_until);}
		$this->build_attendance($attend_lines,$attendance, $attend_lines['v'][0]-0.03 , array('Days of School', 'Days Present', 'Days Absent'),0.06);
		$this->center_text( $attend_lines['v'][11]+$attend_vlines_const['width'],$attend_lines['h'][1]-0.06, $attendance[12]['school_days']);
		$this->center_text( $attend_lines['v'][11]+$attend_vlines_const['width'],$attend_lines['h'][2]-0.06, $attendance[12]['present']);
		$this->center_text( $attend_lines['v'][11]+$attend_vlines_const['width'],$attend_lines['h'][3]-0.06, $attendance[12]['absent']);
		//Labels
		//Top
		$this->SetFont('Arial','',7); //Font
		$this->Text(0.48,2.32,'NAME:');
		$this->Text(0.87,2.32,$student['fullname']);
		$this->Text(0.48,2.45,'CLASS ADVISER: '.$adviser['full_name']);
		$this->Text(5.48,2.32,'LEVEL & SECTION: '.$section_alias);
		$this->Text(5.48,2.45,'SCHOOL YEAR: 2011-2012');
		$this->SetFont('Arial','',8); //Font
		$this->center_text(8.5/2,1.30,'PROGRESS REPORT');
		$this->SetFont('Arial','',9); //Font
		$this->center_text(8.5/2,1.45,strtoupper($dept_alias));
		//Grades
		$this->SetFont('Arial','',8); //Font
		$this->center_text(0.48+(2.98/2),2.75, 'SUBJECTS');
		$this->center_text(0.48+(2.98/2),4.73, 'SKILLS');
		$this->center_text(0.48+(2.98/2),5.94, 'CONDUCT');
		$this->center_text((0.48+1.88)/2,6.77, 'ATTENDANCE');
		$this->center_text($grades_lines['v'][5]+(($grades_lines['v'][5]-$grades_lines['v'][4])/2),6.77, 'TOTAL');
		$this->SetFont('Arial','',6); //Font
		$this->center_text($grades_lines['v'][5]+(($grades_lines['v'][5]-$grades_lines['v'][4])/2),2.69, 'ACTION');
		$this->center_text($grades_lines['v'][5]+(($grades_lines['v'][5]-$grades_lines['v'][4])/2),2.79, 'TAKEN');
		
	}
	private function draw_nursery($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias){
		$this->showLines = true;
		
		//$this->Image('template/images/logo.gif',(($this->paper_width/2 )-(4.08/2)),0.58,4.08,0.59);
		$this->Image('template/images/logo.gif',(($this->paper_width/2 )-(5.00/2)),0.50,5.00,0.70);
		
		//Main Boxes
		$this->Rect(0.48,2.55,7.33,1.61); // Grades
		$this->Rect(0.48,2.55,7.33,0.30); // Grades Header
		$this->Rect(0.48,4.29,7.33,0.74); // Affective Development
		$this->Rect(0.48,4.29,7.33,0.22); // Affective Header 
		$this->Rect(0.48,5.17,7.33,0.23); // Psychomotor Header
		$this->Rect(0.48,5.50,7.33,0.98); // Attendance
		$this->Rect(0.48,5.50,7.33,0.31 ); // Attendance Header
		
		//Grades
		//Line Constants
		$grades_hlines_const['base'] = 2.55 + 0.30;
		$grades_hlines_const['max'] = count($subjects[0])+1;
		$grades_hlines_const['height'] =1.18/count($subjects[0]);
		$grades_hlines_const['startX'] = 0.48;
		$grades_hlines_const['endX']=0.48+7.33;
		$grades_vlines_const['base'] = 3.46;
		$grades_vlines_const['max'] =8;
		$grades_vlines_const['width'] = 4.35/6;
		$grades_vlines_const['startY'] = 2.55;
		$grades_vlines_const['endY'] = 2.55+1.61;
		//Header Constants
		$periods = array('1','2','3','4','FINAL','');
		$disp_x = 0.60;
		$disp_y = 2.74;
		$disp_until = 2;
		
		//Build Lines
		$grades_lines = $this->build_lines($grades_hlines_const, $grades_vlines_const);
		$this->SetFont('Arial','',8); 
		//Build Headers
		if($this->showLines){$this->build_headers($grades_lines['v'], $periods, $disp_y, $disp_until);}
		
		//Build grades 
		//$x =  $grades_lines['v'][1] +(($grades_lines['v'][1]-$grades_lines['v'][2])*0.5);
		//$this->build_grades($subjects, $disp_x, $x, $grades_lines, 'nomen','grades', 'under', array( '','NULL'));
		
		for($p=0;$p<count($subjects)-1;$p++){
			$x =  $grades_lines['v'][$p+1] +(($grades_lines['v'][$p+1]-$grades_lines['v'][$p+2])*0.5);
			$this->build_grades($subjects[$p], $disp_x, $x, $grades_lines, 'nomen','grades', 'under', array( '','NULL'));
		}
		//Affective Development
		//Line Constants
		$affdvt_hlines_const['base'] = 4.29 + 0.22;
		$affdvt_hlines_const['max'] = 3;
		$affdvt_hlines_const['height'] =0.50/2;
		$affdvt_hlines_const['startX'] = 0.48;
		$affdvt_hlines_const['endX']=0.48+7.33;
		
		$affdvt_vlines_const['base'] = 3.46;
		$affdvt_vlines_const['max'] = 7;
		$affdvt_vlines_const['width'] = 4.35/6;
		$affdvt_vlines_const['startY'] = 4.29;
		$affdvt_vlines_const['endY'] = 4.29+0.74;
		
		//Build Lines
		$affdvt_lines = $this->build_lines($affdvt_hlines_const, $affdvt_vlines_const);
		
		//Build Grades
		//$x = $affdvt_lines['v'][1] +(($affdvt_lines['v'][1]-$affdvt_lines['v'][2])*0.5);
		//$this->build_grades($conduct_tmplt, $disp_x, $x, $affdvt_lines, 'desc','score', 'hdr',array('A','F'),0,0.07);
		for($p=0;$p<count($conduct_tmplt);$p++){
			$x = $affdvt_lines['v'][$p+1] +(($affdvt_lines['v'][$p+1]-$affdvt_lines['v'][$p+2])*0.5);
			$this->build_grades($conduct_tmplt[$p],$disp_x, $x, $affdvt_lines, 'desc','score', 'hdr',array('A','F'),0,0.07,true,1);
		}
		
		//Psychomotor Development
		//Line Constants
		$psydvt_hlines_const['base'] = 5.17 + 0.23;
		$psydvt_hlines_const['max'] = 1;
		$psydvt_hlines_const['height'] =0.32;
		$psydvt_hlines_const['startX'] = 0.48;
		$psydvt_hlines_const['endX']=0.48+7.33;
		
		$psydvt_vlines_const['base'] = 3.46;
		$psydvt_vlines_const['max'] = 7;
		$psydvt_vlines_const['width'] = 4.35/6;
		$psydvt_vlines_const['startY'] = 5.17;
		$psydvt_vlines_const['endY'] = 5.17+0.23;
		
		//Build Lines
		$psydvt_lines = $this->build_lines($psydvt_hlines_const, $psydvt_vlines_const);
		
		//Build Grades
		//$x = $psydvt_lines['v'][1] +(($psydvt_lines['v'][1]-$psydvt_lines['v'][2])*0.5);
		//$this->build_grades($conduct_tmplt, $disp_x, $x, $psydvt_lines, 'desc','score', 'hdr',array('A','F'),2,0.07,true);
		for($p=0;$p<count($conduct_tmplt);$p++){
			$x = $psydvt_lines['v'][$p+1] +(($psydvt_lines['v'][$p+1]-$psydvt_lines['v'][$p+2])*0.5);
			$this->build_grades($conduct_tmplt[$p],$disp_x, $x, $psydvt_lines, 'desc','score', 'hdr',array('A','F'),2,0.07,true);
		}
		
		//Attendance
		//Line Constants
		$attend_hlines_const['base'] = 5.50 + 0.31;
		$attend_hlines_const['max'] = 4;
		$attend_hlines_const['height'] = 0.63 / 3;
		$attend_hlines_const['startX'] = 0.48;	
		$attend_hlines_const['endX']=0.48 +7.33; 
		$attend_vlines_const['base'] = 1.88;
		$attend_vlines_const['max'] = 12;
		$attend_vlines_const['width'] = 5.49/12;
		$attend_vlines_const['startY'] = 5.50;
		$attend_vlines_const['endY'] = 5.50+0.98;
		//Header Constants
		$months = array('J', 'J', 'A', 'S', 'O', 'N', 'D', 'J', 'F', 'M', 'A', 'M',' ');
		$disp_x = 0.60;
		$disp_y = 5.70;
		$disp_until = 1;
		
		//Build Lines
		$attend_lines = $this->build_lines($attend_hlines_const, $attend_vlines_const);
		
		//Build Headers
		if($this->showLines){$this->build_headers($attend_lines['v'], $months, $disp_y, $disp_until);}
		$this->build_attendance($attend_lines,$attendance, $attend_lines['v'][0]-0.03 , array('Days of School', 'Days Present', 'Days Absent'),0.06);
			$this->center_text( $attend_lines['v'][11]+$attend_vlines_const['width'],$attend_lines['h'][1]-0.06, $attendance[12]['school_days']);
		$this->center_text( $attend_lines['v'][11]+$attend_vlines_const['width'],$attend_lines['h'][2]-0.06, $attendance[12]['present']);
		$this->center_text( $attend_lines['v'][11]+$attend_vlines_const['width'],$attend_lines['h'][3]-0.06, $attendance[12]['absent']);
		//Labels
		//Top
		$this->SetFont('Arial','',7); //Font
		$this->Text(0.48,2.32,'NAME:');
		$this->Text(0.87,2.32,$student['fullname']);
		$this->Text(0.48,2.45,'CLASS ADVISER: '.$adviser['full_name']);
		$this->Text(5.48,2.32,'LEVEL & SECTION: '.$section_alias);
		$this->Text(5.48,2.45,'SCHOOL YEAR: 2011-2012');
		$this->SetFont('Arial','',8); //Font
		$this->center_text(8.5/2,1.30,'PROGRESS REPORT');
		$this->SetFont('Arial','',9); //Font
		$this->center_text(8.5/2,1.45,strtoupper($dept_alias));
		//Grades
		$this->SetFont('Arial','',8); //Font
		$this->center_text(0.48+(2.98/2),2.75, 'COGNITIVE DEVELOPMENT');
		$this->center_text(0.48+(2.98/2),4.45, 'AFFECTIVE DEVELOPMENT');
		$this->center_text(0.48+(2.98/2),5.33, 'PSYCHOMOTOR DEVELOPMENT');
		//$this->center_text($grades_lines['v'][4]+(($grades_lines['v'][4]-$grades_lines['v'][3])/2),2.75, 'FINAL');
		$this->center_text($grades_lines['v'][5]+(($grades_lines['v'][5]-$grades_lines['v'][4])/2),5.70, 'TOTAL');
	}
	private function draw_hs_gs($subjects,$attendance,$conduct_tmplt,$student,$adviser,$section_alias,$dept_alias){
		//Main Boxes
		if($this->showLines){
			$this->Rect(0.54,2.26,7.07, 2.41); // Grades
			$this->Rect(0.54,2.26,7.07, 0.39); // Grades Header
			$this->Rect(0.55,5.00,7.07,0.66); // Attendance
			$this->Rect(0.55,5.00,7.07,0.19 ); // Attendance Header
			$this->Rect(0.55,5.94,7.07, 1.70); // Conduct
			$this->Rect(0.55,5.94,7.07, 0.32); // Conduct Header
		}
		
		//Grades
		//Line Constants
		//$grades_hlines_const['base'] = 1.61 + 0.39+0.17 + 0.02 + 0.02; // FIRST SUBJECT VERTICAL 
		$grades_hlines_const['base'] = 2.10; // FIRST SUBJECT VERTICAL 
		$grades_hlines_const['max'] = 13;
		$grades_hlines_const['height'] = 2.03/12;
		$grades_hlines_const['startX'] = 0.54;
		$grades_hlines_const['endX']=0.54+7.07;
		//$grades_vlines_const['base'] = 2.25+0.2+0.2 + 0.01+0.15; // FIRST GRADE HORIZONTAL
		$grades_vlines_const['base']=2.58;
		$grades_vlines_const['max'] = 9;
		$grades_vlines_const['width'] = 5.27/7;
		$grades_vlines_const['startY'] = 2.26;
		$grades_vlines_const['endY'] = 2.26+2.41;
		//Header Constants
		$periods = array('1','2','3','4');
		$disp_x = 0.40+0.30; // FIRST SUBJECT HORIZONTAL
		$disp_y = 2.60;
		$disp_until = 3;
		
		//Build Lines
		$grades_lines = $this->build_lines($grades_hlines_const, $grades_vlines_const);
		
		//Build Headers
		if($this->showLines){$this->build_headers($grades_lines['v'], $periods, $disp_y, $disp_until);}
		
		//Build grades 
		for($p=0;$p<count($subjects);$p++){
			$x =  $grades_lines['v'][$p+1] +(($grades_lines['v'][$p+1]-$grades_lines['v'][$p+2])*0.5);
			$this->build_grades($subjects[$p], $disp_x, $x, $grades_lines, 'nomen','grades', 'under', array('A', 'F','NULL'));
		}
		//Attendance
		//Line Constants
		//$attend_hlines_const['base'] = 4.54 + 0.19 +0.17 + 0.13 + 0.04 + 0.02 + 0.01+0.015; // SCHOOL DAYS VERTICAL
		$attend_hlines_const['base'] = 4.77; // SCHOOL DAYS VERTICAL
		$attend_hlines_const['max'] = 4;
		$attend_hlines_const['height'] = 0.47 / 3;
		$attend_hlines_const['startX'] = 0.55;	
		$attend_hlines_const['endX']=0.55 +7.07; 
		//$attend_vlines_const['base'] = 2.28+0.25+0.1 + 0.10;  //SCHOOL DAYS HORIZONTAL
		$attend_vlines_const['base'] = 2.46;  //SCHOOL DAYS HORIZONTAL
		$attend_vlines_const['max'] = 14;
		$attend_vlines_const['width'] = 0.40;
		$attend_vlines_const['startY'] = 5.00;
		$attend_vlines_const['endY'] = 5.00+0.66;
		//Header Constants
		$months = array('JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR', 'APR', 'MAY');
		$disp_x = 0.60;
		$disp_y = 5.15;
		$disp_until = 1;
		
		//Build Lines
		$attend_lines = $this->build_lines($attend_hlines_const, $attend_vlines_const);
		//Build Headers
		if($this->showLines){$this->build_headers($attend_lines['v'], $months, $disp_y, $disp_until);}
		$this->build_attendance($attend_lines,$attendance, $attend_lines['v'][0]-0.03 , array(' ', ' ', ' '));
		
		
		//Conduct
		//Line Constants
		//$condct_hlines_const['base'] = 5.54 + 0.32 + 0.30 +0.11 + 0.02 + 0.01 ;// RULE VERTICAL
		$condct_hlines_const['base'] = 5.89 ;// RULE VERTICAL
		$condct_hlines_const['max'] = 9;
		$condct_hlines_const['height'] = 1.35/8;
		$condct_hlines_const['startX'] = 0.55;	
		$condct_hlines_const['endX']=0.55 +7.07; 
		//$condct_vlines_const['base'] =  5.57 +0.55 + 0.1 + 0.1; //RULE HORIZONTAL
		$condct_vlines_const['base'] =  5.80; //RULE HORIZONTAL
		$condct_vlines_const['max'] = 7;
		$condct_vlines_const['width'] = 0.37;
		$condct_vlines_const['startY'] = 5.94;
		$condct_vlines_const['endY'] = 5.94+1.70;
		//Header Constants
		$disp_x = 0.60;
		$disp_y = 6.20;
		$disp_until = 1;
		
		//Build Lines
		$conduct_lines = $this->build_lines($condct_hlines_const, $condct_vlines_const, 2);
		//if($this->showLines){$this->build_headers($conduct_lines['v'], $periods, $disp_y, $disp_until);}
		
		//Build Grades
		for($p=0;$p<count($conduct_tmplt);$p++){
			$x = $conduct_lines['v'][$p+1] +(($conduct_lines['v'][$p+1]-$conduct_lines['v'][$p+2])*0.5);
			$this->build_grades($conduct_tmplt[$p], $disp_x, $x, $conduct_lines, 'desc','score');
		}
		//Special Boxes
		if($this->showLines){
			$this->Rect(2.35,2.26,3.01,0.18,'DF'); // Grades SubHeader
			$this->Rect(5.47,5.94,1.48,0.15,'DF'); // Grades SubHeader
		}
		//Labels
		//Top
		$this->SetFont('Arial','',10); //Font
		if($this->showLines){$this->right_text(1.84+0.2,1.74+0.15,'Name:');}
		//$this->Text(0.87+0.12+0.1 + 0.1 ,1.10+0.15+0.02,$student['fullname']); // NAME VERTICAL
		$this->Text(1.03 ,1.19,$student['fullname']); // NAME VERTICAL
		if($this->showLines){$this->right_text(1.84+0.4,1.88+0.15,'Section');}
		//$this->Text(1.52+0.2+0.1+0.1,1.27+0.15+0.02,$section_alias); // SECTION VERTICAL
		$this->Text(1.65,1.36,$section_alias); // SECTION VERTICAL
		
		if($this->showLines){$this->right_text(1.84+0.4,2.02+0.15,'Class Adviser');}
		//$this->Text( 1.47+0.15+0.2,1.44+0.15+0.02,$adviser['full_name']);
		$this->Text( 1.65,1.51,$adviser['full_name']);
		//$this->right_text(7.62+0.7+0.15,1.10+0.15+0.02,'2011-2012');
		$this->right_text(7.95,1.19,'2011-2012');
		$this->SetFont('Arial','',11); //Font
		$this->center_text((8.5/2),0.94,strtoupper($dept_alias));
		//Grades
		$this->SetFont('Arial','',6); //Font
		if($this->showLines){$this->center_text(2.35+(3.01/2),2.39,'PERIODIC RATING');}
		$this->SetFont('Arial','',8); //Font
		if($this->showLines){$this->center_text(0.55+(1.80/2),2.48, 'SUBJECTS');}
		$this->SetFont('Arial','',8); //Font
		if($this->showLines){
			$this->center_text($grades_lines['v'][4]+(($grades_lines['v'][5]-$grades_lines['v'][4])/2),2.43, 'FINAL');
			$this->center_text($grades_lines['v'][4]+(($grades_lines['v'][5]-$grades_lines['v'][4])/2),2.56, 'GRADE');
			$this->center_text($grades_lines['v'][5]+(($grades_lines['v'][5]-$grades_lines['v'][4])/2),2.43, 'ACTION');
			$this->center_text($grades_lines['v'][5]+(($grades_lines['v'][5]-$grades_lines['v'][4])/2),2.56, 'TAKEN');
			$this->center_text(7.05+(0.40/2),2.43, 'CREDITS');
			$this->center_text(7.05+(0.40/2),2.56, 'EARNED');
		}
		//Attendance
		if($this->showLines){
		$this->center_text(0.55+(1.33/2),5.14, 'ATTENDANCE RECORD');
		$this->center_text(6.64+(1.01/2),5.15, 'TOTAL');
		//Conduct
		$this->center_text(0.55+(4.92/2),6.15, 'TRAITS');
		$this->SetFont('Arial','',6); //Font
		$this->center_text(5.47+(1.48/2),6.04,'PERIODIC RATING');
		$this->SetFont('Arial','',8); //Font
		$this->center_text(6.99+(0.63/2),6.09, 'FINAL');
		$this->center_text(6.99+(0.63/2),6.21, 'GRADE');}
	}
	private function build_grades($src,$disp_x, $x, $lines, $key_1, $key_2, $key_3 = '', $key_4=null, $start_at= 0, $offset = 0.03, $single=false, $plot_at = 0){
		if(!$single){
			
			for($ctr=0;$ctr<count($lines['h'])-1;$ctr++){
				if($start_at<count($src)){
					$this->SetFont('Arial','',9); //Font
					$adjust=0;
					$display=$src[$start_at][$key_1];
					if($key_3!=''){
						if(!in_array($src[$start_at][$key_3],$key_4)){
							$adjust =0;
						}
					}else{
						if($ctr==count($src)-1){
							$this->SetFont('Arial','B',9); //Font
							$display = strtoupper($display);
						}
					}		
					
					if(isset($src[$start_at]['period']) &&$src[$start_at]['period']==1){
						$this->Text($disp_x+$adjust, $lines['h'][$ctr+1]-$offset, strtoupper($display));
					}
					if(isset($src[$start_at][$key_2])){
						$this->center_text($x, $lines['h'][$ctr+1]-$offset, $src[$start_at][$key_2]);
					}
					$start_at+=1;
				}
			}
		}else{
			for($ctr=$plot_at;$ctr<count($lines['h']);$ctr++){
				if($start_at<count($src)){
					$this->SetFont('Arial','',7); //Font
					$adjust=0;
					$display=$src[$start_at][$key_1];
					if($key_3!=''){
						if(!in_array($src[$start_at][$key_3],$key_4)){
							$adjust =0.1;
						}
					}else{
						if($ctr==count($src)-1){
							$this->SetFont('Arial','B',7); //Font
							$display = strtoupper($display);
							
						}

					}
					if($ctr<count($lines['h']) && $plot_at!=0){
						$this->Text($disp_x+$adjust, $lines['h'][$ctr]-$offset, strtoupper($display));
					}
					$this->center_text($x, $lines['h'][$ctr]-$offset, $src[$start_at][$key_2]);
					$start_at+=1;
				}
			}
		}
	}
	private function build_attendance($lines,$src, $disp_x ,$labels, $offset = 0.03){
		$lbls =  array('school_days','present','absent');
		for($ctr=0;$ctr<count($lines['h'])-1;$ctr++){
			if($ctr<count($labels)){
				$this->right_text($disp_x, $lines['h'][$ctr+1]-$offset,strtoupper($labels[$ctr]));
				$headers =  array();
					for($l=0;$l<count($src);$l++){
						array_push($headers,$src[$l][$lbls[$ctr]]);
					}
					
					$this->build_headers($lines['v'], $headers,  $lines['h'][$ctr+1]-$offset, 14-count($src));
			}
		}
		
	}
	private function build_lines($h_const, $v_const, $flag=1){
		$lines = array();
		$v_lines=array();
		$h_lines=array();
		$adjust = 0.00;
		//Horizontal Lines
		for($line_ctr=0; $line_ctr<$h_const['max'] ; $line_ctr++){
			if($flag==1){
				switch($line_ctr){
					case 2:
						$adjust = 0.01;
						break;
					case 3:
						$adjust = 0.01;
						break;
					case 5:
						$adjust =  0.02;
						break;
				}
			}else if($flag==2){
				switch($line_ctr){
					case 1:
						$adjust = -0.01;
						break;
					case 2:
						$adjust = 0.01;
						break;
					case 8:
						$adjust = 0.015;
						break;
				}
			}
			$disp_y = $h_const['base']+(($h_const['height']+$adjust) * $line_ctr);
			if($this->showLines){
				$this->Line($h_const['startX'],$disp_y,$h_const['endX'],$disp_y);
			}
			array_push($h_lines,$disp_y);
		}
		
		//Vertical Lines		
		for($line_ctr=0; $line_ctr<$v_const['max'] ; $line_ctr++){
			$disp_x = $v_const['base']+($v_const['width'] * $line_ctr);
			if($this->showLines){
				$this->Line($disp_x,$v_const['startY'],$disp_x, $v_const['endY']);
			}
			array_push($v_lines, $disp_x);
		}
		$lines['h']=$h_lines;
		$lines['v']=$v_lines;
		return $lines;
	}
	private function build_headers($vlines, $headers, $disp_y, $disp_until=1){
			for($ctr=0;$ctr<count($vlines)-$disp_until;$ctr++){
				$disp_x = $vlines[$ctr] +(($vlines[$ctr+1]-$vlines[$ctr])*0.5);
				$this->center_text($disp_x,$disp_y,$headers[$ctr]);
			}
	}
	private function center_text($disp_x,$disp_y,$str){
		$disp_x = $disp_x - $this->GetStringWidth($str)*0.5;
		$this->Text($disp_x, $disp_y, $str);
	}
	private function right_text($disp_x,$disp_y,$str){
		$disp_x = $disp_x - $this->GetStringWidth($str);
		$this->Text($disp_x, $disp_y, $str);
	}
	public function out(){
		$this->Output();
	}
} ?>