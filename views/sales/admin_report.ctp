<?php
App::import('Vendor','sales_report');
//pr($data);exit;

$chunk_data = array_chunk($data['SaleDetail'],41,true);
$i = 1;
$report= new SalesReport();
foreach($chunk_data as $dt){
	$report->hdr($data);
	$report->dtls($dt,$i);
	if(count($chunk_data) != ($i++)){
		$report->createSheet();
	}
}
$report->output();



?>