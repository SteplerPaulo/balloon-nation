<?php
App::import('Vendor','deleted_deliveries');

//pr($data);exit;



$array_chunk =array_chunk($data, 46);


$report= new DeletedDeliveries();
foreach($array_chunk as $key => $products){
	$report->hdr();
	$report->dtls($products);	
	if(count($array_chunk) != $key+1){$report->createSheet();}
}
$report->output();



?>