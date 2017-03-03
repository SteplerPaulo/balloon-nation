<?php
include_once('../header.php');
include_once('OverallSheet.php');

$master_sheet = new MasterSheet('P','in',array(8.5,13));
$info = json_decode($_POST['info']);
$data =json_decode($_POST['dataset']);
$subjects = json_decode($_POST['alias']);
$info['months'] = json_decode($_POST['months']);
$EGB->db_connect();
$seccode =explode("-",$info[2]);
$section=$EGB->get_sec_alias($seccode[0]);
$gryrlv = array(
				  'PS'=>array('Nursery','Kinder 1','Kinder 2'),
				  'GS'=>array('Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'),
				  'HS'=>array('First Year', 'Second Year', 'Third Year','Fourth Year'),
				);
$year_level =strtoupper( $gryrlv[$section[0]['dept']][$section[0]['level']-1]);
if(count($seccode)>2){
$info['yr_sec']=$gryrlv[$section[0]['dept']][$section[0]['level']-1];	
}else{
$info['yr_sec']=$gryrlv[$section[0]['dept']][$section[0]['level']-1].' '.$section[0]['section'];
}
$hasmaka = $section[0]['dept']!='PS';
$section = $section[0]['section'];
$info['year_level']=$year_level;
$info['section']=$section;

if(!$hasmaka){
	for($i=0;$i<count($data);$i++){
		$data[$i][count($subjects)+3] = $data[$i][count($subjects)+6];
		$data[$i][count($subjects)+5]= round($data[$i][count($subjects)+3]);
		$data[$i][count($subjects)+6]= $EGB->get_letter_grade($data[$i][count($subjects)+5],true);
		$tmp = $data[$i][count($subjects)+2] ;
		$data[$i][count($subjects)+2] =$data[$i][count($subjects)+3];
		$data[$i][count($subjects)+3]=$tmp;
	}
}
$EGB->db_close();
if(count($data)<=45){
	$master_sheet->create($subjects,$info,$data,$master_sheet->record_index,45,$hasmaka);
}else{
	
	while($master_sheet->record_index<count($data)){	
		$master_sheet->create($subjects,$info,$data,$master_sheet->record_index,40,$hasmaka);
	}
}
$master_sheet->out();
?>