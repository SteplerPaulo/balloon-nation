<?php
//Academic Ranking
include_once('../header.php');
include('overallRanking.php');
$EGB->db_connect();
$data =json_decode($_POST['prnt_data'],true);
$info = array();
$info['sy'] =$_POST['prnt_sy'];
switch($_POST['prnt_period']){
	case 1: 
		$period = "1st Grading";
		break;
	case 2:
		$period = "2nd Grading";
		break;
	case 3:
		$period = "3rd Grading";
		break;
	case 4:
		$period = "4th Grading";
		break;
	
}
$info['period'] =$period;
$student=count($data);
//print_r($data);exit();
$gryrlv = array(
				  'PS'=>array('Nursery','Kinder 1','Kinder 2'),
				  'GS'=>array('Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'),
				  'HS'=>array('Grade 7', 'Second Year', 'Third Year','Fourth Year'),
				);
$info['yr_lvl']  =strtoupper( $gryrlv[$_POST['prnt_educlvl']][$_POST['prnt_gryrlvl']-1]);
$ROWS = 27;
$i = 0;
$next_index = 0;
$student=count($data);
$total_page = ceil($student/$ROWS);
$rc= new academicRanking();
while ($i<$total_page){
	$rc->hdr($info);
	$next_index = $rc->table($data,$next_index,$ROWS);
	if($i+1<$total_page){
		$rc->createSheet();
	}
	$i++;
}
$rc->output();

?>