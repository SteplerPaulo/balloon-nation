<?php
App::import('Vendor','yearly_report');
//pr($data);exit;
$report= new YearlyReport();

foreach($data as $d){
	
	$chunk_data = array_chunk($d['SaleDetail'],41,true);
	$i = 1;
	foreach($chunk_data as $dt){
		//pr($d);exit;
		//pr($dt);exit;
		$report->hdr($d);
		$report->dtls($dt,$i);
		if(count($chunk_data) != ($i++)){
			$report->createSheet();
		}
	}
	$report->createSheet();
}
$report->net_income();


$report->output();



?>