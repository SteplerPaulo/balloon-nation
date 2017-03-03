<?php
require('fpdf17/fpdf.php');
	class FormSheet extends FPDF{
		private $FONT_CONST = 0.50;
		public $GRID = array();
		protected $showLines=true;
		protected $_colorful =true;
		public function createSheet($type=null,$title=null,$img=null){
			$this->AddPage();
			$this->SetMargins(0,0);
			if($img){
					$this->Image($img,0,0,$this->w,$this->h);
			}
		}
		
		public function createGrid($base_x ,$base_y,$width,$height,$rows,$cols){
			$grid = array();
			//Compute Grid Metrics
			$grid['font_size']  = $cols<15?9:round(100/($cols*$this->FONT_CONST));
			$grid['width'] = $width;
			$grid['cell_width'] = $width/$cols;
			$grid['cell_height']= $height/$rows;
			$grid['height']= $height;
			$grid['base_x']=$base_x;
			$grid['base_y']=$base_y;
			//Create Grid
			$grid['v_lines'] = $this->DrawHorLines($base_x ,$base_y,$base_x +$width,$base_y,$height,$rows);
			$grid['h_lines'] = $this->DrawVerLines($base_x ,$base_y,$base_x ,$base_y+$height,$width,$cols);
		
			$this->GRID = $grid;
		}
		protected function section($metrics){
			$this->createGrid($metrics['base_x'] ,$metrics['base_y'],$metrics['width'],$metrics['height'],$metrics['rows'],$metrics['cols']);
			$this->SetDrawColor(0);
			if(isset($metrics['border'])){
				$this->Rect($metrics['base_x'],$metrics['base_y'],$metrics['width'],$metrics['height']);
			}
		}
		public function putText($x,$y,$txt,$style=''){
			$this->SetFont('Arial',$style,$this->GRID['font_size']);
			$this->Text($this->GRID['base_x']+($this->GRID['cell_width']*$x),$this->GRID['base_y']+($this->GRID['cell_height']*$y),$txt);			
		}
		
		public function leftText($x,$y,$txt,$w,$style=''){
			$this->putText($x,$y,$txt,$style);
		}
		
		public function fitText($x,$y,$txt,$w,$style=''){
			$font_size = $this->GRID['font_size'];
			$this->SetFont('Arial','',10);
			$const =round($this->GetStringWidth($txt),2);
			while($const>$w*0.6){				
				$this->SetFont('Arial','',$font_size);
				$const =round($this->GetStringWidth($txt),2);
				$font_size-=0.1;
			}
			$this->Text($this->GRID['base_x']+($this->GRID['cell_width']*$x),$this->GRID['base_y']+($this->GRID['cell_height']*$y),$txt);
		}
		public function fitParagraph($x,$y,$txt,$w,$align='l',$lnbrk=1){
			$words = explode(" ", $txt);	
			$paragraph = array();
			$width = $w;
			foreach($words as $word){
				$wo = array(
							'len'=>$this->GetStringWidth($word)/$this->GRID['cell_width'],
							'word'=>$word
						);
				array_push($paragraph,$wo);
			}
			$line='';
			$len = 0;
			$ctr = 1;
			foreach($paragraph as $p){
					$len = $len+$p['len'];
					$line = $line.$p['word'].' ';
				if($len>$width||$ctr == count($paragraph)){
					switch($align){
						case 'l':
							$this->leftText($x,$y,$line,$width,'');
							break;
						case 'r':
							$this->rightText($x,$y,$line,$width,'');
							break;
						case 'c':
							$this->centerText($x,$y,$line,$width,'');
							break;
					}
					$line='';
					$len=0;
					$y+=$lnbrk;
				}
				$ctr++;
			}
		}
		
		public function wrapText($x,$y,$txt,$w,$align='l',$lnbrk=1){
			$this->SetFont('Arial','',$this->GRID['font_size']);
			$disp_x = $this->GRID['base_x']+($this->GRID['cell_width']*$x);
			$disp_y = $this->GRID['base_y']+($this->GRID['cell_height']*$y);
			$disp_w = $this->GRID['cell_width'] * $w;
			$disp_h =  $this->GRID['cell_height'] *$lnbrk;
			$this->SetXY($disp_x,$disp_y);
			$this->MultiCell($disp_w, $disp_h, $txt,0,$align);
		}
		public function centerText($x,$y,$txt,$w,$style=''){
			$this->SetFont('Arial',$style,$this->GRID['font_size']);
			$disp_x = $this->GRID['base_x']+($this->GRID['cell_width']*$x);
			$disp_x += ($this->GRID['cell_width']*$w)/2;
			$disp_y = $this->GRID['base_y']+($this->GRID['cell_height']*$y);
			$disp_x = $disp_x - $this->GetStringWidth($txt)*0.5;
			$this->Text($disp_x,$disp_y,$txt);
		}
		public function rightText($x,$y,$txt,$w,$style=''){
			$disp_x = $this->GRID['base_x']+($this->GRID['cell_width']*$x);
			$disp_y = $this->GRID['base_y']+($this->GRID['cell_height']*$y);
			$disp_x = $disp_x - $this->GetStringWidth($txt);
			$disp_x = $disp_x +($this->GRID['cell_width']*$w);
			$this->SetFont('Arial',$style,$this->GRID['font_size']);
			$this->Text($disp_x,$disp_y,$txt);
		}
		public function DrawLine($pt,$ort,$plot=null) {
			if($ort=='v'){
				if(empty($plot)){
					$plot =  array(0,$this->GRID['height']/$this->GRID['cell_height']);
				}
				$x1=$this->GRID['base_x']+($this->GRID['cell_width']*$pt);
				$y1=$this->GRID['base_y']+($this->GRID['cell_height']*$plot[0]);
				$x2=$this->GRID['base_x']+($this->GRID['cell_width']*$pt);
				$y2=$y1+($this->GRID['height'] - ($this->GRID['height']-($this->GRID['cell_height']*$plot[1])));
			}else if($ort=='h'){
				if(empty($plot)){
					$plot =  array(0,$this->GRID['width']/$this->GRID['cell_width']);
				}
				$x1=$this->GRID['base_x']+($this->GRID['cell_width']*$plot[0]);
				$y1=$this->GRID['base_y']+($this->GRID['cell_height']*$pt);
				$x2=$x1+($this->GRID['width'] - ($this->GRID['width']-($this->GRID['cell_width']*$plot[1])));
				$y2=$this->GRID['base_y']+($this->GRID['cell_height']*$pt);
				
			}
			$this->Line($x1,$y1,$x2,$y2);
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
				if($this->showLines){
					if($index%4!=0){
						$this->SetDrawColor(223,224,246);
					}else{
						$this->SetDrawColor(255,0,0);				
					}
					$this->Line($X1,$Y1,$X2,$Y2);
				}
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
				if($this->showLines){
					if($index%4!=0){
						$this->SetDrawColor(223,224,246);
					}else{
						$this->SetDrawColor(255,0,0);				
					}
					$this->Line($X1,$Y1,$X2,$Y2);
				}
			}
			return $v_lines;
		}
		
		protected function DrawMulitpleLines($start_at,$ln_count,$step=1,$orient='h'){
			$ctrs = array();
			for($ctr=$start_at;$ctr<=$ln_count;$ctr+=$step){
				$this->DrawLine($ctr,$orient);
				array_push($ctrs,$ctr);
			}
			return $ctrs;
		}
		
		public function DrawBox($x,$y,$w,$h,$fill=null){
			$x1=$this->GRID['base_x']+($this->GRID['cell_width']*$x);
			$y1=$this->GRID['base_y']+($this->GRID['cell_height']*$y);
			$w1 =$this->GRID['cell_width']*$w;
			$h1 =$this->GRID['cell_height']*$h;
			$this->Rect($x1,$y1,$w1,$h1,$fill);
		}
		
		public function DrawBarcode($x,$y,$code,$format='int25'){
			$fontSize = 8;
			$marge    = 8/$this->k;   // between barcode and hri in pixel
			$x		  = $this->GRID['base_x']+($this->GRID['cell_width']*$x);
			$y		  = $this->GRID['base_y']+($this->GRID['cell_height']*$y);
			$height   =	18/$this->k;  // barcode height in 1D ; module size in 2D
			$width    = 1.3/$this->k;    // barcode height in 1D ; not use in 2D
			$angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
			$type     = $format;
			$color    = '000000'; // color in hexa
			$data = Barcode::fpdf($this, $color, $x, $y, $angle, $type, array('code'=>$code,'rect'=>true,'b2d'=>true), $width, $height);
			$len = $this->GetStringWidth($data['hri']);
			Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
			$this->RotateText($x + $xt, $y + $yt, $data['hri'], $angle);
			return $data;
		}
		
		protected function RotateText($x, $y, $txt, $txt_angle, $font_angle=0){
			$font_angle+=90+$txt_angle;
			$txt_angle*=M_PI/180;
			$font_angle*=M_PI/180;		
			$txt_dx=cos($txt_angle);
			$txt_dy=sin($txt_angle);
			$font_dx=cos($font_angle);
			$font_dy=sin($font_angle);	
			$this->SetFont('Arial','',$this->GRID['font_size']);
			$x = $this->GRID['base_x']+($this->GRID['cell_width']*$x);
			$y = $this->GRID['base_y']+($this->GRID['cell_height']*$y);
			
			$s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',$txt_dx,$txt_dy,$font_dx,$font_dy,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
			if ($this->ColorFlag)
				$s='q '.$this->TextColor.' '.$s.' Q';
			$this->_out($s);
		}
		/**DRAW a handy multiple lines**/
		protected function DrawMultipleLines($start_at,$ln_count,$step=1,$orient='h'){
			$ctrs = array();
			for($ctr=$start_at;$ctr<=$ln_count;$ctr+=$step){
				$this->DrawLine($ctr,$orient);
				array_push($ctrs,$ctr);
			}
			return $ctrs;
		}
		/**DRAW image using the Grid's metrics**/
		public function DrawImage($x,$y,$w,$h,$path){
			$x1=$this->GRID['base_x']+($this->GRID['cell_width']*$x);
			$y1=$this->GRID['base_y']+($this->GRID['cell_height']*$y);
			$w1 =$this->GRID['cell_width']*$w;
			$h1 =$this->GRID['cell_height']*$h;
			$this->Image($path,$x1,$y1,$w,$h);
		}
		/** BY pass default SetDrawColor for control**/
		public function SetDrawColor($r, $g=null, $b=null){
			// Set color for all stroking operations
			if(($r==0 && $g==0 && $b==0) || $g===null)
				$g=$b=$r;
			if($this->_colorful){
				parent::SetDrawColor($r,$g,$b);
			}
		}
		/**DRAW a smart line using NEWS**/
		public function DrawNEWSLine($x,$y,$w,$h,$o){
			$orient =  str_split($o,1);
			//Orientation using cardinal directions North,East,West,South
			foreach($orient as $or){
				switch (strtoupper($or)){
					case 'N':
						$this->DrawLine($y,'h',array($x,$w));
						break;
					case 'S':
						$this->DrawLine($h,'h',array($x,$w));
						break;
					case 'E':
						$this->DrawLine($x+$w,'v',array($y,$h-$y));
						break;
					case 'W':
						$this->DrawLine($x,'v',array($y,$h-$y));
						break;
				}
			}
		}
	
	}
?>