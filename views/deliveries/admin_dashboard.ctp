<?php
//pr($data);exit;
App::import('Vendor','dashboard');
$chunk_data = array_chunk($data,41,false);

$curr_page = 1;
$total_page = count($chunk_data);

$report= new Dashboard();
foreach($chunk_data as $dt){
	$report->hdr($year);
	$report->data($dt,$curr_page,$total_page);
	if(count($chunk_data) != ($curr_page++)){
		$report->createSheet();
	}
}
$report->output();
?>