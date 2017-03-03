<?php
include_once('../header.php');
$info = json_decode($_POST['info'],true);
$data =json_decode($_POST['dataset'],true);
$subjects = json_decode($_POST['alias'],true);
$info['months'] = json_decode($_POST['months'],true);
$EGB->db_connect();
$seccode =explode("-",$info[2]);
$section=$EGB->get_sec_alias($seccode[0]);
$gryrlv = array(
				  'PS'=>array('Nursery','Kinder 1','Kinder 2'),
				  'GS'=>array('Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'),
				  'HS'=>array('First Year', 'Second Year', 'Third Year','Fourth Year'),
				);

	include_once('MasterSheet.php');

$master_sheet = new MasterSheet('P','in',array(8.5,13));
$year_level =strtoupper( $gryrlv[$section[0]['dept']][$section[0]['level']-1]);
$hasmaka = $section[0]['dept']!='PS';
$info['yr_sec']=$year_level.' '.$section[0]['section'];
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