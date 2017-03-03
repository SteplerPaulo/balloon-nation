<?php
require ('fpdf.php');
class COGSheet extends FPDF{
	public function init(){
		$this->AddPage();
		$this->SetMargins(0,0);
		
	}
	public function buildHead($info,$v_lines,$h_lines,$cell,$startAt=0){
		
		$this->SetMargins(0,0);
		
		$this->Image('template/images/logo.gif',$this->w/2-(2.5*.35),0.1+$startAt,2.5,0.35);
		$this->SetFont('Arial','',9); 
		$this->Text($this->w/2-($this->GetStringWidth('CHANGE OF GRADE FORM')*.30),0.65+$startAt,'CHANGE OF GRADE FORM');
		$this->SetFont('Arial','B',7); 
		
		
		$this->SetXY($v_lines[0],$h_lines[0]);
		$this->MultiCell($cell['width']*2,$cell['height'],'Date/Time:',0,'L');
		
		
		//REFNO LABEL
		$this->SetXY($v_lines[12],$h_lines[0]);
		$this->MultiCell($cell['width'],$cell['height'],'RefNo:',0,'R');
		
		//SCHOOL YEAR LABEL
		$this->SetXY($v_lines[0],$h_lines[1]);
		$this->MultiCell($cell['width'],$cell['height'],'SY:',0,'R');
		//$this->Line($v_lines[1],$h_lines[0],$v_lines[1],$h_lines[2]);
		
		//EDUC LEVEL LABEL
		$this->SetXY($v_lines[0],$h_lines[2]);
		$this->MultiCell($cell['width'],$cell['height'],'Dept:',0,'R');
		
		
		
		//PERIOD LABEL
		$this->SetXY($v_lines[3],$h_lines[1]);
		$this->MultiCell($cell['width'],$cell['height'],'Period:',0,'R');
		//$this->Line($v_lines[3],$h_lines[0],$v_lines[3],$h_lines[2]);
		
		//GR YR LEVEL LABEL
		$this->SetXY($v_lines[3],$h_lines[2]);
		$this->MultiCell($cell['width'],$cell['height'],'Gr/Yr:',0,'R');
		
		//STUDENT NAME LABEL
		$this->SetXY($v_lines[5],$h_lines[1]);
		$this->MultiCell($cell['width']*2,$cell['height'],'Student Name:',0,'R');
		//$this->Line($v_lines[6],$h_lines[0],$v_lines[6],$h_lines[2]);
		
		//SECTION  LABEL
		$this->SetXY($v_lines[6],$h_lines[2]);
		$this->MultiCell($cell['width'],$cell['height'],'Section:',0,'R');
		
		//SUBJECT LABEL
		$this->SetXY($v_lines[12],$h_lines[1]);
		$this->MultiCell($cell['width'],$cell['height'],'Subject:',0,'R');
		
		//$this->Line($v_lines[12],$h_lines[0],$v_lines[12],$h_lines[2]);
		
		//FACULTY NAME LABEL
		$this->SetXY($v_lines[12],$h_lines[2]);
		$this->MultiCell($cell['width'],$cell['height'],'Teacher:',0,'R');
		$this->SetFont('Arial','',7); 
		
		
		//COG INFO DETAILS
		$this->SetXY($v_lines[1]+0.025,$h_lines[0]);
		$this->MultiCell($cell['width']*3,$cell['height'],date('m/d/Y h:i:s A',time()+(7*60*60)));
		$this->SetXY($v_lines[1],$h_lines[1]);
		$this->MultiCell($cell['width']*2,$cell['height'],$info['sy']);
		$this->SetXY($v_lines[1],$h_lines[2]);
		$this->MultiCell($cell['width']*2,$cell['height'],$info['educ_lvl']);
		$this->SetXY($v_lines[13],$h_lines[0]);
		$this->MultiCell($cell['width']*2,$cell['height'],$info['refno']);
		$this->SetXY($v_lines[4],$h_lines[1]);
		$this->MultiCell($cell['width']*2,$cell['height'],$info['period']);
		//$this->Line($v_lines[4],$h_lines[0],$v_lines[4],$h_lines[2]);
		$this->SetXY($v_lines[4],$h_lines[2]);
		$this->MultiCell($cell['width']*2,$cell['height'],$info['gryr_lvl']);
		$this->SetXY($v_lines[7],$h_lines[2]);
		$this->MultiCell($cell['width']*5,$cell['height'],$info['section']);
		
		//LENGTHY VALUES CHECK APPROPRIATE FONT SIZE USING get_fsize()
		$info['teacher'] = strtoupper($info['teacher']);
		$fsize = $this->get_fsize($info['student'],9,$cell['width']*5);
		$this->SetXY($v_lines[7],$h_lines[1]);
		$this->SetFont('Arial','',$fsize); 
		$this->MultiCell($cell['width']*6,$cell['height'],$info['student']);
		//$this->Line($v_lines[8]-$cell['width']*0.5,$h_lines[0],$v_lines[8]-$cell['width']*0.5,$h_lines[2]);
		
		$fsize = $this->get_fsize($info['subject'],9,$cell['width']*3);
		$this->SetFont('Arial','',$fsize); 
		$this->SetXY($v_lines[13],$h_lines[1]);
		$this->MultiCell($cell['width']*3,$cell['height'],$info['subject']);
		//$this->Line($v_lines[13],$h_lines[0],$v_lines[13],$h_lines[2]);
		$fsize = $this->get_fsize($info['teacher'],9,$cell['width']*3);
		$this->SetFont('Arial','',$fsize); 
		$this->SetXY($v_lines[13],$h_lines[2]);
		$this->MultiCell($cell['width']*3,$cell['height'],$info['teacher']);
	
	}
	
	
	public function buildFoot($v_lines,$h_lines,$cell,$startAt=0,$type="NEW"){
		$this->SetMargins(0,0);
		if($type=="APPLIED"){
			//REFNO LABEL
			$this->SetXY($v_lines[10]-0.25,$h_lines[0]);
			$this->MultiCell($cell['width']*2,$cell['height'],'Approve by:',0,'L');
			$this->SetXY($v_lines[13],$h_lines[0]);
			
			$this->MultiCell($cell['width']*2,$cell['height'],'Processed by:',0,'L');
			//Requested by LABEL
			$this->SetXY($v_lines[0],$h_lines[0]);
			$this->MultiCell($cell['width']*2,$cell['height'],'Requested by:',0,'L');
			//$this->Line($v_lines[1],$h_lines[0],$v_lines[1],$h_lines[2]);
			
			//EDUC LEVEL LABEL
			$this->SetXY($v_lines[1],$h_lines[2]);
			$this->Line($v_lines[1]-0.1,$h_lines[2]-0.05,$v_lines[3]+0.1,$h_lines[2]-0.05);
			$this->MultiCell($cell['width']*2,$cell['height'],'Teacher',0,'C');
			
			
			
			//PERIOD LABEL
			$this->SetXY($v_lines[3]-0.25,$h_lines[0]);
			$this->MultiCell($cell['width']*2,$cell['height'],'Noted by:',0,'R');
			//$this->Line($v_lines[3],$h_lines[0],$v_lines[3],$h_lines[2]);
			
			//GR YR LEVEL LABEL
			$this->SetXY($v_lines[5]-0.25,$h_lines[2]);
			$this->Line($v_lines[5]-0.25-0.1,$h_lines[2]-0.05,$v_lines[7]+0.1-0.25,$h_lines[2]-0.05);
			$this->MultiCell($cell['width']*2,$cell['height'],'Coordinator',0,'C');
			
			
			//GR YR LEVEL LABEL
			$this->SetXY($v_lines[8]-0.25,$h_lines[2]);
			$this->Line($v_lines[8]-0.1-0.25,$h_lines[2]-0.05,$v_lines[10]+0.1-0.25,$h_lines[2]-0.05);
			$this->MultiCell($cell['width']*2,$cell['height'],'Vice Principal',0,'C');
			
			
			//SUBJECT LABEL
			$this->SetXY($v_lines[12]-0.5,$h_lines[2]);
			$this->Line($v_lines[12]-0.1-0.5,$h_lines[2]-0.05,$v_lines[14]+0.1-0.5,$h_lines[2]-0.05);
			$this->Cell($cell['width']*2,$cell['height']*0.75,'Principal',0,0,'C');
			
			//SUBJECT LABEL
			$this->SetXY($v_lines[15]-0.5,$h_lines[2]);
			$this->Line($v_lines[15]-0.5,$h_lines[2]-0.05,$v_lines[16],$h_lines[2]-0.05);
			$this->Cell($cell['width']*2,$cell['height']*0.75,'Registrar',0,0,'C');
		}
		else{
						//REFNO LABEL
			$this->SetXY($v_lines[11],$h_lines[0]);
			$this->MultiCell($cell['width']*2,$cell['height'],'Approve by:',0,'R');
			
			//Requested by LABEL
			$this->SetXY($v_lines[0],$h_lines[0]);
			$this->MultiCell($cell['width']*2,$cell['height'],'Requested by:',0,'R');
			//$this->Line($v_lines[1],$h_lines[0],$v_lines[1],$h_lines[2]);
			
			//EDUC LEVEL LABEL
			$this->SetXY($v_lines[2],$h_lines[2]);
			$this->Line($v_lines[2]-0.1,$h_lines[2]-0.05,$v_lines[4]+0.1,$h_lines[2]-0.05);
			$this->MultiCell($cell['width']*2,$cell['height'],'Teacher',0,'C');
			
			
			
			//PERIOD LABEL
			$this->SetXY($v_lines[4],$h_lines[0]);
			$this->MultiCell($cell['width']*2,$cell['height'],'Noted by:',0,'R');
			//$this->Line($v_lines[3],$h_lines[0],$v_lines[3],$h_lines[2]);
			
			//GR YR LEVEL LABEL
			$this->SetXY($v_lines[6],$h_lines[2]);
			$this->Line($v_lines[6]-0.1,$h_lines[2]-0.05,$v_lines[8]+0.1,$h_lines[2]-0.05);
			$this->MultiCell($cell['width']*2,$cell['height'],'Coordinator',0,'C');
			
			
			//GR YR LEVEL LABEL
			$this->SetXY($v_lines[9],$h_lines[2]);
			$this->Line($v_lines[9]-0.1,$h_lines[2]-0.05,$v_lines[11]+0.1,$h_lines[2]-0.05);
			$this->MultiCell($cell['width']*2,$cell['height'],'Vice Principal',0,'C');
			
			
			//SUBJECT LABEL
			$this->SetXY($v_lines[13],$h_lines[2]);
			$this->Line($v_lines[13]-0.1,$h_lines[2]-0.05,$v_lines[15]+0.1,$h_lines[2]-0.05);
			$this->Cell($cell['width']*2,$cell['height']*0.75,'Principal',0,0,'C');

			
		}
	
		
	}
	
	public function buildDetails($dtls,$v_lines,$h_lines,$cell,$type){
		$this->SetFont('Arial','',7.5);
		$labels = array('Components','Measurables','Old Grade', 'Change','New Grade');
		$metrics = array(4,4,3,2,3);
		$ptr = 0;
		for($index=0;$index<count($metrics);$index++){
			//$x1 =$cell['width']*$metrics[$index];
			//$this->SetXY($v_lines[$ptr],$h_lines[0]);
			//$this->MultiCell($x1,$cell['height'],$labels[$index]);
			$this->CenterText($v_lines[$ptr]+(($cell['width']*$metrics[$index])*.5),$h_lines[0]+($cell['height']*0.75),$labels[$index]);
			$this->Line($v_lines[$ptr],$h_lines[0],$v_lines[$ptr],$h_lines[count($h_lines)-1]);
			$ptr+=$metrics[$index];
		}
		$i=0;
		$this->Line($v_lines[$ptr],$h_lines[0],$v_lines[$ptr],$h_lines[count($h_lines)-1]);
		foreach($dtls as $d){
			$ptr = 0;
			$i++;
			
			for($index=0;$index<count($d);$index++){
				
				
				if($index==3){
					if($d[$index]){
						//$this->MultiCell($cell['width']*$metrics[$index],$cell['height'],'----');
						$this->CenterText($v_lines[$ptr]+(($cell['width']*$metrics[$index])*.5),$h_lines[$i]+($cell['height']*0.75),'----');
					}
				}else{
					//$this->SetXY($v_lines[$ptr],$h_lines[$i]);
					//$this->MultiCell($cell['width']*$metrics[$index],$cell['height'],$d[$index]);
					
					$this->CenterText($v_lines[$ptr]+(($cell['width']*$metrics[$index])*.5),$h_lines[$i]+($cell['height']*0.75),$d[$index]);
				}
				$ptr+=$metrics[$index];
			}
		}
	
	}
	
	public function CenterText($disp_x,$disp_y,$str){
			$disp_x = $disp_x - $this->GetStringWidth($str)*0.5;
			$this->Text($disp_x,$disp_y,$str);	
		}
	public function get_fsize($str,$fsize,$cellwidth){
		$const_w=$cellwidth;
		do{				
			$this->SetFont('Arial','',$fsize);
			$const =round($this->GetStringWidth($str),2);
			$fsize-=0.1;
		}while($const>$const_w*0.90);
		return $fsize;
	}
	public function DrawHorLines($x1,$y1,$x2,$y2,$h,$rows,$show=false){
			$H=$h/$rows;
			$h_lines=array();
			for($index=0;$index<$rows+1;$index++){
				$X1=$x1;
				$Y1=$y1+($H*$index);
				$X2=$x2;
				$Y2=$y2+($H*$index);
				array_push($h_lines,$Y1);
				if($show){$this->Line($X1,$Y1,$X2,$Y2);}
			}
			return $h_lines;
	}
	
	public function DrawVerLines($x1,$y1,$x2,$y2,$w,$cols,$show=false){
		$W=$w/$cols;
		$v_lines=array();
		for($index=0; $index<$cols+1; $index++){
			$X1=$x1+($W*$index);
			$Y1=$y1;
			$X2=$x2+($W*$index);
			$Y2=$y2;
			array_push($v_lines,$X1);
			if($show){
				$this->Line($X1,$Y1,$X2,$Y2);
			}
		}
		return $v_lines;
	}
	public function DrawRectangle($height=6.30,$width=13.40,$x=0,$y=0){
		$this->SetFillColor(255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0);
		$this->SetLineWidth(0.001);
		//$this->Rect($x,$y,$width,$height,"FD");
	}
			
}
 error_reporting (0);
$COGS = new COGSheet('P','in',array(11.00,8.5));
$cog_info = json_decode($_POST['cog_info'], true);
$cog_dtl = json_decode($_POST['cog_dtl'],true);
$cog_type = $_POST['cog_type'];
if($cog_type=="NEW"){
$cog_dtl[count($cog_dtl)-1][count($cog_dtl[count($cog_dtl)-1])-1]="";
}else{
	$cog_dtl[count($cog_dtl)-1][count($cog_dtl[count($cog_dtl)-1])-2]=1;
}
$COGS->init();

//COG Info
$ROWS = 3;
$COLS = 16;
$width = 8;
$height = 0.60;
$x =($COGS->w/2)-($width/2);
$y = 0.60;
$cell['width']=$width/$COLS;
$cell['height']=$height/($ROWS+1);
$COGS->DrawRectangle($height,$width,$x,$y);
$v_lines = $COGS->DrawVerLines($x,$y,$x,$y+$height,$width,$COLS);
$h_lines = $COGS->DrawHorLines($x,$y,$x+$width,$y,$height,$ROWS);
$COGS->buildHead($cog_info,$v_lines,$h_lines,$cell,0,$cog_type);

$y = 0.60+5.5;
$v_lines = $COGS->DrawVerLines($x,$y,$x,$y+$height,$width,$COLS);
$h_lines = $COGS->DrawHorLines($x,$y,$x+$width,$y,$height,$ROWS);
$COGS->buildHead($cog_info,$v_lines,$h_lines,$cell,5.5,$cog_type);



$height = 3;
$width=5;
$ROWS = count($cog_dtl)+1;
$x =($COGS->w/2)-($width/2);
$y = 1.3;
$cell['width']=$width/$COLS;
$cell['height']=$height/$ROWS;


$COGS->DrawRectangle($height,$width,$x,$y);
$v_lines = $COGS->DrawVerLines($x,$y,$x,$y+$height,$width,$COLS);
$h_lines = $COGS->DrawHorLines($x,$y,$x+$width,$y,$height,$ROWS,true);
$COGS->buildDetails($cog_dtl,$v_lines,$h_lines,$cell,$cog_type);
$y = 1.3+5.5;
$COGS->DrawRectangle($height,$width,$x,$y);
$v_lines = $COGS->DrawVerLines($x,$y,$x,$y+$height,$width,$COLS);
$h_lines = $COGS->DrawHorLines($x,$y,$x+$width,$y,$height,$ROWS,true);
$COGS->buildDetails($cog_dtl,$v_lines,$h_lines,$cell,$cog_type);

$COGS->Line(0,$COGS->h/2,$COGS->w,$COGS->h/2);

$ROWS = 3;
$COLS = 16;
$width = 8;
$height = 0.35;
$x =($COGS->w/2)-($width/2);
$y = 4.37;
$cell['width']=$width/$COLS;
$cell['height']=$height/($ROWS+1);
$v_lines = $COGS->DrawVerLines($x,$y,$x,$y+$height,$width,$COLS);
$h_lines = $COGS->DrawHorLines($x,$y,$x+$width,$y,$height,$ROWS);
$COGS->buildFoot($v_lines,$h_lines,$cell,0,$cog_type);

$y = 4.37+5.5;
$v_lines = $COGS->DrawVerLines($x,$y,$x,$y+$height,$width,$COLS);
$h_lines = $COGS->DrawHorLines($x,$y,$x+$width,$y,$height,$ROWS);
$COGS->buildFoot($v_lines,$h_lines,$cell,0,$cog_type);

$COGS->Output();

?>