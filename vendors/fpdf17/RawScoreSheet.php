<?php
require ('fpdf.php');
	class RawScoreSheet extends FPDF{
		protected $FONT_OFFSET = 1.15;
		public function create($teacher,$sy,$section,$deptalias,$subj_nomen,$period, $curr_page, $total_page,$flag=0){
			$this->AddPage();
			$this->SetMargins(0,0);
			//$this->SetLeftMargin(-0.5);
			$this->LogoHead($teacher,$sy,$section,$deptalias,$subj_nomen,$period,$curr_page, $total_page,$flag);
			} 	
		public function LogoHead($teacher,$sy,$section,$deptalias,$subj_nomen,$period,$curr_page, $total_page,$flag){
			if(is_numeric($period)){
				switch($period){
					case 1: $period_str = "First Grading"; break;
					case 2: $period_str = "Second Grading"; break;
					case 3: $period_str = "Third Grading"; break;
					case 4: $period_str = "Fourth Grading"; break;
					case 5: $period_str = "Final Rating"; break;
				}
			}else{
				$period_str =  $period;
			}
			if(is_numeric($sy)){
				$sy_str =  $sy .' - '. ($sy+1);
			}else{
				$sy_str =  $sy;
			}
			if($flag==0){
				$center_text=13/2;
				$this->SetFont('Arial','',9); 
				$this->CenterText($center_text,0.50,'HOLY INFANT ACADEMY - '.$deptalias);
				$this->CenterText($center_text,0.65,'S.Y. '.$sy_str.', '.$period_str);
				$this->Text(0.30,0.95,$section);
				$this->Text(12.8,0.79,sprintf("Page %s of %s", $curr_page,$total_page));
				$this->Text(0.30,0.79,$subj_nomen);
				$this->Text(0.57,7.47, "PREPARED BY:"); 
				$this->Text(0.57,7.85, utf8_decode($teacher)); 
				$this->Text(10.58,7.47, "CHECKED BY:"); 
				$this->SetFont('Arial','',7); 
				$MANILA_TIME = date("Y-m-d h:i:s A", time()+(-7*60*60));
				$this->Text(0.57,8.00,'Printed: '.$MANILA_TIME); 
			}else if($flag==1){
				$center_text=8.5/2;
				$this->SetFont('Arial','',9); 
				$this->CenterText($center_text,0.50,'HOLY INFANT ACADEMY - '.$deptalias);
				$this->CenterText($center_text,0.65,'S.Y. '.$sy_str.', '.$period_str);
				$this->Text(0.30,0.95,$section);
				$this->Text(7.50,0.79,sprintf("Page %s of %s", $curr_page,$total_page));
				$this->Text(0.30,0.79,$subj_nomen);
				$this->Text(0.57,11.80, "PREPARED BY:"); 
				$this->Text(0.57,12.25, $teacher); 
				$this->Text(6.50,11.80, "CHECKED BY:"); 
				$this->SetFont('Arial','',7); 
				$MANILA_TIME = date("Y-m-d h:i:s A", time()+(-7*60*60));
				$this->Text(0.57,12.40,'Printed: '.$MANILA_TIME); 
			}
		}
		public function CenterText($disp_x,$disp_y,$str){
			$disp_x = $disp_x - $this->GetStringWidth($str)*0.5;
			$this->Text($disp_x,$disp_y,$str);	
		}
		
		public function DrawRectangle($height=6.30,$width=13.40){
			$this->Rect(0.30,1.00,$width,$height);
		}
		public function DrawHorLines($x1,$y1,$x2,$y2,$h,$rows){
			$H=$h/$rows;
			$h_lines=array();
			for($index=0;$index<$rows;$index++){
			$X1=$x1;
			$Y1=$y1+($H*$index);
			$X2=$x2;
			$Y2=$y2+($H*$index);
			array_push($h_lines,$Y1);
			$this->Line($X1,$Y1,$X2,$Y2);
			}
			return $h_lines;
		}
		
		public function DrawVerLines($x1,$y1,$x2,$y2,$w,$cols){
			$W=$w/$cols;
			$v_lines=array();
			for($index=0; $index<$cols; $index++){
			$X1=$x1+($W*$index);
			$Y1=$y1;
			$X2=$x2+($W*$index);
			$Y2=$y2;
			array_push($v_lines,$X1);
			$this->Line($X1,$Y1,$X2,$Y2);
			}
			return $v_lines;
		}
		public function PlotGrades($grades,$res_x, $res_y,$width,$height){
			$this->SetFont('Arial','',6); //Font
			for($ctr=0;$ctr<count($res_x);$ctr++){
				for($index=0; $index < count($res_y);$index++){
				if($index>1){
					$this->SetXY($res_x[$ctr],$res_y[$index]);	
					//$this->MultiCell($width,$height,$ctr."-".$index);
					}
				}
			}
		}
		public function ColHeaders($h_lines,$v_line,$headers,$width,$height){
			for($index=0; $index<count($headers);$index++){
				$this->SetXY($h_lines[$index],$v_line);
				$this->MultiCell($width,$height,$headers[$index]);
			}
		}
		
		public function FirstColmn($h_lines,$v_line,$headers,$width,$height,$offset=0){
			for($index=0; $index<count($headers);$index++){
				$this->SetXY($v_line,$h_lines[$index]+$offset);
				$this->MultiCell($width,$height,$headers[$index]);
			}
		}
		public function PlotColHeaders($measurables, $components_rec, $v_lines, $h_lines, $cellwidth, $cellheight, $cocurratt=false, $FONT_SIZE = 10,$disp_flg=null ){
			 
			$col_ctr=0;
			$col_hdrs = array();
			$j=0;
			foreach($components_rec as $c){
				if(!$cocurratt){
					$perc=$c['perc'].'%';
					$desc=strtoupper($c['ccode']);
				}
				if($c['count']>=1){
					if($c['count']<2){$c['desc']= $c['desc'][0]; }
					$c['count']+=1;
					$desc=strtoupper($c['desc']);
					
				}
				$this->Rect($v_lines[$col_ctr],$h_lines[0],$cellwidth*($c['count']-1),$cellheight,"FD"); // Column Holder
				array_push($col_hdrs,$col_ctr);
				
				$this->SetXY($v_lines[$col_ctr],$h_lines[0]);
				$const_w=$cellwidth*($c['count']-1);
				$fsize =$FONT_SIZE;
				
				$this->SetFont('Arial','',$fsize);
				$const =round($this->GetStringWidth($desc),2);
				
				do{				
					$this->SetFont('Arial','',$fsize);
					$const2 =round($this->GetStringWidth($desc),2);
					$fsize-=0.1;
				}while($const2>$const_w*0.90);
				
				
				$this->MultiCell($cellwidth*($c['count']-1),$cellheight, $desc,0,'C'); // Column Label
				
				
				for($i=0;$i<$c['count']-1;$i++){
					if($cocurratt){
						$disp = $measurables[$i];
						if(count($disp_flg)!=0){
							if($disp_flg[$i]==0){
								$this->SetFont('Arial','',$fsize);
							}else{
								$this->SetFont('Arial','B',$fsize);
							}
						}
					}
					else{
						if($c['count']>1){
							//$disp = $i+1;
							$disp = $measurables[$j]['hdr'];
							$j++;
						}else{
							$disp = $c['desc'][0];
						}
					}
					$this->SetFont('Arial','',$FONT_SIZE *0.7);
					$this->SetXY($v_lines[$col_ctr+$i],$h_lines[1]);
					$this->MultiCell($cellwidth,$cellheight, $disp,0,'C'); // Column Label
					
				}
				$col_ctr+=$c['count']-1;
				if(!$cocurratt){
					$this->SetFont('Arial','',$FONT_SIZE);
					$this->Rect($v_lines[$col_ctr],$h_lines[0],$cellwidth,$cellheight*2,"FD");
					$this->SetXY($v_lines[$col_ctr],$h_lines[0]);
					$this->MultiCell($cellwidth,$cellheight, 'AVE',0,'C');
					$col_ctr+=1;
					
					$this->Rect($v_lines[$col_ctr],$h_lines[0],$cellwidth,$cellheight*2,"FD");
					$this->SetXY($v_lines[$col_ctr],$h_lines[0]);
					$this->SetFont('Arial','B',$FONT_SIZE-$this->FONT_OFFSET);
					$this->MultiCell($cellwidth,$cellheight, $perc,0,'C');
					$col_ctr+=1;
				}
				//$j--;
			}
			if(!$cocurratt){
				$this->Rect($v_lines[$col_ctr],$h_lines[0],$cellwidth,$cellheight*2,"FD"); // Column Holder
				$this->SetXY($v_lines[$col_ctr],$h_lines[0]);
				$this->MultiCell($cellwidth,$cellheight*2, 'T.G.',0,'C'); // Column Label
				array_push($col_hdrs,$col_ctr);
				$col_ctr+=1;
				$this->Rect($v_lines[$col_ctr],$h_lines[0],$cellwidth,$cellheight*2,"FD"); // Column Holder
				$this->SetXY($v_lines[$col_ctr],$h_lines[0]);
				$this->MultiCell($cellwidth,$cellheight*2, 'F.G.',0,'C'); // Column Label
				array_push($col_hdrs,$col_ctr);
			}else{
				//$this->Rect($v_lines[$col_ctr],$h_lines[1],$cellwidth,$cellheight*1,"FD"); // Column Holder
				//array_push($col_hdrs,$col_ctr);
				//$col_ctr+=1;		
			}
			return $col_hdrs;
		}
		public function PlotStudents($students, $start_at, $h_lines, $width, $height,$offset=0,$rawscore, $summary, $components,$v_lines,$col_hdrs,$cellwidth,$cellheight, $cocurratt=false, $start_index=0, $g_flg='', $FONT_SIZE, $ROWS,$is_gs = false,$disp_flg=null){
			$index=$start_index;
			$line_ctr=1;
			$curr_g_flg= $prev_g_flg=$g_flg;
			do{
				$curr_g_flg = $students[$index]['gender'];
				$prev_g_flg= $students[$index]['status']==1?'':$prev_g_flg;
				if($line_ctr>=$ROWS-2){
						return $index;
					}
				if($curr_g_flg != $prev_g_flg ){
					$this->SetFont('Arial','',$is_gs?12:7);
					$gender_label= $curr_g_flg=='M'?'Boys' :( $curr_g_flg=='F'?'Girls':' ');
				
					if($students[$index]['status']==1){
						$gender_label = $curr_g_flg=='M'?'Additional Boys' : 'Additional Girls';
					}else{
						$gender_label= $curr_g_flg=='M'?'Boys' :( $curr_g_flg=='F'?'Girls':' ');
					}
					$this->SetXY($start_at,$h_lines[$line_ctr]+$offset);
					$this->MultiCell($width,$height,$gender_label);	
					$line_ctr+=1;
				}
				$prev_g_flg = $curr_g_flg; 
				//NAME
				$this->SetXY($start_at,$h_lines[$line_ctr]+$offset);
				$fsize =7;
				$this->SetFont('Arial','',$fsize);
				$const =round($this->GetStringWidth(utf8_decode($students[$index]['fullname'])),2);
				
				do{				
					$this->SetFont('Arial','',$fsize);
					$const2 =round($this->GetStringWidth(utf8_decode($students[$index]['fullname'])),2);
					$fsize-=0.5;
				}while($const2>$width*0.90);
				$this->MultiCell($width,$height,utf8_decode(utf8_decode($students[$index]['fullname'])));
				
				//GRADES
				$grd_ptr=0;
				$TG=0;
				$ptr=0;
				
				$this->SetFont('Arial','',$FONT_SIZE); //Font
				for($k=0;$k<count($components);$k++){
					$total=0;
					for($l=0;$l<$components[$k]['count'];$l++){
						$ptr = $col_hdrs[$k]+$l;
						$this->SetXY($v_lines[$ptr],$h_lines[$line_ctr]+$offset);
						$score = $rawscore[$index]['grades'][$grd_ptr++];
						if(count($disp_flg)!=0){
							if($disp_flg[$grd_ptr-1]==0){
								$this->SetFont('Arial','',$FONT_SIZE); //Font
							}else{
								$this->SetFont('Arial','B',$FONT_SIZE); //Font
							}
						}
						$align = $cocurratt? 'C':'R';
						$this->MultiCell($cellwidth,$cellheight,$score,0,$align);
						$total+=$score;
						if($l==($components[$k]['count']-1)){
							/*$T =$total;
							if($components[$k]['count']>1){
								$ptr+=1;
								$this->SetXY($v_lines[$ptr],$h_lines[$line_ctr]+$offset);
								$T=number_format(round($T,2),2);
								//$this->MultiCell($cellwidth,$cellheight, $T, 0,'R');
							}
							*/
							if($cocurratt){
							
							}else{
								$SUM = $summary[$index]['grades'][$k];
								$AVE = $summary[$index]['average'][$k];
								$TG+=$SUM;
								$ptr+=1;
								$this->SetFont('Arial','B',$FONT_SIZE-$this->FONT_OFFSET); //Font
								$this->SetXY($v_lines[$ptr],$h_lines[$line_ctr]+$offset);
								$this->MultiCell($cellwidth,$cellheight,is_numeric($AVE)?number_format($AVE,2):$AVE,0,'R');
								$ptr+=1;
								
								$this->SetXY($v_lines[$ptr],$h_lines[$line_ctr]+$offset);
								$this->MultiCell($cellwidth,$cellheight,is_numeric($SUM)?number_format($SUM,2):$SUM,0,'R');
								$this->SetFont('Arial','',$FONT_SIZE); //Font
							}
						}
					}	
				}
				if(!$cocurratt){
					$ptr+=1;
					$this->SetXY($v_lines[$ptr],$h_lines[$line_ctr]+$offset);
					$this->SetFont('Arial','B',$FONT_SIZE-$this->FONT_OFFSET);
					$this->MultiCell($cellwidth,$cellheight,number_format(round($TG,2),2),0,'R'); // NUMBER FORMAT 00.00
					$ptr+=1;
					$this->SetFont('Arial','',$FONT_SIZE);
					$this->SetXY($v_lines[$ptr],$h_lines[$line_ctr]+$offset);
					if($TG<70){$TG=70;} // GRADE ADJUSTMENT FLOOR
					$this->MultiCell($cellwidth,$cellheight,round($TG,0),0,'R');
				}
				$index++;
				$line_ctr++;
			}while($index<count($students));
		}
	}
?>