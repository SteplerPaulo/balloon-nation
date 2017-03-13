<?php
//Academic Ranking
include_once('../header.php');
include('academicRanking.php');
$EGB->db_connect();
$info = json_decode($_POST['info'],true);
$data =json_decode($_POST['dataset'],true);
$alias =json_decode($_POST['alias'],true);
$limit = 10;//$info[6];
$i=0;
$rank_index =count($data[0])-2;
foreach($data as $d){
	if($d[$rank_index]<=$limit){
		$i++;
	}
}
$data = array_splice($data, 0 , $i);
//echo "<pre>";print_r($data);exit();
$seccode =explode("-",$info[2]);
$section=$EGB->get_sec_alias($seccode[0]);
$gryrlv = array(
				  'PS'=>array('Nursery','Kinder 1','Kinder 2'),
				  'GS'=>array('Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'),
				  'HS'=>array('Grade 7', 'Second Year', 'Third Year','Fourth Year'),
				);
$year_level =strtoupper( $gryrlv[$section[0]['dept']][$section[0]['level']-1]);
$info['sy'] = $info[0];
$info['period'] = $info[1];
$sy=explode("-",$info[0]);
$hasmaka = $section[0]['dept']!='PS';
$info['yr_sec']=$year_level.' '.$section[0]['section'];
$section = $section[0]['section'];
$info['year_level']=$year_level;
$info['section']=$section;
$info['alias']=$alias;

$a=$EGB->get_adviser($seccode[0], $sy[0]);
$adviser =$EGB->get_users($a['fid']);
$adviser_name =strtoupper(utf8_decode($adviser['first_name'].' '.$adviser['last_name'].' '.$adviser['middle_name'][0].'.'));
$info['adviser']=$adviser_name;

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