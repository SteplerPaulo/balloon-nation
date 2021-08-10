<?php
if($new){
	App::import('Vendor','delivery_receipt_new');
	$chunk_data = array_chunk($data['DeliveryDetail'],72,false);
}else{
	App::import('Vendor','delivery_receipt');
	$chunk_data = array_chunk($data['DeliveryDetail'],30,false);
}

$i = 1;
$report= new DeliveryReceipt();
foreach($chunk_data as $dt){
	$report->blue_print();
	$report->data($data,$dt);
	if(count($chunk_data) != ($i++)){
		$report->createSheet();
	}
}
$report->output();
?>